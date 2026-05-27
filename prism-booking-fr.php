<?php
/**
 * Template Name: PRISM Booking Page — FR
 *
 * ─── SETUP ───────────────────────────────────────────────────────────────────
 * 1. Upload to: wp-content/themes/hello-biz/
 * 2. Make sure prism-config.php is in the same folder
 * 3. Complete the one-time OAuth setup first:
 *    Visit → https://prism.film/wp-content/themes/hello-biz/prism-oauth-callback.php?setup=1
 * 4. WordPress → Pages → New Page → Title: "Bookings"
 *    Slug: bookings → Template: "PRISM Booking Page" → Publish
 */

require_once(get_template_directory() . '/prism-config.php');
$api_url = get_template_directory_uri() . '/prism-booking-api.php';
?><!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Réserver un Diagnostic Stratégique — PRISM Filmmaking</title>
<?php wp_head(); ?>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500&family=DM+Serif+Display:ital@0;1&display=swap" rel="stylesheet">
<style>
*, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }
:root {
  --c-main: #FCFCFC; --c-dark: #0D0D0D; --c-blue: #03588C;
  --c-orange: #D9642A; --c-cream: #F2CDAC;
  --c-prism-a: #a8edff; --c-prism-b: #d4aaff;
  --font-display: 'Bebas Neue', sans-serif;
  --font-serif: 'DM Serif Display', serif;
  --font-body: 'DM Sans', sans-serif;
  --ease: cubic-bezier(0.25, 0.46, 0.45, 0.94);
}
html { scroll-behavior: smooth; }
body {
  font-family: var(--font-body);
  background: var(--c-dark);
  color: var(--c-main);
  overflow-x: hidden;
  min-height: 100vh;
  padding: 0 !important; margin: 0 !important;
}
.site-header, .site-footer, #masthead, #colophon,
.elementor-location-header, .elementor-location-footer { display: none !important; }

/* ── NAV ── */
nav {
  position: fixed; top: 0; left: 0; right: 0; z-index: 200;
  display: flex; align-items: center; justify-content: space-between;
  padding: 1.1rem 3rem;
  background: rgba(13,13,13,0.96);
  backdrop-filter: blur(16px);
  border-bottom: 1px solid rgba(255,255,255,0.05);
}
.nav-logo { text-decoration: none; display: flex; align-items: center; }
.nav-logo img { height: 40px; width: 40px; object-fit: contain;
  transition: transform .4s var(--ease), filter .4s; }
.nav-logo img:hover { transform: scale(1.10);
  filter: drop-shadow(0 0 8px rgba(168,237,255,.6)); }
.nav-back {
  font-size: .72rem; letter-spacing: .2em; text-transform: uppercase;
  color: rgba(252,252,252,.5); text-decoration: none;
  display: flex; align-items: center; gap: .5rem;
  transition: color .2s;
}
.nav-back::before { content: '←'; }
.nav-back:hover { color: var(--c-main); }
.lang-toggle {
  display: flex; align-items: center;
  border: 1px solid rgba(252,252,252,.15); overflow: hidden;
}
.lang-toggle a {
  font-size: .65rem; letter-spacing: .2em; text-transform: uppercase;
  padding: .45rem .75rem; color: rgba(252,252,252,.4);
  text-decoration: none; transition: background .2s, color .2s; line-height: 1;
}
.lang-toggle a:hover { color: var(--c-main); background: rgba(252,252,252,.06); }
.lang-toggle .lang-sep { width: 1px; background: rgba(252,252,252,.15); align-self: stretch; }

