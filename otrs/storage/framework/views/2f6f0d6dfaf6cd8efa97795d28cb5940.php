<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
<title>OTRS – Online Tour Reservation System</title>
<link rel="preconnect" href="https://fonts.googleapis.com" />
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,700;0,900;1,400&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/lucide/0.383.0/umd/lucide.min.js"></script>
<style>

  /* ─── CSS Variables ─────────────────────────── */
  :root {
    --sand:    #f5ede0;
    --cream:   #faf6f0;
    --brown:   #3b2a1a;
    --tan:     #c49a6c;
    --gold:    #d4a254;
    --teal:    #2d6e6e;
    --teal-lt: #3d8f8f;
    --white:   #ffffff;
    --shadow:  0 8px 40px rgba(59,42,26,.12);
    --radius:  18px;
    --ff-head: 'Playfair Display', Georgia, serif;
    --ff-body: 'DM Sans', sans-serif;
    --nav-h:   72px;
  }

  /* ─── Reset ─────────────────────────────────── */
  *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
  html { scroll-behavior: smooth; }
  body {
    font-family: var(--ff-body);
    background: var(--cream);
    color: var(--brown);
    overflow-x: hidden;
  }
  img { display: block; width: 100%; object-fit: cover; }
  a { text-decoration: none; color: inherit; }

  /* ─── Nav ────────────────────────────────────── */
  nav {
    position: fixed; top: 0; left: 0; right: 0; z-index: 100;
    height: var(--nav-h);
    display: flex; align-items: center; justify-content: space-between;
    padding: 0 6vw;
    background: rgba(250,246,240,.92);
    backdrop-filter: blur(16px);
    border-bottom: 1px solid rgba(196,154,108,.2);
    transition: box-shadow .3s;
  }
  nav.scrolled { box-shadow: 0 4px 30px rgba(59,42,26,.10); }
  .nav-logo {
    font-family: var(--ff-head);
    font-size: 1.5rem;
    font-weight: 900;
    color: var(--teal);
    letter-spacing: -.5px;
  }
  .nav-logo span { color: var(--gold); }
  .nav-links {
    display: flex; gap: 2.5rem; list-style: none;
    font-size: .92rem; font-weight: 500; letter-spacing: .02em;
  }
  .nav-links a {
    color: var(--brown); opacity: .75;
    transition: opacity .2s, color .2s;
    position: relative; padding-bottom: 2px;
  }
  .nav-links a::after {
    content:''; position:absolute; bottom:0; left:0; right:100%;
    height:1.5px; background: var(--gold);
    transition: right .25s ease;
  }
  .nav-links a:hover { opacity: 1; color: var(--teal); }
  .nav-links a:hover::after { right: 0; }
  .nav-cta {
    background: var(--teal); color: var(--white);
    padding: .55rem 1.4rem; border-radius: 50px;
    font-size: .88rem; font-weight: 600;
    transition: background .2s, transform .15s;
  }
  .nav-cta:hover { background: var(--teal-lt); transform: translateY(-1px); }
  .hamburger { display: none; flex-direction: column; gap: 5px; cursor: pointer; }
  .hamburger span { width: 24px; height: 2px; background: var(--brown); border-radius: 2px; transition: .3s; }

  /* ─── Sections common ───────────────────────── */
  section { padding: 100px 6vw; }
  .section-tag {
    display: inline-block;
    font-size: .78rem; font-weight: 600; letter-spacing: .12em;
    text-transform: uppercase; color: var(--gold);
    margin-bottom: 1rem;
  }
  h1, h2, h3 { font-family: var(--ff-head); line-height: 1.15; }
  h2 { font-size: clamp(2rem, 4vw, 3rem); color: var(--brown); }

  /* ─── HERO ───────────────────────────────────── */
  #home {
    min-height: 100vh;
    display: grid;
    grid-template-columns: 1fr 1fr;
    align-items: center;
    gap: 4rem;
    padding-top: calc(var(--nav-h) + 60px);
    padding-bottom: 80px;
    background:
      radial-gradient(ellipse 70% 60% at 75% 50%, rgba(45,110,110,.08) 0%, transparent 70%),
      var(--cream);
    position: relative;
    overflow: hidden;
  }
  #home::before {
    content:'';
    position:absolute; bottom:-80px; right:-80px;
    width: 420px; height: 420px;
    border-radius: 50%;
    border: 60px solid rgba(212,162,84,.07);
    pointer-events: none;
  }
  #home::after {
    content:'';
    position:absolute; top:140px; left:-60px;
    width: 240px; height: 240px;
    border-radius: 50%;
    border: 40px solid rgba(45,110,110,.06);
    pointer-events: none;
  }
  .hero-text { position: relative; z-index: 1; }
  .hero-eyebrow {
    display: flex; align-items: center; gap: .75rem;
    margin-bottom: 1.4rem;
  }
  .hero-eyebrow span {
    font-size: .8rem; font-weight: 600; letter-spacing: .14em;
    text-transform: uppercase; color: var(--teal);
  }
  .hero-eyebrow::before {
    content:''; display:block;
    width: 36px; height: 2px; background: var(--gold);
  }
  .hero-text h1 {
    font-size: clamp(2.8rem, 5.5vw, 5rem);
    font-weight: 900;
    color: var(--brown);
    line-height: 1.08;
    margin-bottom: 1.4rem;
  }
  .hero-text h1 em { font-style: italic; color: var(--teal); }
  .hero-text p {
    font-size: 1.08rem; line-height: 1.75;
    color: rgba(59,42,26,.65); max-width: 460px;
    margin-bottom: 2.4rem;
  }
  .hero-btns { display: flex; gap: 1rem; flex-wrap: wrap; }
  .btn-primary {
    background: var(--teal); color: var(--white);
    padding: .85rem 2.2rem; border-radius: 50px;
    font-size: .95rem; font-weight: 600;
    box-shadow: 0 6px 20px rgba(45,110,110,.3);
    transition: background .2s, transform .15s, box-shadow .2s;
    display: inline-flex; align-items: center; gap: .5rem;
  }
  .btn-primary:hover { background: var(--teal-lt); transform: translateY(-2px); box-shadow: 0 10px 28px rgba(45,110,110,.35); }
  .btn-secondary {
    border: 2px solid var(--tan); color: var(--brown);
    padding: .82rem 2.1rem; border-radius: 50px;
    font-size: .95rem; font-weight: 600;
    transition: border-color .2s, color .2s, transform .15s;
    display: inline-flex; align-items: center; gap: .5rem;
  }
  .btn-secondary:hover { border-color: var(--teal); color: var(--teal); transform: translateY(-2px); }
  .hero-stats {
    display: flex; gap: 2.5rem; margin-top: 3rem;
    padding-top: 2rem;
    border-top: 1px solid rgba(196,154,108,.25);
  }
  .stat-num { font-family: var(--ff-head); font-size: 1.9rem; font-weight: 900; color: var(--teal); }
  .stat-label { font-size: .8rem; font-weight: 500; color: rgba(59,42,26,.55); margin-top: .1rem; }
  .hero-visual {
    position: relative; z-index: 1;
    display: grid;
    grid-template-columns: 1fr 1fr;
    grid-template-rows: auto auto;
    gap: 1rem;
  }
  .hero-img-main {
    grid-column: 1 / 3;
    border-radius: var(--radius) var(--radius) 0 0;
    height: 300px;
    overflow: hidden;
    box-shadow: var(--shadow);
  }
  .hero-img-sm {
    height: 160px;
    border-radius: 0 0 0 var(--radius);
    overflow: hidden;
    box-shadow: var(--shadow);
  }
  .hero-img-sm:last-child { border-radius: 0 0 var(--radius) 0; }
  .hero-img-main img,
  .hero-img-sm img { height: 100%; }
  .hero-badge {
    position: absolute; bottom: 24px; left: -20px;
    background: var(--white);
    border-radius: 14px;
    padding: .9rem 1.2rem;
    box-shadow: 0 8px 30px rgba(59,42,26,.18);
    display: flex; align-items: center; gap: .75rem;
    z-index: 2;
  }
  .hero-badge-icon { width: 32px; height: 32px; color: var(--gold); flex-shrink: 0; }
  .hero-badge-icon svg { width: 100%; height: 100%; }
  .hero-badge-text { font-size: .78rem; font-weight: 600; color: var(--brown); line-height: 1.3; }
  .hero-badge-text span { display: block; font-weight: 400; color: rgba(59,42,26,.5); }

  /* ─── ABOUT ──────────────────────────────────── */
  #about {
    background: var(--brown);
    color: var(--sand);
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 6rem;
    align-items: center;
  }
  #about .section-tag { color: var(--gold); }
  #about h2 { color: var(--sand); }
  #about p { color: rgba(245,237,224,.72); line-height: 1.8; margin-top: 1.2rem; font-size: 1rem; }
  .mv-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-top: 2.5rem; }
  .mv-card {
    background: rgba(255,255,255,.06);
    border: 1px solid rgba(212,162,84,.2);
    border-radius: var(--radius);
    padding: 1.8rem 1.5rem;
  }
  .mv-icon { width: 40px; height: 40px; margin-bottom: .8rem; color: var(--gold); }
  .mv-icon svg { width: 100%; height: 100%; stroke: currentColor; }
  .mv-card h3 { font-family: var(--ff-head); font-size: 1.1rem; color: var(--gold); margin-bottom: .6rem; }
  .mv-card p { font-size: .88rem; color: rgba(245,237,224,.65); line-height: 1.7; margin: 0; }
  .about-visual {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1rem;
    position: relative;
  }
  .about-img-wrap {
    display: flex;
    flex-direction: column;
    gap: .5rem;
  }
  .about-img {
    border-radius: var(--radius);
    overflow: hidden;
    height: 200px;
    box-shadow: 0 12px 40px rgba(0,0,0,.3);
  }
  .about-img:first-child { height: 260px; }
  .about-img-wrap:first-of-type .about-img { height: 260px; }
  .about-img-sm { height: 180px !important; }
  .about-img img { height: 100%; width: 100%; object-fit: cover; transition: transform .4s ease; }
  .about-img:hover img { transform: scale(1.04); }
  .about-img-label {
    font-size: .78rem;
    font-weight: 700;
    letter-spacing: .1em;
    text-transform: uppercase;
    color: var(--gold);
    text-align: center;
    padding: .2rem 0 .3rem;
  }
  .about-pill {
    position: absolute; top: -18px; right: -18px;
    background: var(--gold);
    color: var(--brown);
    border-radius: 50px;
    padding: .6rem 1.3rem;
    font-size: .82rem; font-weight: 700;
    box-shadow: 0 6px 20px rgba(212,162,84,.4);
  }

  /* ─── SERVICES ───────────────────────────────── */
  #services { background: var(--sand); }
  .services-header { text-align: center; max-width: 560px; margin: 0 auto 3.5rem; }
  .services-header p { margin-top: .8rem; color: rgba(59,42,26,.6); line-height: 1.7; }
  .cards-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(290px, 1fr));
    gap: 1.6rem;
  }
  .card {
    background: var(--white);
    border-radius: var(--radius);
    overflow: hidden;
    box-shadow: 0 4px 20px rgba(59,42,26,.07);
    transition: transform .25s, box-shadow .25s;
    display: flex; flex-direction: column;
  }
  .card:hover { transform: translateY(-6px); box-shadow: 0 16px 40px rgba(59,42,26,.14); }
  .card-img { height: 200px; overflow: hidden; position: relative; }
  .card-img img { height: 100%; transition: transform .4s ease; }
  .card:hover .card-img img { transform: scale(1.05); }
  .card-badge {
    position: absolute; top: 14px; left: 14px;
    background: var(--teal); color: var(--white);
    font-size: .72rem; font-weight: 700; letter-spacing: .05em;
    text-transform: uppercase; padding: .3rem .75rem;
    border-radius: 50px;
  }
  .card-body { padding: 1.5rem; flex: 1; display: flex; flex-direction: column; }
  .card-body h3 { font-family: var(--ff-head); font-size: 1.25rem; margin-bottom: .6rem; }
  .card-body p { font-size: .88rem; color: rgba(59,42,26,.6); line-height: 1.65; flex: 1; }
  .card-footer {
    display: flex; align-items: center; justify-content: space-between;
    padding: 1rem 1.5rem 1.5rem;
    border-top: 1px solid rgba(59,42,26,.07);
    margin-top: auto;
  }
  .card-price { font-family: var(--ff-head); font-size: 1.4rem; font-weight: 700; color: var(--teal); }
  .card-price small { font-family: var(--ff-body); font-size: .75rem; font-weight: 400; color: rgba(59,42,26,.45); }
  .card-btn {
    background: var(--teal); color: var(--white);
    border: none; border-radius: 50px;
    padding: .5rem 1.2rem;
    font-family: var(--ff-body); font-size: .85rem; font-weight: 600;
    cursor: pointer;
    transition: background .2s, transform .15s;
  }
  .card-btn:hover { background: var(--teal-lt); transform: translateY(-1px); }

  /* ─── FAQ ────────────────────────────────────── */
  #faq { background: var(--cream); }
  .faq-wrap { display: grid; grid-template-columns: 1fr 1.4fr; gap: 6rem; align-items: start; }
  .faq-left h2 { margin-bottom: 1rem; }
  .faq-left p { color: rgba(59,42,26,.6); line-height: 1.75; margin-bottom: 2rem; }
  .faq-contact {
    display: inline-flex; align-items: center; gap: .6rem;
    background: var(--teal); color: var(--white);
    padding: .7rem 1.6rem; border-radius: 50px;
    font-size: .88rem; font-weight: 600;
    transition: background .2s;
  }
  .faq-contact:hover { background: var(--teal-lt); }
  .accordion { display: flex; flex-direction: column; gap: .75rem; }
  .acc-item {
    background: var(--white);
    border-radius: var(--radius);
    border: 1px solid rgba(59,42,26,.09);
    overflow: hidden;
    box-shadow: 0 2px 12px rgba(59,42,26,.05);
    transition: box-shadow .2s;
  }
  .acc-item.open { box-shadow: 0 6px 24px rgba(45,110,110,.12); border-color: rgba(45,110,110,.2); }
  .acc-header {
    display: flex; align-items: center; justify-content: space-between;
    padding: 1.3rem 1.5rem;
    cursor: pointer;
    user-select: none;
  }
  .acc-header h3 { font-family: var(--ff-body); font-size: .98rem; font-weight: 600; }
  .acc-icon {
    width: 28px; height: 28px;
    background: var(--sand);
    border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    font-size: .85rem;
    flex-shrink: 0;
    transition: background .2s, transform .3s;
    color: var(--teal);
  }
  .acc-item.open .acc-icon { background: var(--teal); color: var(--white); transform: rotate(45deg); }
  .acc-body {
    max-height: 0; overflow: hidden;
    transition: max-height .38s ease, padding .3s;
    padding: 0 1.5rem;
    font-size: .92rem;
    line-height: 1.75;
    color: rgba(59,42,26,.65);
  }
  .acc-item.open .acc-body { max-height: 300px; padding-bottom: 1.4rem; }

  /* ─── Footer ─────────────────────────────────── */
  footer {
    background: var(--brown); color: rgba(245,237,224,.7);
    padding: 60px 6vw 30px;
  }
  .footer-top { display: grid; grid-template-columns: 1.5fr 1fr 1fr 1fr; gap: 3rem; margin-bottom: 3rem; }
  .footer-brand .nav-logo { font-size: 1.6rem; margin-bottom: 1rem; }
  .footer-brand p { font-size: .88rem; line-height: 1.7; max-width: 240px; }
  .footer-col h4 { font-family: var(--ff-head); font-size: 1rem; color: var(--sand); margin-bottom: 1rem; }
  .footer-col ul { list-style: none; display: flex; flex-direction: column; gap: .55rem; }
  .footer-col ul li a { font-size: .88rem; color: rgba(245,237,224,.6); transition: color .2s; }
  .footer-col ul li a:hover { color: var(--gold); }
  .footer-bottom {
    border-top: 1px solid rgba(255,255,255,.1);
    padding-top: 1.5rem;
    display: flex; align-items: center; justify-content: space-between;
    font-size: .82rem; color: rgba(245,237,224,.45);
  }
  .social-links { display: flex; gap: 1rem; }
  .social-links a {
    width: 34px; height: 34px;
    border: 1px solid rgba(255,255,255,.15);
    border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    font-size: .9rem;
    transition: border-color .2s, background .2s;
  }
  .social-links a:hover { border-color: var(--gold); background: rgba(212,162,84,.15); }

  /* ─── Animations ─────────────────────────────── */
  @keyframes fadeUp {
    from { opacity:0; transform:translateY(28px); }
    to   { opacity:1; transform:translateY(0); }
  }
  .fade-up { animation: fadeUp .65s ease both; }
  .delay-1 { animation-delay: .1s; }
  .delay-2 { animation-delay: .22s; }
  .delay-3 { animation-delay: .36s; }
  .delay-4 { animation-delay: .5s; }

  /* ─── Responsive ─────────────────────────────── */
  @media (max-width: 900px) {
    #home { grid-template-columns: 1fr; }
    #about { grid-template-columns: 1fr; }
    #faq .faq-wrap { grid-template-columns: 1fr; gap: 3rem; }
    .footer-top { grid-template-columns: 1fr 1fr; gap: 2rem; }
    .mv-grid { grid-template-columns: 1fr; }
    .hero-visual { display: none; }
  }
  @media (max-width: 640px) {
    section { padding: 80px 5vw; }
    .nav-links { display: none; }
    .hamburger { display: flex; }
    .footer-top { grid-template-columns: 1fr; }
    .footer-bottom { flex-direction: column; gap: 1rem; text-align: center; }
    .hero-stats { flex-wrap: wrap; gap: 1.5rem; }
  }

  /* Mobile nav open */
  .nav-links.open {
    display: flex !important;
    flex-direction: column;
    position: fixed;
    top: var(--nav-h); left: 0; right: 0;
    background: var(--cream);
    padding: 2rem 6vw 2rem;
    gap: 1.2rem;
    border-bottom: 1px solid rgba(196,154,108,.2);
    box-shadow: 0 8px 30px rgba(59,42,26,.1);
    z-index: 99;
  }

