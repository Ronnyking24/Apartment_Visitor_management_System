<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Apartment Visitor Management System') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
    <style>
        :root{
            --bg:#f4f6f8; --card:#ffffff; --muted:#6a7788; --accent:#1f3556; --accent-soft:#eef3fa;
        }
        *{box-sizing:border-box}
        body{margin:0;min-height:100vh;display:flex;align-items:center;justify-content:center;background:var(--bg);font-family:Georgia, 'Times New Roman', serif;color:#1b2430;position:relative}
        
        .bg-slides{position:fixed;top:0;left:0;width:100%;height:100%;z-index:-1}
        .slide{position:absolute;inset:0;background-size:cover;background-position:center;opacity:0;transition:opacity 1.2s ease;transform:scale(1.04)}
        .slide.active{opacity:1;animation:kenBurns 8s ease-in-out forwards}
        @keyframes kenBurns{from{transform:scale(1.04) translate(0,0)}to{transform:scale(1.10) translate(-1.5%,0.5%)}}
        .slide:nth-child(even).active{animation:kenBurns2 8s ease-in-out forwards}
        @keyframes kenBurns2{from{transform:scale(1.04) translate(0,0)}to{transform:scale(1.10) translate(1.5%,-0.5%)}}
        .slide-overlay{position:absolute;inset:0;z-index:1;background:linear-gradient(to right,rgba(12,7,45,.94) 0%,rgba(22,13,78,.82) 20%,rgba(36,22,108,.62) 42%,rgba(52,36,145,.38) 65%,rgba(66,50,165,.18) 85%,rgba(76,60,178,.06) 100%),linear-gradient(to bottom,rgba(14,9,52,.18) 0%,rgba(6,3,22,.62) 100%)}
        
        .container{width:min(900px,calc(100vw-32px));position:relative;z-index:2;margin:0 auto}
        .panel{background:var(--card);border-radius:14px;border:1px solid #e3e8ef;box-shadow:0 8px 30px rgba(27,36,49,.06);overflow:hidden}
        .header{padding:12px 28px;display:flex;align-items:center;justify-content:center}
        .brand{font-size:20px;font-weight:700;color:#ffffff;letter-spacing:.02em}
        .header .actions{display:flex;gap:10px}
        .btn{font-family:Arial,Helvetica,sans-serif;padding:9px 14px;border-radius:10px;border:1px solid rgba(255,255,255,.16);background:rgba(255,255,255,.12);color:rgba(255,255,255,.95);font-weight:700;text-decoration:none}
        .btn-primary{background:rgba(255,255,255,.16);color:#fff;border-color:rgba(255,255,255,.18)}
        .hero{padding:44px 28px;text-align:center;display:flex;align-items:center;justify-content:center;min-height:360px}
        .hero-inner{max-width:720px;margin:0 auto}
        .kicker{font-family:Arial,Helvetica,sans-serif;font-size:12px;color:rgba(255,255,255,.75);text-transform:uppercase;letter-spacing:.16em;margin-bottom:10px;text-align:center}
        .title{font-size:40px;margin:0 0 12px;font-weight:700;color:#ffffff;font-family:Georgia, 'Times New Roman', serif;text-align:center}
        .subtitle{margin:0;font-size:16px;color:rgba(255,255,255,.85);line-height:1.8;text-align:center}
        .hero-actions{margin-top:22px;display:flex;gap:10px;justify-content:center}
        .footer{padding:18px 28px;border-top:1px solid rgba(255,255,255,.06);font-size:13px;color:rgba(255,255,255,.85);display:flex;flex-direction:column;justify-content:center;align-items:center;gap:6px}
        @media(max-width:760px){.hero{padding:30px 18px}.title{font-size:30px}.features{flex-direction:column}.hero-inner{padding:0 10px}}
    </style>
</head>
<body>
    <div class="bg-slides">
        <div class="slide active" style="background-image:url('https://images.unsplash.com/photo-1605276374104-dee2a0ed3cd6?ixlib=rb-4.0.3&auto=format&fit=crop&w=1600&q=85')"></div>
        <div class="slide" style="background-image:url('https://images.unsplash.com/photo-1545324418-cc1a3fa10c00?ixlib=rb-4.0.3&auto=format&fit=crop&w=1600&q=85')"></div>
        <div class="slide" style="background-image:url('https://images.unsplash.com/photo-1582407947304-fd86f028f716?ixlib=rb-4.0.3&auto=format&fit=crop&w=1600&q=85')"></div>
        <div class="slide" style="background-image:url('https://images.unsplash.com/photo-1560185008-b033106af5c3?ixlib=rb-4.0.3&auto=format&fit=crop&w=1600&q=85')"></div>
        <div class="slide-overlay"></div>
    </div>
    
    <div class="wrap">
        <div class="shell">

            <div class="hero">
                <div class="hero-inner">
                    <div class="kicker">Apartment Visitor Management</div>
                    <h2 class="title">Streamlined visitor management for modern apartment communities</h2>
                    <p class="subtitle">AVMS keeps visitor logs, resident approvals, and guard records organized in one reliable system.</p>

                    @if (Route::has('login'))
                        <div class="hero-actions">
                            @auth
                                <a class="btn btn-primary" href="{{ url('/dashboard') }}">Dashboard</a>
                            @else
                                <a class="btn btn-primary" href="{{ route('login') }}">Log in</a>
                                @if (Route::has('register'))
                                    <a class="btn" href="{{ route('register') }}">Register</a>
                                @endif
                            @endauth
                        </div>
                    @endif

                </div>
            </div>

            <div class="footer">
                <span>Visitor Management. Perfected.</span>
            </div>
        </div>
    </div>

    <script>
        const slides = document.querySelectorAll('.slide');
        let currentSlide = 0;
        
        function showSlide(index) {
            slides.forEach(slide => slide.classList.remove('active'));
            slides[index].classList.add('active');
        }
        
        function nextSlide() {
            currentSlide = (currentSlide + 1) % slides.length;
            showSlide(currentSlide);
        }
        
        setInterval(nextSlide, 9000);
    </script>
</body>
</html>