/* ── PAGE LAYOUT ── */
.booking-page {
  min-height: 100vh;
  padding: 120px 3rem 6rem;
  position: relative; overflow: hidden;
}
/* Prismatic background orbs */
.bp-prism-a {
  position: absolute; top: -10%; right: -5%;
  width: 50vw; height: 50vw;
  background: radial-gradient(ellipse, rgba(168,237,255,.12) 0%, rgba(212,170,255,.07) 45%, transparent 70%);
  filter: blur(70px); mix-blend-mode: screen; pointer-events: none;
  animation: prism-drift 14s ease-in-out infinite;
}
.bp-prism-b {
  position: absolute; bottom: 0; left: -10%;
  width: 40vw; height: 40vw;
  background: radial-gradient(ellipse, rgba(217,100,42,.1) 0%, transparent 70%);
  filter: blur(60px); mix-blend-mode: screen; pointer-events: none;
  animation: prism-drift 11s ease-in-out infinite reverse;
}
@keyframes prism-drift {
  0%,100% { transform: translate(0,0) scale(1); }
  50%      { transform: translate(2%,3%) scale(1.05); }
}
.spectrum-divider {
  width: 100%; height: 1px;
  background: linear-gradient(90deg, transparent, var(--c-prism-a) 20%,
    var(--c-prism-b) 55%, var(--c-orange) 75%, transparent);
  opacity: .3; margin-bottom: 4rem;
}
.booking-inner {
  max-width: 1100px; margin: 0 auto;
  display: grid; grid-template-columns: 1fr 1fr;
  gap: 6rem; align-items: start;
}

/* ── LEFT — Info ── */
.booking-info {}
.section-label {
  font-size: .65rem; letter-spacing: .45em; text-transform: uppercase;
  color: var(--c-orange); margin-bottom: 1rem;
  display: flex; align-items: center; gap: .75rem;
}
.section-label::before {
  content: ''; width: 22px; height: 1px;
  background: linear-gradient(90deg, var(--c-prism-a), var(--c-orange));
}
.booking-title {
  font-family: var(--font-display);
  font-size: clamp(3rem, 5vw, 5rem);
  line-height: .9; letter-spacing: .02em;
  color: var(--c-main); margin-bottom: 1.5rem;
}
.booking-title span { color: var(--c-orange); }
.booking-desc {
  font-size: 1rem; font-weight: 300; line-height: 1.8;
  color: rgba(252,252,252,.55); margin-bottom: 2.5rem; max-width: 420px;
}
.booking-meta { display: flex; flex-direction: column; gap: 1rem; }
.meta-item {
  display: flex; align-items: center; gap: 1rem;
  font-size: .85rem; font-weight: 300; color: rgba(252,252,252,.5);
}
.meta-icon {
  width: 36px; height: 36px; border: 1px solid rgba(252,252,252,.12);
  display: flex; align-items: center; justify-content: center;
  flex-shrink: 0; font-size: 1rem;
}
.meta-item strong { color: var(--c-main); font-weight: 400; display: block; }

/* ── RIGHT — Booking widget ── */
.booking-widget {
  background: rgba(252,252,252,.03);
  border: 1px solid rgba(252,252,252,.08);
  padding: 2.5rem;
}