</style>
</head>
<body>

<!-- ─── NAV ─────────────────────────────────────── -->
<nav id="main-nav">
  <div class="nav-logo">OTR<span>S</span></div>
  <ul class="nav-links" id="nav-links">
    <li><a href="#home">Home</a></li>
    <li><a href="#about">About</a></li>
    <li><a href="#services">Services</a></li>
    <li><a href="#faq">FAQ</a></li>
  </ul>
  <a href="<?php echo e(route('bookings.create')); ?>" class="nav-cta" style="display:inline-flex;align-items:center;gap:.45rem;">
    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M17.8 19.2L16 11l3.5-3.5C21 6 21 4 19 4c-1 0-1.5.5-3.5 2.5L11 8.2 2.8 6.4 2 7.2l3 5.5-2 1.7v2.2l3-1.5 1.5 3h2.2l1.7-2 5.5 3 .9-.9z"/></svg>
    Book Now
  </a>
  <div class="nav-auth-links" style="display:flex;gap:.75rem;align-items:center;margin-left:1rem;">
    <?php if(auth()->guard()->guest()): ?>
      <a href="<?php echo e(route('login')); ?>" style="font-size:.88rem;font-weight:600;color:var(--teal);padding:.4rem .9rem;border-radius:50px;border:1.5px solid var(--teal);transition:.2s;" onmouseover="this.style.background='var(--teal)';this.style.color='#fff'" onmouseout="this.style.background='transparent';this.style.color='var(--teal)'">Login</a>
      <a href="<?php echo e(route('register')); ?>" style="font-size:.88rem;font-weight:600;color:#fff;background:var(--gold);padding:.4rem .9rem;border-radius:50px;border:1.5px solid var(--gold);transition:.2s;" onmouseover="this.style.background='#c4912e'" onmouseout="this.style.background='var(--gold)'">Register</a>
    <?php else: ?>
      <a href="<?php echo e(route('dashboard')); ?>" style="font-size:.88rem;font-weight:600;color:var(--teal);padding:.4rem .9rem;border-radius:50px;border:1.5px solid var(--teal);">Dashboard</a>
    <?php endif; ?>
  </div>
  <div class="hamburger" id="hamburger">
    <span></span><span></span><span></span>
  </div>
