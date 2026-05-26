<?php
/**
 * PRISM — Google Calendar API Backend
 * ════════════════════════════════════
 * Called via fetch() from prism-booking.php — not visited directly.
 * Uses native PHP only (curl + mail) — no WordPress dependency.
 *
 * Endpoints (via ?action=):
 *   slots  → returns available 30-min slots for a given date
 *   book   → creates a calendar event and sends confirmation email
 */

// ── Bootstrap: try WordPress first, fall back to native PHP ──────────────
$wp_loaded = false;
$wp_search = dirname(__FILE__);
for ($i = 0; $i < 7; $i++) {
    $wp_search = dirname($wp_search);
    if (file_exists($wp_search . '/wp-load.php')) {
        require_once($wp_search . '/wp-load.php');
        $wp_loaded = true;
        break;
    }
}

require_once(__DIR__ . '/prism-config.php');

header('Content-Type: application/json');
header('X-Robots-Tag: noindex');

// ── Native HTTP helper (works with or without WordPress) ──────────────────
function prism_http($url, $method = 'GET', $headers = [], $body = null) {
    if (function_exists('curl_init')) {
        $ch = curl_init($url);
        $header_arr = [];
        foreach ($headers as $k => $v) $header_arr[] = "$k: $v";
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT        => 15,
            CURLOPT_SSL_VERIFYPEER => true,
            CURLOPT_HTTPHEADER     => $header_arr,
            CURLOPT_CUSTOMREQUEST  => $method,
        ]);
        if ($body) curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
        $result = curl_exec($ch);
        $err    = curl_error($ch);
        curl_close($ch);
        if ($err) {
            http_response_code(500);
            die(json_encode(['error' => 'cURL error: ' . $err]));
        }
        return $result;
    }
    // Fallback: stream context
    $ctx_headers = '';
    foreach ($headers as $k => $v) $ctx_headers .= "$k: $v\r\n";
    $opts = [
        'http' => [
            'method'        => $method,
            'header'        => $ctx_headers,
            'content'       => $body,
            'timeout'       => 15,
            'ignore_errors' => true,
        ],
    ];
    return @file_get_contents($url, false, stream_context_create($opts));
}

function prism_http_post_form($url, $fields) {
    return prism_http($url, 'POST',
        ['Content-Type' => 'application/x-www-form-urlencoded'],
        http_build_query($fields)
    );
}

// ── Sanitization helpers (native, no WordPress needed) ────────────────────
function prism_sanitize($str) {
    return htmlspecialchars(strip_tags(trim((string)$str)), ENT_QUOTES, 'UTF-8');
}
function prism_sanitize_email($str) {
    return filter_var(trim($str), FILTER_SANITIZE_EMAIL);
}
function prism_is_email($str) {
    return filter_var($str, FILTER_VALIDATE_EMAIL) !== false;
}
function prism_sanitize_url($str) {
    return filter_var(trim($str), FILTER_SANITIZE_URL);
}

// ── Send email (WordPress if available, native mail() fallback) ───────────
function prism_send_mail($to, $subject, $body, $from) {
    if (function_exists('wp_mail')) {
        wp_mail($to, $subject, $body, ["From: $from"]);
    } else {
        $headers = "From: $from\r\nContent-Type: text/plain; charset=UTF-8\r\n";
        mail($to, $subject, $body, $headers);
    }
}