/* Step indicators */
.steps-indicator {
  display: flex; align-items: center; gap: 0;
  margin-bottom: 2.5rem;
}
.step-ind {
  display: flex; align-items: center; gap: .6rem;
  font-size: .65rem; letter-spacing: .25em; text-transform: uppercase;
  color: rgba(252,252,252,.3);
}
.step-ind.active { color: var(--c-orange); }
.step-ind.done { color: rgba(252,252,252,.5); }
.step-num-ind {
  width: 24px; height: 24px;
  border: 1px solid currentColor;
  display: flex; align-items: center; justify-content: center;
  font-size: .7rem; font-family: var(--font-display);
  letter-spacing: 0; flex-shrink: 0;
}
.step-ind.done .step-num-ind { background: rgba(252,252,252,.1); }
.step-ind.active .step-num-ind { background: var(--c-orange); border-color: var(--c-orange); color: #fff; }
.step-connector {
  flex: 1; height: 1px;
  background: rgba(252,252,252,.1);
  margin: 0 .75rem;
}

/* ── STEP 1: Calendar ── */
#step-1 {}
.cal-header {
  display: flex; align-items: center; justify-content: space-between;
  margin-bottom: 1.5rem;
}
.cal-month {
  font-family: var(--font-display); font-size: 1.5rem;
  letter-spacing: .05em; color: var(--c-main);
}
.cal-nav {
  display: flex; gap: .5rem;
}
.cal-nav button {
  background: none; border: 1px solid rgba(252,252,252,.15);
  color: rgba(252,252,252,.5); width: 32px; height: 32px;
  cursor: pointer; font-size: 1rem;
  transition: border-color .2s, color .2s;
}
.cal-nav button:hover { border-color: var(--c-orange); color: var(--c-orange); }
.cal-grid {
  display: grid; grid-template-columns: repeat(7, 1fr);
  gap: 4px; margin-bottom: 1.5rem;
}
.cal-day-label {
  font-size: .62rem; letter-spacing: .2em; text-transform: uppercase;
  color: rgba(252,252,252,.3); text-align: center; padding: .4rem 0;
}
.cal-day {
  aspect-ratio: 1; display: flex; align-items: center; justify-content: center;
  font-size: .85rem; font-weight: 300; cursor: pointer;
  border: 1px solid transparent;
  transition: border-color .2s, color .2s, background .2s;
  color: rgba(252,252,252,.6);
}
.cal-day:hover:not(.empty):not(.past) {
  border-color: rgba(252,252,252,.2); color: var(--c-main);
}
.cal-day.today { color: var(--c-orange); }
.cal-day.selected {
  background: var(--c-orange); color: #fff !important;
  border-color: var(--c-orange) !important;
}
.cal-day.empty, .cal-day.past {
  cursor: default; opacity: .2; pointer-events: none;
}
.cal-day.weekend { opacity: .3; pointer-events: none; }

/* Slot picker */
.slots-header {
  font-size: .65rem; letter-spacing: .35em; text-transform: uppercase;
  color: rgba(252,252,252,.4); margin-bottom: 1rem;
}
.slots-grid {
  display: grid; grid-template-columns: repeat(3, 1fr);
  gap: .5rem; margin-bottom: 2rem;
}
.slot-btn {
  padding: .65rem .5rem;
  border: 1px solid rgba(252,252,252,.12);
  background: none; color: rgba(252,252,252,.6);
  font-family: var(--font-body); font-size: .85rem;
  cursor: pointer; transition: border-color .2s, color .2s, background .2s;
  text-align: center;
}
.slot-btn:hover { border-color: var(--c-orange); color: var(--c-orange); }
.slot-btn.selected { background: var(--c-orange); border-color: var(--c-orange); color: #fff; }
.slots-loading, .slots-empty {
  font-size: .85rem; font-weight: 300; color: rgba(252,252,252,.35);
  padding: 1.5rem 0; text-align: center;
}
.slots-loading::after {
  content: ''; display: inline-block;
  width: 12px; height: 12px; margin-left: .5rem;
  border: 1px solid rgba(252,252,252,.3);
  border-top-color: var(--c-orange);
  border-radius: 50%;
  animation: spin .7s linear infinite;
  vertical-align: middle;
}
@keyframes spin { to { transform: rotate(360deg); } }

.btn-next, .btn-back, .btn-submit {
  width: 100%; padding: 1rem;
  font-family: var(--font-body); font-size: .78rem;
  letter-spacing: .2em; text-transform: uppercase;
  cursor: pointer; transition: background .25s, transform .2s, box-shadow .3s;
  border: none;
}
.btn-next, .btn-submit {
  background: var(--c-orange); color: #fff;
}
.btn-next:hover, .btn-submit:hover {
  background: #c05521; transform: translateY(-1px);
  box-shadow: 0 8px 24px rgba(217,100,42,.35);
}
.btn-next:disabled, .btn-submit:disabled {
  opacity: .35; cursor: not-allowed; transform: none; box-shadow: none;
}
.btn-back {
  background: none; border: 1px solid rgba(252,252,252,.15);
  color: rgba(252,252,252,.5); margin-bottom: .75rem;
}
.btn-back:hover { border-color: rgba(252,252,252,.4); color: var(--c-main); }

/* ── STEP 2: Form ── */
#step-2 { display: none; }
#step-2.visible { display: block !important; }
#step-1.visible { display: block !important; }
#step-3.visible { display: block !important; }

/* Hard overrides — prevent hello-biz theme from collapsing form elements */
.booking-widget .selected-slot-display {
  padding: 1rem 1.25rem !important;
  border: 1px solid rgba(217,100,42,.3) !important;
  margin-bottom: 2rem !important;
  font-size: .85rem !important; font-weight: 300 !important;
  color: rgba(252,252,252,.6) !important;
  display: block !important;
  background: transparent !important;
}
.booking-widget .selected-slot-display strong {
  color: var(--c-orange) !important; display: block !important;
  margin-bottom: .2rem !important; font-weight: 400 !important;
  font-size: .65rem !important; letter-spacing: .25em !important;
  text-transform: uppercase !important;
}
.booking-widget .form-group {
  margin-bottom: 1.25rem !important;
  display: block !important;
}
.booking-widget .form-label {
  display: block !important; font-size: .65rem !important;
  letter-spacing: .3em !important; text-transform: uppercase !important;
  color: rgba(252,252,252,.4) !important; margin-bottom: .5rem !important;
  font-family: var(--font-body) !important; font-weight: 400 !important;
}
.booking-widget .form-input,
.booking-widget .form-textarea {
  display: block !important;
  width: 100% !important;
  background: rgba(252,252,252,.04) !important;
  border: 1px solid rgba(252,252,252,.15) !important;
  border-radius: 0 !important;
  color: #FCFCFC !important;
  font-family: var(--font-body) !important;
  font-size: .95rem !important; font-weight: 300 !important;
  padding: .85rem 1rem !important;
  margin: 0 !important;
  box-shadow: none !important;
  transition: border-color .25s !important;
  outline: none !important;
  -webkit-appearance: none !important;
  appearance: none !important;
  line-height: 1.5 !important;
  height: auto !important;
}
.booking-widget .form-input:focus,
.booking-widget .form-textarea:focus {
  border-color: var(--c-orange) !important;
  background: rgba(252,252,252,.06) !important;
  box-shadow: none !important;
  outline: none !important;
}
.booking-widget .form-input::placeholder,
.booking-widget .form-textarea::placeholder {
  color: rgba(252,252,252,.25) !important;
}
.booking-widget .form-textarea {
  resize: vertical !important;
  min-height: 110px !important;
}
.booking-widget .form-row {
  display: grid !important;
  grid-template-columns: 1fr 1fr !important;
  gap: 1rem !important;
}
.form-error {
  font-size: .75rem; color: #ff6b6b;
  margin-top: .4rem; display: none;
}

/* ── STEP 3: Confirmation ── */
#step-3 { display: none; text-align: center; padding: 2rem 0; }
.confirm-icon {
  width: 64px; height: 64px; margin: 0 auto 1.5rem;
  border: 1px solid var(--c-orange);
  display: flex; align-items: center; justify-content: center;
  font-size: 1.8rem;
}
.confirm-title {
  font-family: var(--font-display); font-size: 2.5rem;
  letter-spacing: .05em; color: var(--c-main); margin-bottom: .75rem;
}
.confirm-subtitle {
  font-size: .95rem; font-weight: 300; line-height: 1.75;
  color: rgba(252,252,252,.55); max-width: 360px; margin: 0 auto 2rem;
}
.confirm-detail {
  padding: 1.25rem; border: 1px solid rgba(252,252,252,.08);
  margin-bottom: 1.5rem; text-align: left;
}
.confirm-detail-row {
  display: flex; align-items: center; gap: .75rem;
  font-size: .85rem; font-weight: 300;
  color: rgba(252,252,252,.55); padding: .5rem 0;
  border-bottom: 1px solid rgba(252,252,252,.06);
}
.confirm-detail-row:last-child { border-bottom: none; }
.confirm-detail-row strong { color: var(--c-main); font-weight: 400; min-width: 80px; }
.confirm-meet {
  display: inline-flex; align-items: center; gap: .6rem;
  padding: .85rem 2rem; background: var(--c-blue);
  color: #fff; text-decoration: none; font-size: .78rem;
  letter-spacing: .15em; text-transform: uppercase;
  transition: background .2s;
}
.confirm-meet:hover { background: #024a78; }
.confirm-back {
  display: block; margin-top: 1.5rem;
  font-size: .75rem; letter-spacing: .2em; text-transform: uppercase;
  color: rgba(252,252,252,.3); text-decoration: none;
}
.confirm-back:hover { color: rgba(252,252,252,.6); }

/* ── Responsive ── */
/* ── Tablet ── */
@media (max-width: 900px) {
  nav { padding: 1rem 1.5rem; }
  .booking-page { padding: 90px 1.25rem 4rem; }
  .booking-inner { grid-template-columns: 1fr; gap: 2.5rem; }
  .slots-grid { grid-template-columns: repeat(4, 1fr); }
  .form-row { grid-template-columns: 1fr; }
}

/* ── Mobile ── */
@media (max-width: 600px) {
  nav {
    padding: 0.85rem 1rem;
    gap: 0.75rem;
  }
  .nav-logo img { height: 34px; width: 34px; }
  .nav-back {
    font-size: .6rem;
    letter-spacing: .12em;
  }
  .lang-toggle a { padding: .4rem .6rem; font-size: .6rem; }

  .booking-page { padding: 80px 1rem 3rem; }
  .booking-widget { padding: 1.5rem 1rem; }

  .steps-indicator { gap: 0; margin-bottom: 1.75rem; }
  .step-ind { font-size: .55rem; letter-spacing: .15em; gap: .4rem; }
  .step-num-ind { width: 20px; height: 20px; font-size: .65rem; }
  .step-connector { margin: 0 .4rem; }

  .cal-header { margin-bottom: 1rem; }
  .cal-month { font-size: 1.2rem; }
  .cal-nav button { width: 28px; height: 28px; font-size: .9rem; }
  .cal-grid { gap: 2px; margin-bottom: 1rem; }
  .cal-day-label { font-size: .55rem; padding: .3rem 0; letter-spacing: .1em; }
  .cal-day {
    aspect-ratio: unset !important;
    height: 36px;
    font-size: .8rem;
  }

  .slots-grid { grid-template-columns: repeat(3, 1fr); gap: .4rem; }
  .slot-btn { padding: .55rem .25rem; font-size: .8rem; }
  .slots-header { font-size: .6rem; }

  .btn-next, .btn-submit, .btn-back { font-size: .72rem; padding: .9rem; }

  .booking-widget .form-input,
  .booking-widget .form-textarea {
    font-size: .9rem !important;
    padding: .75rem .85rem !important;
  }

  .confirm-title { font-size: 2rem; }
  .confirm-detail-row { font-size: .8rem; }
}

/* ── Very small screens (≤380px) ── */
@media (max-width: 380px) {
  .slots-grid { grid-template-columns: repeat(2, 1fr); }
  .step-ind span, .step-ind { font-size: .5rem; }
  .booking-widget { padding: 1.25rem .85rem; }
}
</style>
</head>
<body>

<!-- NAV -->
<nav>
  <a href="<?php echo esc_url($url_fr); ?>" class="nav-logo">
    <img src="<?php echo esc_url($logo_url); ?>" alt="PRISM Filmmaking">
  </a>
  <a href="<?php echo esc_url($url_fr); ?>" class="nav-back">Retour au site</a>
  <div class="lang-toggle">
    <a href="<?php echo esc_url($url_booking_fr); ?>">FR</a>
    <span class="lang-sep"></span>
    <a href="<?php echo esc_url($url_booking_en); ?>">EN</a>
  </div>
</nav>

<div class="booking-page">
  <div class="bp-prism-a"></div>
  <div class="bp-prism-b"></div>

  <div class="spectrum-divider"></div>

  <div class="booking-inner">

    <!-- LEFT: Info -->
    <div class="booking-info">
      <p class="section-label">Diagnostic Stratégique</p>
      <h1 class="booking-title">Réservez vos<br><span>30 minutes.</span></h1>
      <p class="booking-desc">
        Pas un appel de vente. Une conversation ciblée pour déterminer si et comment PRISM peut rendre votre expertise impossible à ignorer.
      </p>
      <div class="booking-meta">
        <div class="meta-item">
          <div class="meta-icon">⏱</div>
          <div><strong>30 minutes</strong>Focalisé, sans détour</div>
        </div>
        <div class="meta-item">
          <div class="meta-icon">🎥</div>
          <div><strong>Google Meet</strong>Lien envoyé à la confirmation</div>
        </div>
        <div class="meta-item">
          <div class="meta-icon">✦</div>
          <div><strong>Diagnostic offert</strong>Vous repartez avec des insights actionnables</div>
        </div>
        <div class="meta-item">
          <div class="meta-icon">◈</div>
          <div><strong>3 projets par trimestre</strong>Les disponibilités sont réellement limitées</div>
        </div>
      </div>
    </div>

    <!-- RIGHT: Widget -->
    <div class="booking-widget">

      <!-- Step indicators -->
      <div class="steps-indicator">
        <div class="step-ind active" id="ind-1">
          <div class="step-num-ind">1</div>
          Date &amp; Heure
        </div>
        <div class="step-connector"></div>
        <div class="step-ind" id="ind-2">
          <div class="step-num-ind">2</div>
          Vos informations
        </div>
        <div class="step-connector"></div>
        <div class="step-ind" id="ind-3">
          <div class="step-num-ind">3</div>
          Confirmé
        </div>
      </div>

      <!-- STEP 1: Pick date + time -->
      <div id="step-1">
        <div class="cal-header">
          <div class="cal-month" id="cal-month-label"></div>
          <div class="cal-nav">
            <button id="cal-prev" aria-label="Previous month">‹</button>
            <button id="cal-next" aria-label="Next month">›</button>
          </div>
        </div>
        <div class="cal-grid" id="cal-grid"></div>
        <div id="slots-section" style="display:none;">
          <div class="slots-header" id="slots-header"></div>
          <div id="slots-container"></div>
        </div>
        <button class="btn-next" id="btn-step1-next" disabled>Continue →</button>
      </div>

      <!-- STEP 2: Contact form -->
      <div id="step-2">
        <div class="selected-slot-display" id="slot-display">
          <strong>Créneau sélectionné</strong>
          <span id="slot-display-text"></span>
        </div>
        <button class="btn-back" id="btn-back-1">← Modifier la date &amp; l'heure</button>
        <div class="form-row">
          <div class="form-group">
            <label class="form-label" for="f-name">Nom complet *</label>
            <input class="form-input" type="text" id="f-name" placeholder="Votre nom" required>
          </div>
          <div class="form-group">
            <label class="form-label" for="f-email">Email *</label>
            <input class="form-input" type="email" id="f-email" placeholder="vous@votreentreprise.com" required>
          </div>
        </div>
        <div class="form-group">
          <label class="form-label" for="f-website">Site web de l'entreprise *</label>
          <input class="form-input" type="url" id="f-website" placeholder="https://votreentreprise.com" required>
        </div>
        <div class="form-group">
          <label class="form-label" for="f-message">Que souhaitez-vous nous dire ?</label>
          <textarea class="form-textarea" id="f-message" placeholder="Parlez-nous de votre entreprise, vos objectifs, ou tout ce qui vous semble pertinent..."></textarea>
        </div>
        <button class="btn-submit" id="btn-submit">Confirmer la réservation →</button>
        <div id="form-error" class="form-error" style="display:none;margin-top:.75rem;font-size:.8rem;color:#ff6b6b;"></div>
      </div>

      <!-- STEP 3: Confirmation -->
      <div id="step-3">
        <div class="confirm-icon">✓</div>
        <div class="confirm-title">C'est confirmé.</div>
        <p class="confirm-subtitle">Une invitation calendrier et un email de confirmation vous ont été envoyés.</p>
        <div class="confirm-detail">
          <div class="confirm-detail-row"><strong>Date</strong><span id="conf-date"></span></div>
          <div class="confirm-detail-row"><strong>Heure</strong><span id="conf-time"></span></div>
          <div class="confirm-detail-row"><strong>Durée</strong>30 minutes</div>
          <div class="confirm-detail-row"><strong>Format</strong>Google Meet</div>
        </div>
        <a href="#" id="conf-meet-link" class="confirm-meet" style="display:none;">Rejoindre Google Meet →</a>
        <a href="<?php echo esc_url($url_fr); ?>" class="confirm-back">← Retour à PRISM</a>
      </div>

    </div><!-- .booking-widget -->
  </div><!-- .booking-inner -->
</div><!-- .booking-page -->

<script>
const API = '<?php echo esc_js(get_template_directory_uri()); ?>/prism-booking-api.php';

// ── State ──────────────────────────────────────────────────────────────────
const state = {
  year: 0, month: 0,
  selectedDate: null,
  selectedSlot: null,  // { start, end, display }
  slots: [],
};

// ── Helpers ────────────────────────────────────────────────────────────────
const $  = id => document.getElementById(id);
const el = (tag, cls, txt) => {
  const e = document.createElement(tag);
  if (cls) e.className = cls;
  if (txt !== undefined) e.textContent = txt;
  return e;
};

function showStep(n) {
  [1,2,3].forEach(i => {
    const el = $(`step-${i}`);
    el.classList.remove('visible');
    el.style.display = 'none';
    const ind = $(`ind-${i}`);
    ind.classList.remove('active','done');
    if (i === n) ind.classList.add('active');
    if (i < n)  ind.classList.add('done');
  });
  const active = $(`step-${n}`);
  active.style.display = 'block';
  active.classList.add('visible');
}

function formatDateLong(isoDate) {
  const [y,m,d] = isoDate.split('-').map(Number);
  return new Date(y, m-1, d).toLocaleDateString('fr-FR', {
    weekday: 'long', year: 'numeric', month: 'long', day: 'numeric'
  });
}

// ── Calendar ───────────────────────────────────────────────────────────────
function initCalendar() {
  const now = new Date();
  state.year  = now.getFullYear();
  state.month = now.getMonth();
  renderCalendar();
}

function renderCalendar() {
  const { year, month } = state;
  const today    = new Date();
  today.setHours(0,0,0,0);
  const monthNames = ['January','February','March','April','May','June',
                      'July','August','September','October','November','December'];

  $('cal-month-label').textContent = `${monthNames[month]} ${year}`;

  // Disable prev if current month
  $('cal-prev').disabled = (year === today.getFullYear() && month === today.getMonth());

  const grid = $('cal-grid');
  grid.innerHTML = '';

  // Day labels
  ['Mon','Tue','Wed','Thu','Fri','Sat','Sun'].forEach(d => {
    grid.appendChild(el('div', 'cal-day-label', d));
  });

  // First day offset (Mon=0)
  const firstDay = new Date(year, month, 1);
  let offset = firstDay.getDay() - 1;
  if (offset < 0) offset = 6;

  for (let i = 0; i < offset; i++) {
    grid.appendChild(el('div', 'cal-day empty', ''));
  }

  const daysInMonth = new Date(year, month + 1, 0).getDate();

  for (let d = 1; d <= daysInMonth; d++) {
    const date    = new Date(year, month, d);
    const dateStr = `${year}-${String(month+1).padStart(2,'0')}-${String(d).padStart(2,'0')}`;
    const dayEl   = el('div', 'cal-day', String(d));
    const dow     = date.getDay(); // 0=Sun,6=Sat

    if (date < today)            dayEl.classList.add('past');
    else if (dow === 0 || dow === 6) dayEl.classList.add('weekend');
    else {
      if (date.toDateString() === today.toDateString()) dayEl.classList.add('today');
      if (dateStr === state.selectedDate) dayEl.classList.add('selected');

      dayEl.addEventListener('click', () => selectDate(dateStr));
    }
    grid.appendChild(dayEl);
  }
}

async function selectDate(dateStr) {
  state.selectedDate = dateStr;
  state.selectedSlot = null;
  $('btn-step1-next').disabled = true;
  renderCalendar();

  // Show slots section
  const section = $('slots-section');
  section.style.display = '';
  $('slots-header').textContent = formatDateLong(dateStr);
  const container = $('slots-container');
  container.innerHTML = '<div class="slots-loading">Chargement des disponibilités</div>';

  try {
    const res  = await fetch(`${API}?action=slots&date=${dateStr}`);
    const data = await res.json();

    container.innerHTML = '';
    state.slots = data.slots || [];

    if (!state.slots.length) {
      container.innerHTML = '<div class="slots-empty">Aucune disponibilité ce jour — veuillez choisir une autre date.</div>';
      return;
    }

    const grid = el('div', 'slots-grid');
    state.slots.forEach(slot => {
      const btn = el('button', 'slot-btn', slot.display);
      btn.addEventListener('click', () => selectSlot(slot, btn));
      grid.appendChild(btn);
    });
    container.appendChild(grid);
  } catch(e) {
    container.innerHTML = '<div class="slots-empty">Impossible de charger les disponibilités. Veuillez réessayer.</div>';
  }
}

function selectSlot(slot, btnEl) {
  document.querySelectorAll('.slot-btn').forEach(b => b.classList.remove('selected'));
  btnEl.classList.add('selected');
  state.selectedSlot = slot;
  $('btn-step1-next').disabled = false;
}

// ── Calendar nav ───────────────────────────────────────────────────────────
$('cal-prev').addEventListener('click', () => {
  state.month--;
  if (state.month < 0) { state.month = 11; state.year--; }
  state.selectedDate = null;
  state.selectedSlot = null;
  $('slots-section').style.display = 'none';
  $('btn-step1-next').disabled = true;
  renderCalendar();
});
$('cal-next').addEventListener('click', () => {
  state.month++;
  if (state.month > 11) { state.month = 0; state.year++; }
  state.selectedDate = null;
  state.selectedSlot = null;
  $('slots-section').style.display = 'none';
  $('btn-step1-next').disabled = true;
  renderCalendar();
});

// ── Step transitions ───────────────────────────────────────────────────────
$('btn-step1-next').addEventListener('click', () => {
  if (!state.selectedSlot) return;
  const d   = formatDateLong(state.selectedDate);
  const t   = state.selectedSlot.display;
  $('slot-display-text').textContent = `${d} at ${t} (Paris time)`;
  showStep(2);
});

$('btn-back-1').addEventListener('click', () => showStep(1));

// ── Form submit ────────────────────────────────────────────────────────────
$('btn-submit').addEventListener('click', async () => {
  const name    = $('f-name').value.trim();
  const email   = $('f-email').value.trim();
  const website = $('f-website').value.trim();
  const message = $('f-message').value.trim();
  const errEl   = $('form-error');

  errEl.style.display = 'none';

  if (!name || !email || !website) {
    errEl.textContent = 'Veuillez remplir tous les champs obligatoires.';
    errEl.style.display = 'block';
    return;
  }
  if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
    errEl.textContent = 'Veuillez entrer une adresse email valide.';
    errEl.style.display = 'block';
    return;
  }

  const btn = $('btn-submit');
  btn.disabled = true;
  btn.textContent = 'Confirmation en cours…';

  try {
    const res  = await fetch(`${API}?action=book`, {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({
        name, email, website, message,
        start: state.selectedSlot.start,
        end:   state.selectedSlot.end,
      }),
    });
    const data = await res.json();

    if (!res.ok || !data.success) {
      throw new Error(data.error || 'Une erreur est survenue. Veuillez réessayer.');
    }

    // Show confirmation
    $('conf-date').textContent = data.date;
    $('conf-time').textContent = data.time;
    if (data.meet_link) {
      const ml = $('conf-meet-link');
      ml.href = data.meet_link;
      ml.style.display = 'inline-flex';
    }
    showStep(3);

  } catch(e) {
    errEl.textContent = e.message;
    errEl.style.display = 'block';
    btn.disabled = false;
    btn.textContent = 'Confirmer la réservation →';
  }
});

// ── Init ───────────────────────────────────────────────────────────────────
initCalendar();
showStep(1);
</script>

<?php wp_footer(); ?>
</body>
</html>
