<?php
/**
 * Template Name: PRISM Landing Page — EN
 *
 * ─── SETUP INSTRUCTIONS ──────────────────────────────────────────────────────
 * 1. Upload this file to: wp-content/themes/YOUR-ACTIVE-THEME/
 * 2. Also upload prism-config.php to the same folder
 * 3. Edit all URLs and media in prism-config.php — not here
 * 4. WordPress → Pages → Edit your EN page
 *    Right sidebar → Page Attributes → Template → "PRISM Landing Page — EN"
 * 5. Update / Publish. Done.
 * ─────────────────────────────────────────────────────────────────────────────
 * TO EDIT COPY: search for the text below and change it directly.
 * TO CHANGE LINKS / MEDIA: edit prism-config.php
 */

require_once(get_template_directory() . '/prism-config.php');
$current_lang = 'en';
?><!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>PRISM Filmmaking — Narrative Strategy for Tech Companies</title>
<?php wp_head(); ?>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;1,9..40,300&family=DM+Serif+Display:ital@0;1&display=swap" rel="stylesheet">
<style>
/* ─── RESET & VARS ─── */
*, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }
:root {
  --c-main: #FCFCFC;
  --c-dark: #0D0D0D;
  --c-blue: #03588C;
  --c-orange: #D9642A;
  --c-cream: #F2CDAC;
  --c-prism-a: #a8edff;   /* cyan  — light split  */
  --c-prism-b: #d4aaff;   /* violet               */
  --c-prism-c: #ffcba4;   /* warm cream           */
  --c-prism-d: #7affdb;   /* mint                 */
  --font-display: 'Bebas Neue', sans-serif;
  --font-serif:   'DM Serif Display', serif;
  --font-body:    'DM Sans', sans-serif;
  --ease: cubic-bezier(0.25, 0.46, 0.45, 0.94);
}
html { scroll-behavior: smooth; }
body {
  font-family: var(--font-body);
  background: var(--c-dark);
  color: var(--c-main);
  overflow-x: hidden;
  /* Override any theme padding/margin */
  padding: 0 !important;
  margin: 0 !important;
  max-width: none !important;
}
/* Hide any theme header/footer for this page */
.site-header, .site-footer, #masthead, #colophon,
.elementor-location-header, .elementor-location-footer { display: none !important; }

/* ═══════════════════════════════════════════════
   PRISM LIGHT EFFECT — shared utility
   A thin iridescent gradient used as
   decorative bleed-through across sections.
   Opacity is always low — never competing.
═══════════════════════════════════════════════ */
.prism-light {
  pointer-events: none;
  position: absolute;
  border-radius: 50%;
  filter: blur(80px);
  mix-blend-mode: screen;
  opacity: 0;
  animation: prism-breathe 8s ease-in-out infinite;
}
@keyframes prism-breathe {
  0%, 100% { opacity: 0.07; transform: scale(1); }
  50%       { opacity: 0.13; transform: scale(1.08); }
}

/* Spectrum divider — razor-thin rainbow line between sections */
.spectrum-divider {
  width: 100%;
  height: 1px;
  background: linear-gradient(
    90deg,
    transparent 0%,
    var(--c-prism-a) 20%,
    var(--c-prism-d) 35%,
    var(--c-prism-b) 55%,
    var(--c-orange)  75%,
    var(--c-prism-c) 90%,
    transparent 100%
  );
  opacity: 0.35;
  position: relative;
  z-index: 10;
}

/* ─── NAV ─── */
nav {
  position: fixed;
  top: 0; left: 0; right: 0;
  z-index: 200;
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 1.1rem 3rem;
  background: transparent;
  transition: background 0.5s var(--ease), backdrop-filter 0.5s;
}
nav.scrolled {
  background: rgba(13,13,13,0.94);
  backdrop-filter: blur(16px);
  -webkit-backdrop-filter: blur(16px);
  border-bottom: 1px solid rgba(255,255,255,0.05);
}
.nav-logo { text-decoration: none; display: flex; align-items: center; }
.nav-logo img {
  height: 42px; width: 42px;
  object-fit: contain;
  transition: transform 0.4s var(--ease), filter 0.4s;
}
.nav-logo img:hover {
  transform: scale(1.10);
  filter: drop-shadow(0 0 8px rgba(168,237,255,0.6));
}
.nav-links { display: flex; gap: 2.5rem; list-style: none; }
.nav-links a {
  font-size: 0.72rem;
  letter-spacing: 0.22em;
  text-transform: uppercase;
  color: var(--c-main);
  text-decoration: none;
  opacity: 0.6;
  transition: opacity 0.2s;
  position: relative;
}
.nav-links a::after {
  content: '';
  position: absolute;
  bottom: -4px; left: 0; right: 100%;
  height: 1px;
  background: linear-gradient(90deg, var(--c-prism-a), var(--c-orange));
  transition: right 0.35s var(--ease);
}
.nav-links a:hover { opacity: 1; }
.nav-links a:hover::after { right: 0; }
.nav-cta {
  font-size: 0.71rem;
  letter-spacing: 0.18em;
  text-transform: uppercase;
  padding: 0.6rem 1.4rem;
  border: 1px solid var(--c-orange);
  color: var(--c-orange);
  text-decoration: none;
  transition: background 0.25s, color 0.25s, box-shadow 0.3s;
}
.nav-cta:hover {
  background: var(--c-orange);
  color: var(--c-main);
  box-shadow: 0 0 20px rgba(217,100,42,0.35);
}
/* ─── LANGUAGE TOGGLE ─── */
.lang-toggle {
  display: flex;
  align-items: center;
  gap: 0;
  margin-left: 1.5rem;
  border: 1px solid rgba(252,252,252,0.15);
  overflow: hidden;
}
.lang-toggle a {
  font-size: 0.65rem;
  letter-spacing: 0.2em;
  text-transform: uppercase;
  padding: 0.45rem 0.75rem;
  color: rgba(252,252,252,0.4);
  text-decoration: none;
  transition: background 0.2s, color 0.2s;
  line-height: 1;
}
.lang-toggle a:hover { color: var(--c-main); background: rgba(252,252,252,0.06); }
.lang-toggle a.active {
  background: var(--c-orange);
  color: var(--c-main);
}
.lang-toggle .lang-sep {
  width: 1px;
  height: 100%;
  background: rgba(252,252,252,0.15);
  align-self: stretch;
}