</nav>

<!-- ─── HOME ─────────────────────────────────────── -->
<section id="home">
  <div class="hero-text">
    <div class="hero-eyebrow"><span>Welcome to OTRS</span></div>
    <h1 class="fade-up">Discover the World, <em>Your Way</em></h1>
    <p class="fade-up delay-1">Plan, book, and embark on extraordinary journeys — all in one seamless platform. From pristine beaches to mountain trails, we make travel effortless.</p>
    <div class="hero-btns fade-up delay-2">
      <a href="<?php echo e(route('bookings.create')); ?>" class="btn-primary">
        <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M17.8 19.2L16 11l3.5-3.5C21 6 21 4 19 4c-1 0-1.5.5-3.5 2.5L11 8.2 2.8 6.4 2 7.2l3 5.5-2 1.7v2.2l3-1.5 1.5 3h2.2l1.7-2 5.5 3 .9-.9z"/></svg>
        Book Now
      </a>
      <a href="#about" class="btn-secondary">
        Learn More
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
      </a>
    </div>
    <div class="hero-stats fade-up delay-3">
      <div>
        <div class="stat-num">500+</div>
        <div class="stat-label">Destinations</div>
      </div>
      <div>
        <div class="stat-num">12K+</div>
        <div class="stat-label">Happy Travelers</div>
      </div>
      <div>
        <div class="stat-num">98%</div>
        <div class="stat-label">Satisfaction Rate</div>
      </div>
    </div>
  </div>

  <div class="hero-visual fade-up delay-2">
    <div class="hero-img-main">
      <img src="https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=800&q=80" alt="Mountain landscape" />
    </div>
    <div class="hero-img-sm">
      <img src="https://images.unsplash.com/photo-1507525428034-b723cf961d3e?w=400&q=80" alt="Beach" />
    </div>
    <div class="hero-img-sm">
      <img src="https://images.unsplash.com/photo-1555400038-63f5ba517a47?w=400&q=80" alt="City" />
    </div>
    <div class="hero-badge">
      <div class="hero-badge-icon">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="8" r="6"/><path d="M15.477 12.89L17 22l-5-3-5 3 1.523-9.11"/></svg>
      </div>
      <div class="hero-badge-text">
        Top Rated Agency
        <span>by TravelAwards 2024</span>
      </div>
    </div>
  </div>
