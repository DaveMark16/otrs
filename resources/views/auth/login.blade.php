<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'OTRS') }} — Sign In</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,700;0,900;1,400;1,700&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root {
            --cream:   #faf6f0;
            --brown:   #3b2a1a;
            --gold:    #d4a254;
            --gold-lt: #e2b46a;
            --teal:    #2d6e6e;
            --teal-lt: #3d8f8f;
            --white:   #ffffff;
            --ff-head: 'Playfair Display', Georgia, serif;
            --ff-body: 'DM Sans', sans-serif;
            --radius-sm: 10px;
        }

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        html, body {
            height: 100%;
            font-family: var(--ff-body);
            background: var(--cream);
            overflow: hidden;
        }

        /* ══════════════════════════════════════
           FULL-PAGE TWO-COLUMN LAYOUT
        ══════════════════════════════════════ */
        .page-wrap {
            display: flex;
            height: 100vh;
            width: 100%;
        }

        /* ── LEFT HALF — exact landing page hero ── */
        .hero-col {
            flex: 1;
            background: var(--cream);
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 60px 56px 60px 64px;
            position: relative;
            overflow: hidden;
        }

        /* big decorative circle behind text (matches landing page) */
        .hero-col::before {
            content: '';
            position: absolute;
            left: -120px;
            top: 50%;
            transform: translateY(-50%);
            width: 420px;
            height: 420px;
            border-radius: 50%;
            background: rgba(45,110,110,0.07);
            pointer-events: none;
        }

        /* inner layout: text left, images right */
        .hero-inner {
            display: flex;
            align-items: center;
            gap: 48px;
            position: relative;
            z-index: 2;
        }

        /* ── Text side ── */
        .hero-text { flex: 1; min-width: 0; }

        .hero-label {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: .7rem;
            font-weight: 700;
            letter-spacing: .16em;
            text-transform: uppercase;
            color: var(--gold);
            margin-bottom: 18px;
        }
        .hero-label::before {
            content: '';
            display: block;
            width: 28px;
            height: 2px;
            background: var(--gold);
            border-radius: 2px;
        }

        .hero-heading {
            font-family: var(--ff-head);
            font-size: clamp(2.4rem, 4vw, 3.4rem);
            font-weight: 900;
            color: var(--brown);
            line-height: 1.08;
            margin-bottom: 20px;
        }
        .hero-heading em {
            font-style: italic;
            color: var(--teal);
        }

        .hero-desc {
            font-size: .95rem;
            color: rgba(59,42,26,.55);
            line-height: 1.7;
            max-width: 300px;
            margin-bottom: 32px;
        }

        .hero-actions {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .btn-book {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: var(--teal);
            color: var(--white);
            text-decoration: none;
            border-radius: 50px;
            padding: 13px 26px;
            font-size: .88rem;
            font-weight: 700;
            font-family: var(--ff-body);
            box-shadow: 0 6px 20px rgba(45,110,110,.30);
            transition: background .18s, transform .15s;
        }
        .btn-book:hover { background: var(--teal-lt); transform: translateY(-1px); }
        .btn-book svg { width: 16px; height: 16px; stroke: currentColor; fill: none; stroke-width: 2; }

        .btn-learn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: transparent;
            color: var(--brown);
            text-decoration: none;
            border-radius: 50px;
            padding: 12px 24px;
            font-size: .88rem;
            font-weight: 600;
            font-family: var(--ff-body);
            border: 1.5px solid rgba(59,42,26,.22);
            transition: border-color .18s, color .18s;
        }
        .btn-learn:hover { border-color: var(--brown); color: var(--brown); }

        /* ── Image grid side ── */
        .hero-images {
            flex-shrink: 0;
            width: 340px;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .img-main {
            width: 100%;
            height: 210px;
            border-radius: 18px;
            object-fit: cover;
            display: block;
            box-shadow: 0 12px 36px rgba(59,42,26,.18);
        }

        .img-row {
            display: flex;
            gap: 10px;
            position: relative;
        }

        .img-small {
            flex: 1;
            height: 130px;
            border-radius: 14px;
            object-fit: cover;
            display: block;
            box-shadow: 0 6px 20px rgba(59,42,26,.14);
        }



        /* ══════════════════════════════════════
           RIGHT HALF — Login card
        ══════════════════════════════════════ */
        .login-col {
            width: 420px;
            flex-shrink: 0;
            background: var(--white);
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 52px 44px;
            box-shadow: -8px 0 48px rgba(59,42,26,.10);
            overflow-y: auto;
        }

        /* brand */
        .card-brand { display:flex; align-items:center; gap:11px; margin-bottom:28px; }
        .card-brand-icon {
            width: 42px; height: 42px; border-radius: 12px;
            background: var(--teal);
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
            box-shadow: 0 4px 14px rgba(45,110,110,.28);
        }
        .card-brand-icon svg { width: 20px; height: 20px; stroke: #fff; fill: none; stroke-width: 2; stroke-linecap: round; }
        .card-brand-name { font-family: var(--ff-head); font-size: 1.25rem; font-weight: 900; color: var(--brown); line-height: 1; }
        .card-brand-name span { color: var(--gold); }
        .card-brand-sub { font-size: .62rem; font-weight: 600; letter-spacing: .14em; text-transform: uppercase; color: rgba(59,42,26,.28); margin-top: 3px; }

        /* heading */
        .login-title { font-family: var(--ff-head); font-size: 1.7rem; font-weight: 900; color: var(--brown); margin-bottom: 5px; }
        .login-sub { font-size: .84rem; color: rgba(59,42,26,.42); margin-bottom: 28px; }

        /* error */
        .alert-error { background: rgba(180,68,68,.06); border: 1.5px solid rgba(180,68,68,.2); border-radius: var(--radius-sm); padding: 11px 14px; margin-bottom: 18px; font-size: .83rem; color: #b44444; display: flex; align-items: center; gap: 8px; }
        .alert-error svg { width: 14px; height: 14px; stroke: currentColor; fill: none; stroke-width: 2; flex-shrink: 0; }

        /* fields */
        .field-group { margin-bottom: 14px; }
        .field-label { font-size: .68rem; font-weight: 700; letter-spacing: .09em; text-transform: uppercase; color: rgba(59,42,26,.38); margin-bottom: 7px; display: block; }
        .field-input {
            width: 100%;
            background: #f5f0ea;
            border: 1.5px solid transparent;
            border-radius: var(--radius-sm);
            padding: 13px 15px;
            font-size: .92rem;
            font-family: var(--ff-body);
            color: var(--brown);
            outline: none;
            transition: border-color .2s, background .2s;
        }
        .field-input:focus { border-color: var(--teal); background: var(--white); }
        .field-input::placeholder { color: rgba(59,42,26,.25); }

        /* forgot */
        .forgot { text-align: right; margin-top: -6px; margin-bottom: 20px; }
        .forgot a { font-size: .8rem; color: var(--teal); text-decoration: none; font-weight: 600; }
        .forgot a:hover { text-decoration: underline; }

        /* submit */
        .login-btn {
            width: 100%;
            background: var(--teal);
            color: var(--white);
            border: none;
            border-radius: 50px;
            padding: 14px;
            font-size: .95rem;
            font-weight: 700;
            font-family: var(--ff-body);
            cursor: pointer;
            transition: background .18s, transform .15s;
            box-shadow: 0 8px 24px rgba(45,110,110,.28);
        }
        .login-btn:hover { background: var(--teal-lt); transform: translateY(-1px); }
        .login-btn:active { transform: translateY(0); }

        /* divider */
        .divider { display:flex; align-items:center; gap:10px; margin: 20px 0 16px; }
        .divider-line { flex:1; height:1px; background: rgba(59,42,26,.10); }
        .divider-text { font-size: .75rem; color: rgba(59,42,26,.32); }

        /* create account */
        .register-btn {
            display: block;
            text-align: center;
            background: transparent;
            color: var(--teal);
            text-decoration: none;
            border: 2px solid var(--teal);
            border-radius: 50px;
            padding: 12px;
            font-size: .92rem;
            font-weight: 700;
            font-family: var(--ff-body);
            transition: background .18s, color .18s;
        }
        .register-btn:hover { background: var(--teal); color: var(--white); }

        .card-footer { text-align: center; margin-top: 20px; font-size: .72rem; color: rgba(59,42,26,.30); line-height: 1.5; }

        /* ── Responsive: stack on small screens ── */
        @media (max-width: 900px) {
            html, body { overflow: auto; }
            .page-wrap { flex-direction: column; height: auto; }
            .hero-col { padding: 48px 28px 40px; }
            .hero-inner { flex-direction: column; }
            .hero-images { width: 100%; }
            .login-col { width: 100%; padding: 40px 28px 56px; box-shadow: none; border-top: 1px solid rgba(59,42,26,.08); }
        }
    </style>
</head>
<body>

<div class="page-wrap">

    {{-- ═══════ LEFT: Landing page hero ═══════ --}}
    <div class="hero-col">
        <div class="hero-inner">

            {{-- Text --}}
            <div class="hero-text">
                <div class="hero-label">Welcome to OTRS</div>

                <h1 class="hero-heading">
                    Discover the<br>
                    World, <em>Your<br>Way</em>
                </h1>

                <p class="hero-desc">
                    Plan, book, and embark on extraordinary journeys — all in
                    one seamless platform. From pristine beaches to mountain
                    trails, we make travel effortless.
                </p>

                <div class="hero-actions">
                    <a href="{{ route('register') }}" class="btn-book">
                        <svg viewBox="0 0 24 24"><path d="M8 6h13M8 12h13M8 18h13M3 6h.01M3 12h.01M3 18h.01"/></svg>
                        Book Now
                    </a>
                    <a href="/" class="btn-learn">Learn More →</a>
                </div>
            </div>

            {{-- Image grid --}}
            <div class="hero-images">
                {{-- Big top image: mountains --}}
                <img class="img-main"
                     src="https://images.unsplash.com/photo-1464822759023-fed622ff2c3b?w=700&q=80"
                     alt="Mountain landscape">

                {{-- Two small bottom images --}}
                <div class="img-row">
                    <img class="img-small"
                         src="https://images.unsplash.com/photo-1507525428034-b723cf961d3e?w=400&q=80"
                         alt="Tropical beach">
                    <img class="img-small"
                         src="https://images.unsplash.com/photo-1537953773345-d172ccf13cf1?w=400&q=80"
                         alt="Rice terraces">


                </div>
            </div>

        </div>
    </div>

    {{-- ═══════ RIGHT: Login card ═══════ --}}
    <div class="login-col">

        <div class="card-brand">
            <div class="card-brand-icon">
                <svg viewBox="0 0 24 24"><path d="M4 6h16M4 10h16M8 14h8M10 18h4"/></svg>
            </div>
            <div>
                <div class="card-brand-name">OTR<span>S</span></div>
                <div class="card-brand-sub">Online Tour Reservation</div>
            </div>
        </div>

        <div class="login-title">Welcome back</div>
        <div class="login-sub">Sign in to your account to continue</div>

        @if ($errors->any())
            <div class="alert-error">
                <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="field-group">
                <label class="field-label">Email Address</label>
                <input class="field-input" type="email" name="email"
                       value="{{ old('email') }}" required autofocus
                       placeholder="you@example.com">
            </div>

            <div class="field-group">
                <label class="field-label">Password</label>
                <input class="field-input" type="password" name="password" required
                       placeholder="••••••••">
            </div>

            <div class="forgot">
                <a href="{{ route('password.request') }}">Forgot password?</a>
            </div>

            <button type="submit" class="login-btn">Sign in</button>
        </form>

        <div class="divider">
            <div class="divider-line"></div>
            <div class="divider-text">or</div>
            <div class="divider-line"></div>
        </div>

        <a href="{{ route('register') }}" class="register-btn">Create new account</a>

        <div class="card-footer">
            By signing in you agree to our Terms of Service &amp; Privacy Policy.
        </div>
    </div>

</div>

</body>
</html>