// ── Token management ──────────────────────────────────────────────────────
function prism_get_access_token() {
    if (!file_exists(PRISM_TOKEN_FILE)) {
        http_response_code(500);
        die(json_encode(['error' => 'Not authorized. Run the OAuth setup first: ' .
            'https://prism.film/wp-content/themes/hello-biz/prism-oauth-callback.php?setup=1']));
    }

    $token   = json_decode(file_get_contents(PRISM_TOKEN_FILE), true);
    $expired = ($token['created'] + $token['expires_in'] - 60) < time();

    if ($expired && !empty($token['refresh_token'])) {
        $raw = prism_http_post_form('https://oauth2.googleapis.com/token', [
            'client_id'     => PRISM_GOOGLE_CLIENT_ID,
            'client_secret' => PRISM_GOOGLE_CLIENT_SECRET,
            'refresh_token' => $token['refresh_token'],
            'grant_type'    => 'refresh_token',
        ]);

        $new = json_decode($raw, true);
        if (!empty($new['access_token'])) {
            $new['refresh_token'] = $token['refresh_token'];
            $new['created']       = time();
            file_put_contents(PRISM_TOKEN_FILE, json_encode($new, JSON_PRETTY_PRINT));
            return $new['access_token'];
        }
    }

    return $token['access_token'];
}

// ── Google Calendar API helper ────────────────────────────────────────────
function prism_gcal($path, $method = 'GET', $body = null) {
    $token   = prism_get_access_token();
    $headers = ['Authorization' => 'Bearer ' . $token];
    $payload = null;

    if ($body) {
        $headers['Content-Type'] = 'application/json';
        $payload = json_encode($body);
    }

    $raw  = prism_http('https://www.googleapis.com/calendar/v3' . $path, $method, $headers, $payload);
    $data = json_decode($raw, true);

    if (isset($data['error'])) {
        http_response_code(500);
        die(json_encode(['error' => 'Google API error', 'detail' => $data['error']]));
    }

    return $data;
}

// ── Action: get available slots ───────────────────────────────────────────
function prism_get_slots() {
    $date = prism_sanitize($_GET['date'] ?? '');

    if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) {
        http_response_code(400);
        die(json_encode(['error' => 'Invalid date. Use YYYY-MM-DD.']));
    }

    $tz        = new DateTimeZone('Europe/Paris');
    $day_start = new DateTime($date . ' 09:00:00', $tz);
    $day_end   = new DateTime($date . ' 18:00:00', $tz);
    $now       = new DateTime('now', $tz);

    // Skip to now if date is today
    if ($day_start->format('Y-m-d') === $now->format('Y-m-d') && $now > $day_start) {
        $slot_len = PRISM_BOOKING_DURATION + PRISM_BOOKING_BUFFER;
        $mins     = (int)$now->format('i') + (int)$now->format('H') * 60;
        $rounded  = ceil($mins / $slot_len) * $slot_len;
        $day_start = new DateTime($date . ' 00:00:00', $tz);
        $day_start->modify('+' . $rounded . ' minutes');
    }

    $cal_id   = rawurlencode(PRISM_GOOGLE_CALENDAR_ID);
    $time_min = urlencode($day_start->format(DateTime::RFC3339));
    $time_max = urlencode($day_end->format(DateTime::RFC3339));

    $events = prism_gcal(
        "/calendars/{$cal_id}/events?timeMin={$time_min}&timeMax={$time_max}&singleEvents=true&orderBy=startTime"
    );

    // Build busy blocks (with buffer)
    $busy = [];
    foreach (($events['items'] ?? []) as $event) {
        if (!empty($event['start']['dateTime'])) {
            $s = new DateTime($event['start']['dateTime']);
            $e = new DateTime($event['end']['dateTime']);
            $e->modify('+' . PRISM_BOOKING_BUFFER . ' minutes');
            $busy[] = ['start' => $s, 'end' => $e];
        }
    }

    // Generate slots
    $slots    = [];
    $step     = PRISM_BOOKING_DURATION + PRISM_BOOKING_BUFFER;
    $cursor   = clone $day_start;

    while (true) {
        $slot_end = clone $cursor;
        $slot_end->modify('+' . PRISM_BOOKING_DURATION . ' minutes');
        if ($slot_end > $day_end) break;

        $free = true;
        foreach ($busy as $b) {
            if ($cursor < $b['end'] && $slot_end > $b['start']) {
                $free = false;
                break;
            }
        }

        if ($free) {
            $slots[] = [
                'start'   => $cursor->format(DateTime::RFC3339),
                'end'     => $slot_end->format(DateTime::RFC3339),
                'display' => $cursor->format('H:i'),
            ];
        }

        $cursor->modify('+' . $step . ' minutes');
    }

    echo json_encode(['date' => $date, 'slots' => $slots]);
}