</section>

<!-- ─── ABOUT ─────────────────────────────────────── -->
<section id="about">
  <div>
    <div class="section-tag">Who We Are</div>
    <h2>Your Trusted Travel Partner Since 2010</h2>
    <p>OTRS (Online Tour Reservation System) is a premier digital travel platform dedicated to crafting unforgettable experiences for every type of adventurer. We combine cutting-edge technology with personal expertise to deliver seamless journeys worldwide.</p>
    <p>From solo backpackers to family getaways and corporate retreats — we tailor every itinerary to match your vision, budget, and timeline.</p>
    <div class="mv-grid">
      <div class="mv-card">
        <div class="mv-icon">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><circle cx="12" cy="12" r="6"/><circle cx="12" cy="12" r="2"/></svg>
        </div>
        <h3>Our Mission</h3>
        <p>To make world-class travel accessible, affordable, and effortless for every individual — connecting people with extraordinary destinations through seamless technology.</p>
      </div>
      <div class="mv-card">
        <div class="mv-icon">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M2 12h20"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/></svg>
        </div>
        <h3>Our Vision</h3>
        <p>To become the most trusted online travel platform in Southeast Asia, inspiring millions to explore the world's wonders with confidence and joy.</p>
      </div>
    </div>
  </div>

  <div class="about-visual">
    <div class="about-pill" style="display:inline-flex;align-items:center;gap:.4rem;">
      <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
      Est. 2010
    </div>
    <div class="about-img-wrap" style="grid-column:1/3;">
      <div class="about-img">
        <img src="https://images.unsplash.com/photo-1476514525535-07fb3b4ae5f1?w=800&q=80"
             onerror="this.src='https://picsum.photos/seed/travel/800/400'"
             alt="Travel" />
      </div>
      <div class="about-img-label">Travel</div>
    </div>
    <div class="about-img-wrap">
      <div class="about-img about-img-sm">
        <img src="https://images.unsplash.com/photo-1551632811-561732d1e306?w=600&q=80"
             onerror="this.src='https://picsum.photos/seed/adventure/600/400'"
             alt="Adventure" />
      </div>
      <div class="about-img-label">Adventure</div>
    </div>
    <div class="about-img-wrap">
      <div class="about-img about-img-sm">
        <img src="https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=600&q=80"
             onerror="this.src='https://picsum.photos/seed/landscape/600/400'"
             alt="Landscape" />
      </div>
      <div class="about-img-label">Landscape</div>
    </div>
  </div>