/* ─── HERO ─── */
#hero {
  position: relative;
  height: 100vh;
  min-height: 700px;
  display: flex;
  flex-direction: column;
  justify-content: flex-end;
  padding: 0 3rem 5rem;
  overflow: hidden;
}
.hero-bg {
  position: absolute;
  inset: 0;
  background: linear-gradient(135deg, #080808 0%, #101520 45%, #0a0a0a 100%);
  z-index: 0;
}
.hero-bg::after {
  content: '';
  position: absolute; inset: 0;
  background: linear-gradient(to top,
    rgba(13,13,13,0.97) 0%,
    rgba(13,13,13,0.3)  55%,
    rgba(13,13,13,0.6)  100%);
}

/* ── Prismatic light leaks in hero ── */
.hero-prism-a {
  position: absolute;
  top: -10%;  right: -5%;
  width: 55vw; height: 55vw;
  background: radial-gradient(ellipse,
    rgba(168,237,255,0.22) 0%,
    rgba(212,170,255,0.12) 40%,
    transparent 70%);
  filter: blur(60px);
  mix-blend-mode: screen;
  z-index: 1;
  animation: prism-drift-a 12s ease-in-out infinite;
}
.hero-prism-b {
  position: absolute;
  bottom: 15%;  right: 15%;
  width: 30vw; height: 30vw;
  background: radial-gradient(ellipse,
    rgba(217,100,42,0.18) 0%,
    rgba(242,205,172,0.08) 50%,
    transparent 70%);
  filter: blur(50px);
  mix-blend-mode: screen;
  z-index: 1;
  animation: prism-drift-b 9s ease-in-out infinite;
}
.hero-prism-c {
  position: absolute;
  top: 30%;  left: 40%;
  width: 20vw; height: 20vw;
  background: radial-gradient(ellipse,
    rgba(122,255,219,0.1) 0%,
    transparent 70%);
  filter: blur(40px);
  mix-blend-mode: screen;
  z-index: 1;
  animation: prism-drift-c 15s ease-in-out infinite;
}
@keyframes prism-drift-a {
  0%,100% { transform: translate(0,0) scale(1); opacity: 0.9; }
  33%      { transform: translate(-3%,5%) scale(1.05); opacity: 1; }
  66%      { transform: translate(4%,-3%) scale(0.97); opacity: 0.8; }
}
@keyframes prism-drift-b {
  0%,100% { transform: translate(0,0); opacity: 0.7; }
  50%      { transform: translate(-5%,4%); opacity: 1; }
}
@keyframes prism-drift-c {
  0%,100% { transform: translate(0,0) scale(1); opacity: 0.5; }
  40%      { transform: translate(3%,-5%) scale(1.1); opacity: 0.8; }
  80%      { transform: translate(-4%,3%) scale(0.95); opacity: 0.4; }
}

/* Chromatic aberration edge — mimics light splitting at a prism edge */
.hero-prism-edge {
  position: absolute;
  top: 0; right: 0; bottom: 0;
  width: 3px;
  background: linear-gradient(to bottom,
    var(--c-prism-a),
    var(--c-prism-d),
    var(--c-prism-b),
    var(--c-orange),
    var(--c-prism-c));
  z-index: 5;
  opacity: 0.5;
}

/* Film grain */
.grain {
  position: absolute; inset: 0;
  z-index: 2;
  opacity: 0.04;
  pointer-events: none;
  background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noise'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noise)'/%3E%3C/svg%3E");
  background-size: 256px 256px;
}
/* Letterbox bars */
.hero-bar-top, .hero-bar-bottom {
  position: absolute; left: 0; right: 0;
  height: 56px; background: #0D0D0D; z-index: 4;
}
.hero-bar-top    { top: 0; }
.hero-bar-bottom { bottom: 0; }
/* Diagonal blue accent */
.hero-accent {
  position: absolute; right: 0; top: 0; bottom: 0;
  width: 36%; z-index: 1;
  background: linear-gradient(to bottom left, rgba(3,88,140,0.12), transparent);
  clip-path: polygon(28% 0, 100% 0, 100% 100%, 0% 100%);
}
.hero-video-placeholder {
  position: absolute; inset: 0; z-index: 0;
  display: flex; align-items: center; justify-content: center;
  font-size: 0.65rem; letter-spacing: 0.35em; text-transform: uppercase;
  color: rgba(252,252,252,0.08);
}
.video-label {
  position: absolute; top: 68px; right: 2.5rem; z-index: 5;
  font-size: 0.6rem; letter-spacing: 0.35em; text-transform: uppercase;
  color: rgba(252,252,252,0.2); writing-mode: vertical-rl;
}
.hero-content { position: relative; z-index: 3; max-width: 880px; }
.hero-eyebrow {
  font-size: 0.68rem; letter-spacing: 0.42em; text-transform: uppercase;
  color: var(--c-orange); margin-bottom: 1.3rem;
  display: flex; align-items: center; gap: 1rem;
  animation: fadeUp 0.9s var(--ease) 0.3s both;
}
.hero-eyebrow::before {
  content: ''; width: 36px; height: 1px;
  background: linear-gradient(90deg, var(--c-prism-a), var(--c-orange));
}
.hero-h1 {
  font-family: var(--font-display);
  font-size: clamp(4rem, 9vw, 8.5rem);
  line-height: 0.88; letter-spacing: 0.02em;
  color: var(--c-main); margin-bottom: 1.6rem;
  animation: fadeUp 0.9s var(--ease) 0.5s both;
}
.hero-h1 em { font-family: var(--font-serif); font-style: italic; color: var(--c-cream); }
.hero-sub {
  font-size: 1.05rem; font-weight: 300; line-height: 1.75;
  color: rgba(252,252,252,0.58); max-width: 510px; margin-bottom: 2.5rem;
  animation: fadeUp 0.9s var(--ease) 0.7s both;
}
.hero-cta-row {
  display: flex; align-items: center; gap: 2rem;
  animation: fadeUp 0.9s var(--ease) 0.9s both;
}
.btn-primary {
  display: inline-block; padding: 1rem 2.4rem;
  background: var(--c-orange); color: var(--c-main);
  font-size: 0.75rem; letter-spacing: 0.22em; text-transform: uppercase;
  text-decoration: none;
  transition: background 0.25s, box-shadow 0.3s, transform 0.2s;
}
.btn-primary:hover {
  background: #c05521; transform: translateY(-2px);
  box-shadow: 0 8px 28px rgba(217,100,42,0.4);
}
.btn-ghost {
  display: inline-flex; align-items: center; gap: 0.6rem;
  font-size: 0.75rem; letter-spacing: 0.18em; text-transform: uppercase;
  color: rgba(252,252,252,0.55); text-decoration: none; transition: color 0.2s;
}
.btn-ghost::after { content: '↓'; font-size: 1rem; transition: transform 0.3s; }
.btn-ghost:hover { color: var(--c-main); }
.btn-ghost:hover::after { transform: translateY(4px); }

/* ─── SHARED ─── */
section { position: relative; }
.section-inner { max-width: 1180px; margin: 0 auto; padding: 0 3rem; }
.section-label {
  font-size: 0.65rem; letter-spacing: 0.45em; text-transform: uppercase;
  color: var(--c-orange); margin-bottom: 1rem;
  display: flex; align-items: center; gap: 0.75rem;
}
.section-label::before {
  content: ''; width: 22px; height: 1px;
  background: linear-gradient(90deg, var(--c-prism-a), var(--c-orange));
}

/* ─── FOUNDER ─── */
#founder {
  background: var(--c-main); color: var(--c-dark);
  padding: 8rem 0; overflow: hidden;
}
/* Subtle iridescent orb behind founder photo */
.founder-prism {
  position: absolute;
  top: -20%;  left: -10%;
  width: 50%;  height: 140%;
  background: radial-gradient(ellipse at center,
    rgba(168,237,255,0.08) 0%,
    rgba(212,170,255,0.05) 50%,
    transparent 70%);
  filter: blur(60px);
  mix-blend-mode: multiply;
  pointer-events: none;
  animation: prism-breathe 10s ease-in-out infinite;
}
.founder-grid {
  display: grid; grid-template-columns: 45fr 55fr;
  gap: 6rem; align-items: center;
}
.founder-img-wrap { position: relative; }
.founder-img-placeholder {
  aspect-ratio: 3/4; background: #111;
  display: flex; align-items: center; justify-content: center;
  font-size: 0.7rem; letter-spacing: 0.25em; color: rgba(252,252,252,0.15);
  text-transform: uppercase; position: relative; overflow: hidden;
}
.founder-img-placeholder::before {
  content: ''; position: absolute; bottom: 0; left: 0; right: 0; height: 40%;
  background: linear-gradient(to top, rgba(217,100,42,0.25), transparent);
}
.founder-img-placeholder img {
  width: 100%; height: 100%; object-fit: cover;
  position: absolute; inset: 0;
}
/* Chromatic strip accent on image */
.founder-img-wrap::after {
  content: ''; position: absolute; bottom: -1.5rem; right: -1.5rem;
  width: 60%; height: 3px;
  background: #D9642A;
  opacity: 1;
}
.founder-copy .section-label { color: var(--c-orange); }
.founder-copy .section-label::before { background: linear-gradient(90deg, var(--c-blue), var(--c-orange)); }
.founder-h2 {
  font-family: var(--font-display);
  font-size: clamp(2.5rem, 4vw, 3.8rem); line-height: 0.93; letter-spacing: 0.03em;
  color: var(--c-dark); margin-bottom: 1.75rem;
}
.founder-h2 em { font-family: var(--font-serif); font-style: italic; color: var(--c-blue); }
.founder-body {
  font-size: 1rem; font-weight: 300; line-height: 1.82;
  color: rgba(13,13,13,0.68); margin-bottom: 1.4rem;
}
.founder-body strong { font-weight: 500; color: var(--c-dark); }
.founder-signature {
  margin-top: 2.5rem; font-family: var(--font-serif);
  font-style: italic; font-size: 1.4rem; color: var(--c-orange);
}
.founder-cta {
  font-size: .95rem; font-weight: 300; line-height: 1.7;
  color: rgba(13,13,13,.6); margin-top: 1.5rem;
}
.founder-cta a {
  color: var(--c-orange); text-decoration: none;
  border-bottom: 1px solid rgba(217,100,42,.4);
  transition: border-color .2s, color .2s;
}
.founder-cta a:hover { color: #c05521; border-bottom-color: #c05521; }

/* ─── MECHANISM ─── */
#mechanism { background: var(--c-dark); padding: 9rem 0; overflow: hidden; }
/* Large prismatic orb — very subtle, top right */
.mechanism-prism {
  position: absolute; top: -15%; right: -10%;
  width: 45vw; height: 45vw;
  background: radial-gradient(ellipse,
    rgba(168,237,255,0.07) 0%,
    rgba(212,170,255,0.05) 45%,
    transparent 70%);
  filter: blur(70px); mix-blend-mode: screen;
  pointer-events: none;
  animation: prism-drift-a 14s ease-in-out infinite;
}
.mechanism-header { margin-bottom: 5rem; position: relative; z-index: 1; }
.mechanism-title {
  font-family: var(--font-display);
  font-size: clamp(3rem, 6vw, 5.5rem); line-height: 0.88;
  letter-spacing: 0.03em; color: var(--c-main); margin-bottom: 1rem;
}
.mechanism-title span { color: var(--c-orange); }
.mechanism-subtitle {
  font-size: 1rem; font-weight: 300;
  color: rgba(252,252,252,0.45); max-width: 480px;
}
.steps-row {
  display: grid; grid-template-columns: repeat(3, 1fr);
  border: 1px solid rgba(252,252,252,0.08);
  position: relative; z-index: 1;
}
.step {
  padding: 3rem 2.5rem;
  border-right: 1px solid rgba(252,252,252,0.08);
  position: relative; overflow: hidden;
  transition: background 0.4s;
}
.step:last-child { border-right: none; }
/* Prismatic shimmer on hover — sweeps across card */
.step::before {
  content: '';
  position: absolute; top: 0; left: -100%; width: 80%; height: 100%;
  background: linear-gradient(
    105deg,
    transparent 20%,
    rgba(168,237,255,0.03) 38%,
    rgba(212,170,255,0.05) 50%,
    rgba(122,255,219,0.03) 62%,
    transparent 80%
  );
  transition: left 1.2s var(--ease);
  pointer-events: none;
}
.step:hover::before { left: 160%; }
.step:hover { background: rgba(252,252,252,0.025); }
.step-num {
  font-family: var(--font-display); font-size: 5rem; line-height: 1;
  color: rgba(252,252,252,0.04);
  position: absolute; top: 1.2rem; right: 1.5rem; letter-spacing: 0;
}
.step-icon {
  width: 46px; height: 46px;
  border: 1px solid var(--c-orange);
  display: flex; align-items: center; justify-content: center;
  margin-bottom: 1.5rem; color: var(--c-orange);
  font-family: var(--font-display); font-size: 1.4rem;
  transition: border-color 0.3s, box-shadow 0.3s;
}
.step:hover .step-icon {
  border-color: var(--c-prism-a);
  box-shadow: 0 0 16px rgba(168,237,255,0.2);
  color: var(--c-prism-a);
}
.step-tag {
  font-size: 0.62rem; letter-spacing: 0.38em; text-transform: uppercase;
  color: var(--c-orange); margin-bottom: 0.75rem;
}
.step-name {
  font-family: var(--font-display); font-size: 2rem;
  letter-spacing: 0.05em; color: var(--c-main); margin-bottom: 1rem;
}
.step-desc {
  font-size: 0.88rem; font-weight: 300; line-height: 1.78;
  color: rgba(252,252,252,0.52);
}
/* Bottom bar — solid orange */
.step-bar {
  position: absolute; bottom: 0; left: 0;
  height: 2px; width: 0;
  background: #D9642A;
  transition: width 0.5s var(--ease);
}
.step:hover .step-bar { width: 100%; }

/* Mechanism quote block */
.mechanism-statement {
  margin-top: 5rem; padding: 4rem;
  border: 1px solid rgba(252,252,252,0.08);
  display: flex; align-items: center; justify-content: space-between;
  gap: 3rem; position: relative; z-index: 1; overflow: hidden;
}
/* Prismatic glow inside quote block */
.mechanism-statement::before {
  content: ''; position: absolute;
  bottom: -40%; left: 30%; width: 40%; height: 150%;
  background: radial-gradient(ellipse,
    rgba(168,237,255,0.05) 0%, transparent 70%);
  filter: blur(30px); mix-blend-mode: screen; pointer-events: none;
}
.mechanism-quote {
  font-family: var(--font-serif); font-style: italic;
  font-size: clamp(1.2rem, 2.2vw, 1.7rem); line-height: 1.45;
  color: var(--c-cream); max-width: 600px;
}
.mechanism-quote strong {
  font-style: normal; font-family: var(--font-body);
  font-size: 0.65rem; letter-spacing: 0.32em; text-transform: uppercase;
  color: var(--c-orange); font-weight: 400;
  display: block; margin-top: 1.2rem;
}
.mechanism-stat { text-align: center; flex-shrink: 0; }
.mechanism-stat-num {
  font-family: var(--font-display); font-size: 4rem;
  color: var(--c-orange); line-height: 1; display: block;
}
.mechanism-stat-label {
  font-size: 0.68rem; letter-spacing: 0.25em; text-transform: uppercase;
  color: rgba(252,252,252,0.35); display: block; margin-top: 0.5rem;
}

/* ─── WORK SAMPLE ─── */
#travaux { background: #080808; padding: 9rem 0; overflow: hidden; }
/* Prism orb — warm right side */
.travaux-prism {
  position: absolute; bottom: -20%; right: -10%;
  width: 40vw; height: 40vw;
  background: radial-gradient(ellipse,
    rgba(217,100,42,0.1) 0%,
    rgba(242,205,172,0.06) 45%,
    transparent 70%);
  filter: blur(60px); mix-blend-mode: screen;
  pointer-events: none;
  animation: prism-drift-b 11s ease-in-out infinite;
}
.work-grid {
  display: grid; grid-template-columns: 1fr 1fr;
  gap: 5rem; align-items: center; margin-top: 4rem;
  position: relative; z-index: 1;
}
.work-framing { min-width: 0; padding-right: 1.5rem; }
.work-video {
  aspect-ratio: 16/9;
  position: relative; overflow: hidden;
  display: flex; align-items: center; justify-content: center;
}
.play-btn {
  width: 72px; height: 72px;
  border: 1px solid rgba(252,252,252,0.5);
  border-radius: 50%;
  display: flex; align-items: center; justify-content: center;
  cursor: pointer; position: relative; z-index: 1;
  transition: border-color 0.3s, box-shadow 0.4s, transform 0.3s;
  background: rgba(13,13,13,0.4);
  backdrop-filter: blur(8px);
}
.play-btn::after {
  content: ''; width: 0; height: 0;
  border-style: solid; border-width: 11px 0 11px 20px;
  border-color: transparent transparent transparent rgba(252,252,252,0.85);
  margin-left: 4px;
}
.play-btn:hover {
  border-color: var(--c-prism-a);
  box-shadow: 0 0 30px rgba(168,237,255,0.25), 0 0 60px rgba(168,237,255,0.1);
  transform: scale(1.08);
}
.work-video-placeholder-label {
  position: absolute; bottom: 1rem; left: 1rem;
  font-size: 0.6rem; letter-spacing: 0.3em; text-transform: uppercase;
  color: rgba(252,252,252,0.15);
}
.work-video iframe {
  position: absolute; inset: 0; width: 100%; height: 100%; border: 0;
}
.work-video-col { display: flex; flex-direction: column; min-width: 0; }
.work-keywords {
  display: flex; align-items: center; justify-content: space-between;
  margin-top: 2rem; width: 100%;
  font-family: var(--font-body);
  font-weight: 500;
  font-size: clamp(0.85rem, 1.4vw, 1.25rem);
  letter-spacing: 0.06em; text-transform: uppercase;
  color: var(--c-main);
}
.work-keywords-sep {
  color: var(--c-orange);
}
.framing-item {
  margin-bottom: 2.5rem; padding-left: 1.5rem;
  border-left: 1px solid rgba(252,252,252,0.08);
  transition: border-color 0.4s;
}
.framing-item:hover {
  border-left-color: var(--c-prism-a);
}
.framing-label {
  font-size: 0.62rem; letter-spacing: 0.38em; text-transform: uppercase;
  color: var(--c-orange); margin-bottom: 0.5rem;
}
.framing-text {
  font-size: 0.93rem; font-weight: 300; line-height: 1.75;
  color: rgba(252,252,252,0.58);
}
.framing-text strong { color: var(--c-main); font-weight: 500; }

/* ─── CTA ─── */
#contact { background: var(--c-dark); padding: 10rem 0; overflow: hidden; }
/* Full prismatic nebula behind CTA — the centrepiece effect */
.contact-prism-a {
  position: absolute; top: -30%; left: -10%;
  width: 60vw; height: 100%;
  background: radial-gradient(ellipse at 40% 50%,
    rgba(168,237,255,0.07) 0%,
    rgba(212,170,255,0.05) 35%,
    transparent 65%);
  filter: blur(80px); mix-blend-mode: screen;
  pointer-events: none;
  animation: prism-drift-a 16s ease-in-out infinite;
}
.contact-prism-b {
  position: absolute; bottom: -20%; right: -5%;
  width: 40vw; height: 80%;
  background: radial-gradient(ellipse,
    rgba(217,100,42,0.09) 0%,
    rgba(242,205,172,0.04) 45%,
    transparent 70%);
  filter: blur(60px); mix-blend-mode: screen;
  pointer-events: none;
  animation: prism-drift-b 13s ease-in-out infinite;
}
.contact-bg-text {
  position: absolute; bottom: -2rem; left: -1rem;
  font-family: var(--font-display); font-size: 18vw;
  color: rgba(252,252,252,0.018); line-height: 1;
  white-space: nowrap; pointer-events: none; user-select: none;
  letter-spacing: -0.02em;
}
.contact-inner { max-width: 780px; position: relative; z-index: 1; }
.contact-title {
  font-family: var(--font-display);
  font-size: clamp(3rem, 7vw, 6rem); line-height: 0.88; letter-spacing: 0.02em;
  color: var(--c-main); margin-bottom: 2rem;
}
.contact-title span { color: var(--c-orange); }
.contact-desc {
  font-size: 1.08rem; font-weight: 300; line-height: 1.82;
  color: rgba(252,252,252,0.52); max-width: 540px; margin-bottom: 3rem;
}
.contact-desc strong { color: var(--c-cream); font-weight: 400; }
.contact-value-props { display: flex; gap: 3rem; margin-bottom: 3.5rem; flex-wrap: wrap; }
.cvp { display: flex; align-items: flex-start; gap: 0.75rem; }
.cvp-dot {
  width: 5px; height: 5px; background: var(--c-orange);
  margin-top: 0.55rem; flex-shrink: 0;
  box-shadow: 0 0 6px rgba(217,100,42,0.5);
}
.cvp-text { font-size: 0.84rem; font-weight: 300; line-height: 1.55; color: rgba(252,252,252,0.45); }
.cvp-text strong { color: var(--c-main); font-weight: 400; display: block; margin-bottom: 0.1rem; }
/* CTA box — with prismatic border on hover */
.contact-cta-box {
  display: inline-flex; flex-direction: column;
  background: var(--c-orange); padding: 2.5rem 3rem;
  text-decoration: none; max-width: 460px;
  transition: background 0.25s, box-shadow 0.4s, transform 0.2s;
  position: relative; overflow: hidden;
}
/* Shimmer sweep on CTA */
.contact-cta-box::before {
  content: ''; position: absolute;
  top: 0; left: -100%; width: 80%; height: 100%;
  background: linear-gradient(105deg,
    transparent 20%,
    rgba(255,255,255,0.05) 38%,
    rgba(255,255,255,0.09) 50%,
    rgba(255,255,255,0.05) 62%,
    transparent 80%);
  transition: left 1.2s var(--ease);
}
.contact-cta-box:hover::before { left: 160%; }
.contact-cta-box:hover {
  background: #c05521; transform: translateY(-2px);
  box-shadow: 0 16px 40px rgba(217,100,42,0.45);
}
.contact-cta-label {
  font-size: 0.62rem; letter-spacing: 0.38em; text-transform: uppercase;
  color: rgba(252,252,252,0.65); margin-bottom: 0.4rem;
}
.contact-cta-text {
  font-family: var(--font-display); font-size: 1.5rem;
  letter-spacing: 0.05em; color: var(--c-main); margin-bottom: 0.2rem;
}
.contact-cta-sub { font-size: 0.78rem; font-weight: 300; color: rgba(252,252,252,0.65); }
.contact-email { margin-top: 2rem; font-size: 0.78rem; color: rgba(252,252,252,0.28); letter-spacing: 0.1em; }
.contact-email a { color: rgba(252,252,252,0.45); text-decoration: none; transition: color 0.2s; }
.contact-email a:hover { color: var(--c-cream); }

/* ─── FOOTER ─── */
footer {
  background: #050505; padding: 3rem;
  display: flex; align-items: center; justify-content: space-between;
  border-top: 1px solid rgba(252,252,252,0.05);
  position: relative; overflow: hidden;
}
/* Thin prismatic top border */
footer::before {
  content: ''; position: absolute; top: 0; left: 0; right: 0; height: 1px;
  background: linear-gradient(90deg,
    transparent, var(--c-prism-a) 25%, var(--c-prism-b) 50%, var(--c-orange) 75%, transparent);
  opacity: 0.3;
}
.footer-logo img {
  height: 46px; width: 46px; object-fit: contain;
  transition: filter 0.4s, transform 0.4s;
}
.footer-logo img:hover {
  filter: drop-shadow(0 0 10px rgba(168,237,255,0.5));
  transform: scale(1.10);
}
.footer-mission {
  font-size: 0.73rem; font-weight: 300;
  color: rgba(252,252,252,0.25); max-width: 400px; text-align: center; line-height: 1.65;
}
.footer-right { font-size: 0.68rem; letter-spacing: 0.15em; color: rgba(252,252,252,0.18); text-transform: uppercase; }

/* ─── ANIMATIONS ─── */
@keyframes fadeUp {
  from { opacity: 0; transform: translateY(28px); }
  to   { opacity: 1; transform: translateY(0); }
}
/* Scroll reveal */
.reveal {
  opacity: 0; transform: translateY(24px);
  transition: opacity 0.75s var(--ease), transform 0.75s var(--ease);
}
.reveal.visible { opacity: 1; transform: translateY(0); }
.reveal-delay-1 { transition-delay: 0.1s; }
.reveal-delay-2 { transition-delay: 0.22s; }
.reveal-delay-3 { transition-delay: 0.36s; }

/* ─── RESPONSIVE ─── */
@media (max-width: 900px) {
  nav { padding: 1rem 1.5rem; }
  .nav-links { display: none; }
  #hero { padding: 0 1.5rem 3rem; }
  .section-inner { padding: 0 1.5rem; }
  .founder-grid { grid-template-columns: 1fr; gap: 3rem; }
  .steps-row { grid-template-columns: 1fr; }
  .step { border-right: none; border-bottom: 1px solid rgba(252,252,252,0.08); }
  .work-grid { grid-template-columns: 1fr; gap: 3rem; }
  .work-keywords { font-size: clamp(0.85rem, 4vw, 1.2rem); letter-spacing: 0.03em; gap: 0.5rem; justify-content: center; flex-wrap: wrap; }
  .mechanism-statement { flex-direction: column; padding: 2.5rem 1.5rem; }
  #mechanism, #travaux, #contact, #founder { padding: 5rem 0; }
  footer { flex-direction: column; gap: 1.5rem; text-align: center; }
  .footer-mission { text-align: center; }
  .contact-bg-text { font-size: 28vw; }
  .contact-value-props { flex-direction: column; gap: 1.5rem; }
}
</style>
</head>
<body>

<!-- NAV -->
<nav id="navbar">
  <a href="#" class="nav-logo">
    <img src="<?php echo esc_url($logo_url); ?>" alt="PRISM Filmmaking">
  </a>
  <ul class="nav-links">
    <li><a href="#founder">Approach</a></li>
    <li><a href="#mechanism">Process</a></li>
    <li><a href="#travaux">Work</a></li>
    <li><a href="#contact">Contact</a></li>
  </ul>
  <div style="display:flex;align-items:center;gap:1.25rem;">
    <div class="lang-toggle">
      <a href="<?php echo esc_url($url_fr); ?>">FR</a>
      <span class="lang-sep"></span>
      <a href="<?php echo esc_url($url_en); ?>" class="active">EN</a>
    </div>
    <a href="<?php echo esc_url($url_booking_en); ?>" class="nav-cta">Book a call</a>
  </div>
</nav>

<!-- HERO -->
<section id="hero">
  <div class="hero-bg"></div>
  <div class="hero-prism-a"></div>
  <div class="hero-prism-b"></div>
  <div class="hero-prism-c"></div>
  <div class="grain"></div>
  <div class="hero-accent"></div>
  <div class="hero-prism-edge"></div>
  <div class="hero-bar-top"></div>
  <div class="hero-video-placeholder">[ Replace with your film — background video ]</div>
  <div class="video-label">Film · Background</div>
  <div class="hero-content">
    <p class="hero-eyebrow">PRISM Filmmaking</p>
    <h1 class="hero-h1">Your expertise<br>becomes your<br><em>advantage.</em></h1>
    <p class="hero-sub">We transform the invisible technical excellence of French tech companies into a global competitive edge — through narrative strategy, before the camera ever rolls.</p>
    <div class="hero-cta-row">
      <a href="<?php echo esc_url($url_booking_en); ?>" class="btn-primary">Book a diagnostic</a>
      <a href="#mechanism" class="btn-ghost">See the process</a>
    </div>
  </div>
  <div class="hero-bar-bottom"></div>
</section>

<div class="spectrum-divider"></div>

<!-- FOUNDER -->
<section id="founder">
  <div class="founder-prism"></div>
  <div class="section-inner">
    <div class="founder-grid">
      <div class="founder-img-wrap reveal">
        <div class="founder-img-placeholder">
          <?php if ($founder_img_url): ?>
            <img src="<?php echo esc_url($founder_img_url); ?>" alt="PRISM Founder">
          <?php else: ?>
            [ Your photo ]
          <?php endif; ?>
        </div>
      </div>
      <div class="founder-copy">
        <p class="section-label reveal">Founder</p>
        <h2 class="founder-h2 reveal reveal-delay-1">Craft without<br>story is just<br><em>noise.</em></h2>
        <p class="founder-body reveal reveal-delay-2">At 8, it wasn't Jurassic Park that changed me. It was the making-of.<br>Watching them move muscles under digital skin — building something real from nothing — it lit something in me that never really went out. <strong>It just changed shape.</strong> 3D animation. Music. Audio engineering. VFX. Editing. Every detour ran on the same engine.
        </p>
        <p class="founder-body reveal reveal-delay-2">
          For years, I cut reels for e-commerce brands. It paid well. It was comfortable. And it was quietly killing me — because they wanted me to <strong>decorate, not to tell.</strong>
        </p>
        <p class="founder-body reveal reveal-delay-3">
          Today, I work with leaders of French tech companies doing extraordinary things — that nobody sees. Not because their work lacks value. Because <strong>their story lacks a voice.</strong>
        </p>
        <p class="founder-body reveal reveal-delay-3">
          My role isn't to make films. It's to make their excellence <strong>impossible to ignore</strong> — through a process rooted in decision psychology, before the camera ever comes out.
        </p>
        <p class="founder-cta reveal reveal-delay-3">If you're building something that deserves to be seen — <a href="#contact">let's talk.</a></p>
        <p class="founder-signature reveal reveal-delay-3">Michael Mietz</p>
      </div>
    </div>
  </div>
</section>

<div class="spectrum-divider"></div>

<!-- MECHANISM -->
<section id="mechanism">
  <div class="mechanism-prism"></div>
  <div class="section-inner">
    <div class="mechanism-header">
      <p class="section-label reveal">The PRISM Protocol</p>
      <h2 class="mechanism-title reveal reveal-delay-1">Strategy first,<br><span>camera second.</span></h2>
      <p class="mechanism-subtitle reveal reveal-delay-2">Three steps. Every decision anchored in the decision psychology of your target.</p>
    </div>
    <div class="steps-row">
      <div class="step reveal">
        <span class="step-num">1</span>
        <div class="step-icon">K</div>
        <p class="step-tag">Step 01</p>
        <h3 class="step-name">Keywords</h3>
        <p class="step-desc">The 5 pillars of the message. The north star of all communication. We don't film until every word is right — and tested against your real prospects.</p>
        <div class="step-bar"></div>
      </div>
      <div class="step reveal reveal-delay-1">
        <span class="step-num">2</span>
        <div class="step-icon">P</div>
        <p class="step-tag">Step 02</p>
        <h3 class="step-name">Characters</h3>
        <p class="step-desc">The faces that embody expertise. Not actors — vectors of trust. We identify the internal profiles that trigger identification in your ICP.</p>
        <div class="step-bar"></div>
      </div>
      <div class="step reveal reveal-delay-2">
        <span class="step-num">3</span>
        <div class="step-icon">S</div>
        <p class="step-tag">Step 03</p>
        <h3 class="step-name">Storyboards</h3>
        <p class="step-desc">Every shot calibrated to remove rational barriers and trigger action. The camera is merely the execution of a strategic decision already made.</p>
        <div class="step-bar"></div>
      </div>
    </div>
    <div class="mechanism-statement reveal">
      <blockquote class="mechanism-quote">
        "A film without narrative strategy is aesthetics without a destination."
        <strong>— The PRISM Philosophy</strong>
      </blockquote>
      <div class="mechanism-stat">
        <span class="mechanism-stat-num">90</span>
        <span class="mechanism-stat-label">days · complete transformation</span>
      </div>
    </div>
  </div>
</section>

<div class="spectrum-divider"></div>

<!-- WORK SAMPLE -->
<section id="travaux">
  <div class="travaux-prism"></div>
  <div class="section-inner">
    <p class="section-label reveal">Recent Work</p>
    <h2 class="mechanism-title reveal reveal-delay-1" style="font-size:clamp(2.5rem,5vw,4.5rem);margin-bottom:0;">
      What it<br>looks <span>like.</span>
    </h2>
    <div class="work-grid">
      <div class="work-video-col">
        <div class="work-video reveal">
          <iframe src="https://www.rushes.cc/embed/a7c9baf5-fdc6-4974-8589-8980204932fe"
            frameborder="0" allow="autoplay; fullscreen; picture-in-picture"
            referrerpolicy="strict-origin-when-cross-origin"
            title="FastMusic VSL"></iframe>
        </div>
        <div class="work-keywords reveal">
          <strong>Warmth</strong>
          <span class="work-keywords-sep"> - </span>
          <strong>Availability</strong>
          <span class="work-keywords-sep"> - </span>
          <strong>Spark</strong>
        </div>
      </div>
      <div class="work-framing">
        <div class="framing-item reveal">
          <p class="framing-label">The need</p>
          <p class="framing-text"><strong>Akpo — Fast Music</strong> — music workshop facilitator for children. Every week: 5 hours of cold calls to leisure centres and youth spaces. A near-empty calendar. Real expertise, but no infrastructure to sell it.</p>
        </div>
        <div class="framing-item reveal reveal-delay-1">
          <p class="framing-label">What we built</p>
          <p class="framing-text">A VSL filmed in immersion during a live workshop — kids, creativity, raw energy. Embedded on a landing page with a contact section. Automated email system with a direct link to the page.</p>
        </div>
        <div class="framing-item reveal reveal-delay-2">
          <p class="framing-label">The result</p>
          <p class="framing-text"><strong>−80% of sales time</strong>: from 5h down to 1h per week. 4 new workshops signed in 2026, versus just 1 before deployment. The VSL replaces the cold call — it converts on its own.</p>
        </div>
      </div>
    </div>
  </div>
</section>

<div class="spectrum-divider"></div>

<!-- CTA -->
<section id="contact">
  <div class="contact-prism-a"></div>
  <div class="contact-prism-b"></div>
  <div class="contact-bg-text">PRISM</div>
  <div class="section-inner">
    <div class="contact-inner">
      <p class="section-label reveal">Next step</p>
      <h2 class="contact-title reveal reveal-delay-1">You deserve more<br>than<br><span>invisibility.</span></h2>
      <p class="contact-desc reveal reveal-delay-2">
        This isn't a contact form. It's a <strong>30-minute strategic diagnostic</strong> — no commitment — to identify if and how PRISM can transform your communication.
      </p>
      <div class="contact-value-props reveal reveal-delay-2">
        <div class="cvp">
          <div class="cvp-dot"></div>
          <div class="cvp-text"><strong>30 minutes, focused</strong>Direct conversation, no hard sell</div>
        </div>
        <div class="cvp">
          <div class="cvp-dot"></div>
          <div class="cvp-text"><strong>Free diagnostic</strong>You leave with actionable insights</div>
        </div>
        <div class="cvp">
          <div class="cvp-dot"></div>
          <div class="cvp-text"><strong>Limited availability</strong>3 new projects per quarter maximum</div>
        </div>
      </div>
      <a href="<?php echo esc_url($url_booking_en); ?>" class="contact-cta-box reveal reveal-delay-3">
        <span class="contact-cta-label">Book your diagnostic</span>
        <span class="contact-cta-text">Book a strategic call →</span>
        <span class="contact-cta-sub">Reply within 24h · Limited availability</span>
      </a>
    </div>
  </div>
</section>

<!-- FOOTER -->
<footer>
  <div class="footer-logo">
    <img src="<?php echo esc_url($logo_url); ?>" alt="PRISM Filmmaking">
  </div>
  <p class="footer-mission">"We transform the invisible technical excellence of French tech companies into a global competitive edge."</p>
  <div class="footer-right">© <?php echo $site_year; ?> PRISM Filmmaking</div>
</footer>

<script>
// Nav scroll effect
const nav = document.getElementById('navbar');
window.addEventListener('scroll', () => {
  nav.classList.toggle('scrolled', window.scrollY > 60);
}, { passive: true });

// Scroll reveal — IntersectionObserver
const revealEls = document.querySelectorAll('.reveal');
const observer = new IntersectionObserver((entries) => {
  entries.forEach(entry => {
    if (entry.isIntersecting) {
      entry.target.classList.add('visible');
      observer.unobserve(entry.target);
    }
  });
}, { threshold: 0.12, rootMargin: '0px 0px -40px 0px' });
revealEls.forEach(el => observer.observe(el));
</script>
<?php wp_footer(); ?>
</body>
</html>