// ── Action: create booking ────────────────────────────────────────────────
function prism_create_booking() {
    $input = json_decode(file_get_contents('php://input'), true);

    foreach (['name','email','website','start','end'] as $f) {
        if (empty($input[$f])) {
            http_response_code(400);
            die(json_encode(['error' => "Missing field: $f"]));
        }
    }

    $name    = prism_sanitize($input['name']);
    $email   = prism_sanitize_email($input['email']);
    $website = prism_sanitize_url($input['website']);
    $message = prism_sanitize($input['message'] ?? '');
    $start   = prism_sanitize($input['start']);
    $end     = prism_sanitize($input['end']);

    if (!prism_is_email($email)) {
        http_response_code(400);
        die(json_encode(['error' => 'Invalid email address.']));
    }

    $tz       = new DateTimeZone('Europe/Paris');
    $start_dt = new DateTime($start);
    $start_dt->setTimezone($tz);
    $display_date = $start_dt->format('l, F j Y');
    $display_time = $start_dt->format('H:i') . ' (Paris time)';

    $event = [
        'summary'     => 'PRISM Diagnostic — ' . $name,
        'description' => "Client: {$name}\nEmail: {$email}\nWebsite: {$website}\n\nMessage:\n{$message}",
        'start'       => ['dateTime' => $start, 'timeZone' => 'Europe/Paris'],
        'end'         => ['dateTime' => $end,   'timeZone' => 'Europe/Paris'],
        'attendees'   => [['email' => $email, 'displayName' => $name]],
        'conferenceData' => [
            'createRequest' => [
                'requestId'             => uniqid('prism_'),
                'conferenceSolutionKey' => ['type' => 'hangoutsMeet'],
            ],
        ],
        'reminders' => [
            'useDefault' => false,
            'overrides'  => [
                ['method' => 'email', 'minutes' => 1440],
                ['method' => 'popup', 'minutes' => 30],
            ],
        ],
    ];

    $cal_id  = rawurlencode(PRISM_GOOGLE_CALENDAR_ID);
    $created = prism_gcal(
        "/calendars/{$cal_id}/events?conferenceDataVersion=1&sendUpdates=all",
        'POST', $event
    );

    if (empty($created['id'])) {
        http_response_code(500);
        die(json_encode(['error' => 'Failed to create event.']));
    }

    $meet_link = $created['conferenceData']['entryPoints'][0]['uri'] ?? null;

    // Confirmation email to client
    $subject = 'Your PRISM diagnostic is confirmed';
    $body    = "Hi {$name},\n\n"
        . "Your strategic diagnostic with PRISM Filmmaking is confirmed.\n\n"
        . "Date:     {$display_date}\n"
        . "Time:     {$display_time}\n"
        . ($meet_link ? "Meet:     {$meet_link}\n" : '')
        . "\nA calendar invitation has been sent to {$email}.\n"
        . "If anything comes up, reply directly to this email.\n\n"
        . "— Michael Mietz\n"
        . "PRISM Filmmaking\ncontact@prism.film";

    prism_send_mail($email, $subject, $body, 'PRISM Filmmaking <contact@prism.film>');

    echo json_encode([
        'success'   => true,
        'event_id'  => $created['id'],
        'meet_link' => $meet_link,
        'date'      => $display_date,
        'time'      => $display_time,
    ]);
}

// ── Router ────────────────────────────────────────────────────────────────
$action = prism_sanitize($_GET['action'] ?? '');

switch ($action) {
    case 'slots':
        prism_get_slots();
        break;
    case 'book':
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            die(json_encode(['error' => 'POST required.']));
        }
        prism_create_booking();
        break;
    default:
        http_response_code(400);
        die(json_encode(['error' => 'Unknown action. Use ?action=slots or ?action=book']));
}