</section>

<!-- ─── SERVICES ───────────────────────────────────── -->
<section id="services">
  <div class="services-header">
    <div class="section-tag">Our Packages</div>
    <h2>Curated Trips & Tours</h2>
    <p>Handpicked experiences crafted by our travel experts. Every package includes accommodation, guided tours, and 24/7 support.</p>
  </div>

  <div class="cards-grid">

    <div class="card">
      <div class="card-img">
        <img src="https://images.unsplash.com/photo-1518548419970-58e3b4079ab2?w=600&q=80" alt="Palawan" />
        <span class="card-badge">Best Seller</span>
      </div>
      <div class="card-body">
        <h3>Palawan Island Escape</h3>
        <p>Explore the pristine beaches, hidden lagoons, and turquoise waters of El Nido and Coron in one breathtaking trip.</p>
      </div>
      <div class="card-footer">
        <div class="card-price">₱8,500 <small>/ person</small></div>
        <button class="card-btn" onclick="bookNow('Palawan Island Escape')">Book Now</button>
      </div>
    </div>

    <div class="card">
      <div class="card-img">
        <img src="https://images.unsplash.com/photo-1537996194471-e657df975ab4?w=600&q=80" alt="Bali" />
        <span class="card-badge">Popular</span>
      </div>
      <div class="card-body">
        <h3>Bali Cultural Journey</h3>
        <p>Immerse yourself in Bali's rich temples, terraced rice fields, artisan villages, and vibrant sunset ceremonies.</p>
      </div>
      <div class="card-footer">
        <div class="card-price">₱18,900 <small>/ person</small></div>
        <button class="card-btn" onclick="bookNow('Bali Cultural Journey')">Book Now</button>
      </div>
    </div>

    <div class="card">
      <div class="card-img">
        <img src="https://images.unsplash.com/photo-1528360983277-13d401cdc186?w=600&q=80" alt="Tokyo" />
      </div>
      <div class="card-body">
        <h3>Tokyo City Explorer</h3>
        <p>Blend ancient temples and ultra-modern skylines in this exciting 7-day Tokyo adventure with a day trip to Mt. Fuji.</p>
      </div>
      <div class="card-footer">
        <div class="card-price">₱42,000 <small>/ person</small></div>
        <button class="card-btn" onclick="bookNow('Tokyo City Explorer')">Book Now</button>
      </div>
    </div>

    <div class="card">
      <div class="card-img">
        <img src="https://images.unsplash.com/photo-1551918120-9739cb430c6d?w=600&q=80" alt="Paris" />
        <span class="card-badge">Premium</span>
      </div>
      <div class="card-body">
        <h3>Paris Romantic Getaway</h3>
        <p>Fall in love with the city of lights — Eiffel Tower, Seine River cruise, Versailles, and world-class cuisine await.</p>
      </div>
      <div class="card-footer">
        <div class="card-price">₱85,000 <small>/ couple</small></div>
        <button class="card-btn" onclick="bookNow('Paris Romantic Getaway')">Book Now</button>
      </div>
    </div>

    <div class="card">
      <div class="card-img">
        <img src="https://images.unsplash.com/photo-1606820854416-439b3305ff39?w=600&q=80" alt="Siargao" />
      </div>
      <div class="card-body">
        <h3>Siargao Surf & Chill</h3>
        <p>Ride the famous Cloud 9 waves, explore island-hop routes, and unwind in laid-back beach bungalows.</p>
      </div>
      <div class="card-footer">
        <div class="card-price">₱6,500 <small>/ person</small></div>
        <button class="card-btn" onclick="bookNow('Siargao Surf & Chill')">Book Now</button>
      </div>
    </div>

    <div class="card">
      <div class="card-img">
        <img src="https://images.unsplash.com/photo-1524231757912-21f4fe3a7200?w=600&q=80" alt="Dubai" />
        <span class="card-badge">Luxury</span>
      </div>
      <div class="card-body">
        <h3>Dubai Luxury Experience</h3>
        <p>From desert safaris and Burj Khalifa to gold souks and infinity pools — Dubai redefines extravagance.</p>
      </div>
      <div class="card-footer">
        <div class="card-price">₱95,000 <small>/ person</small></div>
        <button class="card-btn" onclick="bookNow('Dubai Luxury Experience')">Book Now</button>
      </div>
    </div>

  </div>
</section>

<!-- ─── FAQ ───────────────────────────────────────── -->
<section id="faq">
  <div class="faq-wrap">
    <div class="faq-left">
      <div class="section-tag">Got Questions?</div>
      <h2>Frequently Asked Questions</h2>
      <p>Everything you need to know before your next adventure. Can't find an answer? Our travel consultants are always happy to help.</p>
      <a href="mailto:support@otrs.ph" class="faq-contact">
        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="20" height="16" x="2" y="4" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>
        Contact Support
      </a>
    </div>

    <div class="accordion">

      <div class="acc-item open">
        <div class="acc-header" onclick="toggleAcc(this)">
          <h3>How do I book a trip or tour package?</h3>
          <div class="acc-icon">+</div>
        </div>
        <div class="acc-body">
          Booking is simple! Browse our Services page, select your preferred package, and click <strong>"Book Now."</strong> You'll fill in your travel details, choose your travel dates and group size, then proceed to payment. You'll receive a confirmation email within 15 minutes of completing your booking.
        </div>
      </div>

      <div class="acc-item">
        <div class="acc-header" onclick="toggleAcc(this)">
          <h3>What payment methods are accepted?</h3>
          <div class="acc-icon">+</div>
        </div>
        <div class="acc-body">
          We accept a wide range of payment options for your convenience: <strong>credit/debit cards</strong> (Visa, Mastercard, JCB), <strong>online banking</strong> transfers, <strong>GCash, Maya (PayMaya)</strong>, <strong>PayPal</strong>, and <strong>over-the-counter bank deposits</strong>. Installment plans are available for packages above ₱30,000.
        </div>
      </div>

      <div class="acc-item">
        <div class="acc-header" onclick="toggleAcc(this)">
          <h3>What is the cancellation policy?</h3>
          <div class="acc-icon">+</div>
        </div>
        <div class="acc-body">
          Cancellations made <strong>30 or more days</strong> before departure receive a full refund minus a ₱500 processing fee. Cancellations <strong>15–29 days</strong> prior receive a 50% refund. Cancellations within <strong>14 days</strong> of departure are non-refundable, though credits may be issued for future bookings. Travel insurance is strongly recommended.
        </div>
      </div>

      <div class="acc-item">
        <div class="acc-header" onclick="toggleAcc(this)">
          <h3>Are flights included in the packages?</h3>
          <div class="acc-icon">+</div>
        </div>
        <div class="acc-body">
          Flight inclusions vary by package. Domestic tours (e.g., Palawan, Siargao) include roundtrip airfare by default. International packages show a base land price; flights can be bundled during checkout for convenience. Our team can also assist with separate flight bookings upon request.
        </div>
      </div>

      <div class="acc-item">
        <div class="acc-header" onclick="toggleAcc(this)">
          <h3>Can I customize a package to fit my needs?</h3>
          <div class="acc-icon">+</div>
        </div>
        <div class="acc-body">
          Absolutely! We love building personalized itineraries. Simply contact our travel consultants via the chat widget or email us at <strong>bookings@otrs.ph</strong>. Tell us your destination, budget, travel dates, and any special requests — we'll design a tailor-made package just for you within 24 hours.
        </div>
      </div>

      <div class="acc-item">
        <div class="acc-header" onclick="toggleAcc(this)">
          <h3>Is travel insurance required?</h3>
          <div class="acc-icon">+</div>
        </div>
        <div class="acc-body">
          Travel insurance is strongly recommended and required for all international packages. We partner with reputable insurers to offer affordable coverage for trip cancellation, medical emergencies, lost baggage, and flight delays. You can add it during checkout for peace of mind throughout your journey.
        </div>
      </div>

    </div>
  </div>
</section>

<!-- ─── FOOTER ─────────────────────────────────────── -->
<footer>
  <div class="footer-top">
    <div class="footer-brand">
      <div class="nav-logo">OTR<span>S</span></div>
      <p>Your trusted online tour reservation platform — making every journey seamless, affordable, and unforgettable.</p>
    </div>
    <div class="footer-col">
      <h4>Navigate</h4>
      <ul>
        <li><a href="#home">Home</a></li>
        <li><a href="#about">About Us</a></li>
        <li><a href="#services">Services</a></li>
        <li><a href="#faq">FAQ</a></li>
      </ul>
    </div>
    <div class="footer-col">
      <h4>Popular Tours</h4>
      <ul>
        <li><a href="#services">Palawan Escape</a></li>
        <li><a href="#services">Bali Journey</a></li>
        <li><a href="#services">Tokyo Explorer</a></li>
        <li><a href="#services">Paris Getaway</a></li>
      </ul>
    </div>
    <div class="footer-col">
      <h4>Contact</h4>
      <ul>
        <li><a href="mailto:info@otrs.ph">info@otrs.ph</a></li>
        <li><a href="tel:+63281234567">+63 (2) 8123-4567</a></li>
        <li><a href="#">Manila, Philippines</a></li>
        <li><a href="#">Mon–Fri 8AM–8PM</a></li>
      </ul>
    </div>
  </div>
  <div class="footer-bottom">
    <span>© 2024 OTRS – Online Tour Reservation System. All rights reserved.</span>
    <div class="social-links">
      <a href="#" title="Facebook">
        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/></svg>
      </a>
      <a href="#" title="Instagram">
        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="20" height="20" x="2" y="2" rx="5" ry="5"/><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/><line x1="17.5" x2="17.51" y1="6.5" y2="6.5"/></svg>
      </a>
      <a href="#" title="Twitter / X">
        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4l16 16M4 20L20 4"/></svg>
      </a>
    </div>
  </div>
</footer>

<!-- ─── Booking Modal ─────────────────────────────── -->
<div id="modal-overlay" style="display:none;position:fixed;inset:0;background:rgba(59,42,26,.55);z-index:200;align-items:center;justify-content:center;backdrop-filter:blur(6px);">
  <div style="background:var(--white);border-radius:24px;padding:2.5rem;max-width:420px;width:90%;box-shadow:0 24px 60px rgba(59,42,26,.25);animation:fadeUp .3s ease;">
    <h3 style="font-family:var(--ff-head);font-size:1.5rem;margin-bottom:.4rem;" id="modal-title">Book Your Trip</h3>
    <p style="font-size:.88rem;color:rgba(59,42,26,.6);margin-bottom:1.5rem;">Fill in your details and we'll confirm your booking within 15 minutes.</p>
    <label style="display:block;font-size:.82rem;font-weight:600;margin-bottom:.4rem;color:var(--brown);">Full Name</label>
    <input type="text" placeholder="Juan dela Cruz" style="width:100%;padding:.75rem 1rem;border:1.5px solid rgba(59,42,26,.15);border-radius:10px;font-family:var(--ff-body);font-size:.92rem;margin-bottom:1rem;outline:none;transition:border .2s;" onfocus="this.style.borderColor='var(--teal)'" onblur="this.style.borderColor='rgba(59,42,26,.15)'" />
    <label style="display:block;font-size:.82rem;font-weight:600;margin-bottom:.4rem;color:var(--brown);">Email Address</label>
    <input type="email" placeholder="juan@email.com" style="width:100%;padding:.75rem 1rem;border:1.5px solid rgba(59,42,26,.15);border-radius:10px;font-family:var(--ff-body);font-size:.92rem;margin-bottom:1rem;outline:none;transition:border .2s;" onfocus="this.style.borderColor='var(--teal)'" onblur="this.style.borderColor='rgba(59,42,26,.15)'" />
    <label style="display:block;font-size:.82rem;font-weight:600;margin-bottom:.4rem;color:var(--brown);">Travel Date</label>
    <input type="date" style="width:100%;padding:.75rem 1rem;border:1.5px solid rgba(59,42,26,.15);border-radius:10px;font-family:var(--ff-body);font-size:.92rem;margin-bottom:1.8rem;outline:none;transition:border .2s;" onfocus="this.style.borderColor='var(--teal)'" onblur="this.style.borderColor='rgba(59,42,26,.15)'" />
    <div style="display:flex;gap:.75rem;">
      <button onclick="closeModal()" style="flex:1;padding:.8rem;border:2px solid rgba(59,42,26,.15);background:none;border-radius:50px;font-family:var(--ff-body);font-size:.9rem;font-weight:600;cursor:pointer;transition:.2s;" onmouseover="this.style.borderColor='var(--teal)';this.style.color='var(--teal)'" onmouseout="this.style.borderColor='rgba(59,42,26,.15)';this.style.color=''">Cancel</button>
      <button onclick="submitBooking()" style="flex:2;padding:.8rem;background:var(--teal);color:white;border:none;border-radius:50px;font-family:var(--ff-body);font-size:.9rem;font-weight:600;cursor:pointer;transition:.2s;display:inline-flex;align-items:center;justify-content:center;gap:.4rem;" onmouseover="this.style.background='var(--teal-lt)'" onmouseout="this.style.background='var(--teal)'">
        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6 9 17l-5-5"/></svg>
        Confirm Booking
      </button>
    </div>
  </div>
</div>

<script>
  // Nav scroll shadow
  window.addEventListener('scroll', () => {
    document.getElementById('main-nav').classList.toggle('scrolled', window.scrollY > 20);
  });

  // Hamburger
  document.getElementById('hamburger').addEventListener('click', function() {
    document.getElementById('nav-links').classList.toggle('open');
  });
  document.getElementById('nav-links').querySelectorAll('a').forEach(a => {
    a.addEventListener('click', () => document.getElementById('nav-links').classList.remove('open'));
  });

  // Accordion
  function toggleAcc(header) {
    const item = header.parentElement;
    const isOpen = item.classList.contains('open');
    document.querySelectorAll('.acc-item').forEach(i => i.classList.remove('open'));
    if (!isOpen) item.classList.add('open');
  }

  // Modal
  let currentPackage = '';
  function bookNow(pkg) {
    window.location.href = '<?php echo e(route("bookings.create")); ?>';
    return;
    currentPackage = pkg;
    document.getElementById('modal-title').textContent = 'Book: ' + pkg;
    const mo = document.getElementById('modal-overlay');
    mo.style.display = 'flex';
  }
  function closeModal() {
    document.getElementById('modal-overlay').style.display = 'none';
  }
  function submitBooking() {
    alert('Booking request sent for "' + currentPackage + '"!\nWe\'ll email your confirmation shortly.');
    closeModal();
  }
  document.getElementById('modal-overlay').addEventListener('click', function(e) {
    if (e.target === this) closeModal();
  });

  // Init Lucide icons
  if (typeof lucide !== 'undefined') lucide.createIcons();
</script>

</body>
</html>
<?php /**PATH C:\Users\AMVI User\OneDrive - Agata Mining Ventures\Desktop\laravel\otrs\resources\views/landing.blade.php ENDPATH**/ ?>