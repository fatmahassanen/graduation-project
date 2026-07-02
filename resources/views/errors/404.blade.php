<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>404 – Page Not Found | NCTU</title>
    <link rel="icon" type="image/png" href="{{ asset('img/sub-sub-logo.png') }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Nunito', sans-serif;
            background: #edf0f7;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            position: relative;
        }
        /* Background decorations */
        body::before {
            content: '';
            position: fixed;
            top: -120px; left: -120px;
            width: 400px; height: 400px;
            background: rgba(100,140,210,0.35);
            border-radius: 50%;
        }
        body::after {
            content: '';
            position: fixed;
            bottom: -100px; right: -100px;
            width: 320px; height: 320px;
            background: rgba(100,140,210,0.30);
            border-radius: 50%;
        }
        .bg-ring {
            position: fixed;
            top: 50%; left: -70px;
            transform: translateY(-50%);
            width: 200px; height: 200px;
            border-radius: 50%;
            border: 38px solid rgba(100,140,210,0.40);
            pointer-events: none;
        }
        .bg-dots-tr {
            position: fixed; top: 30px; right: 30px;
            width: 130px; height: 110px;
            background-image: radial-gradient(circle, rgba(100,140,210,0.5) 1.5px, transparent 1.5px);
            background-size: 14px 14px;
            pointer-events: none;
        }
        .bg-dots-bl {
            position: fixed; bottom: 30px; left: 30px;
            width: 130px; height: 110px;
            background-image: radial-gradient(circle, rgba(100,140,210,0.5) 1.5px, transparent 1.5px);
            background-size: 14px 14px;
            pointer-events: none;
        }

        /* Card */
        .error-card {
            background: #fff;
            border-radius: 24px;
            box-shadow: 0 20px 60px rgba(26,58,110,0.15);
            padding: 60px 50px;
            max-width: 560px;
            width: 90%;
            text-align: center;
            position: relative;
            z-index: 1;
            animation: fadeUp 0.6s ease both;
        }
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(30px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* 404 number */
        .error-number {
            font-size: clamp(5rem, 18vw, 8rem);
            font-weight: 800;
            line-height: 1;
            background: linear-gradient(135deg, #1a3a6e 0%, #2356c7 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 8px;
            letter-spacing: -4px;
        }
        .error-divider {
            width: 60px; height: 4px;
            background: #D08301;
            border-radius: 2px;
            margin: 0 auto 20px;
        }
        .error-title {
            font-size: 1.5rem;
            font-weight: 800;
            color: #181d38;
            margin-bottom: 12px;
        }
        .error-msg {
            font-size: 0.97rem;
            color: #6b7280;
            line-height: 1.7;
            margin-bottom: 36px;
        }

        /* Icon */
        .error-icon {
            width: 80px; height: 80px;
            background: linear-gradient(135deg, #1a3a6e, #2356c7);
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 28px;
            box-shadow: 0 8px 24px rgba(26,58,110,0.3);
        }
        .error-icon i { color: #fff; font-size: 2rem; }

        /* Buttons */
        .btn-home {
            display: inline-flex; align-items: center; gap: 8px;
            background: linear-gradient(135deg, #1a3a6e, #2356c7);
            color: #fff; text-decoration: none;
            padding: 14px 32px; border-radius: 10px;
            font-weight: 700; font-size: 0.95rem;
            transition: transform 0.2s, box-shadow 0.2s;
            box-shadow: 0 4px 16px rgba(26,58,110,0.25);
            margin-right: 12px;
        }
        .btn-home:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(26,58,110,0.35);
            color: #fff;
        }
        .btn-back {
            display: inline-flex; align-items: center; gap: 8px;
            background: transparent;
            color: #1a3a6e; text-decoration: none;
            padding: 14px 32px; border-radius: 10px;
            font-weight: 700; font-size: 0.95rem;
            border: 2px solid #1a3a6e;
            transition: background 0.2s, color 0.2s;
        }
        .btn-back:hover {
            background: #1a3a6e;
            color: #fff;
        }
        .btn-group {
            display: flex; justify-content: center;
            flex-wrap: wrap; gap: 12px;
        }

        /* NCTU logo text */
        .nctu-brand {
            position: fixed; top: 24px; left: 30px;
            display: flex; align-items: center; gap: 12px;
            text-decoration: none; z-index: 10;
        }
        .nctu-brand-logo {
            width: 42px; height: 42px; border-radius: 10px;
            background: linear-gradient(135deg, #1a3a6e, #2356c7);
            display: flex; align-items: center; justify-content: center;
        }
        .nctu-brand-logo i { color: #D08301; font-size: 1.3rem; }
        .nctu-brand-name { font-weight: 800; font-size: 1rem; color: #181d38; line-height: 1.2; }
        .nctu-brand-sub  { font-size: 0.72rem; color: #6b7280; }
    </style>
</head>
<body>
    <div class="bg-ring"></div>
    <div class="bg-dots-tr"></div>
    <div class="bg-dots-bl"></div>

    <a href="{{ url('/') }}" class="nctu-brand">
        <div class="nctu-brand-logo"><i class="fas fa-graduation-cap"></i></div>
        <div>
            <div class="nctu-brand-name">NCTU</div>
            <div class="nctu-brand-sub">New Cairo Technological University</div>
        </div>
    </a>

    <div class="error-card">
        <div class="error-icon">
            <i class="fas fa-map-signs"></i>
        </div>
        <div class="error-number">404</div>
        <div class="error-divider"></div>
        <h1 class="error-title">Page Not Found</h1>
        <p class="error-msg">
            Oops! The page you're looking for doesn't exist or has been moved.<br>
            Let's get you back on track.
        </p>
        <div class="btn-group">
            <a href="{{ url('/') }}" class="btn-home">
                <i class="fas fa-home"></i> Go to Homepage
            </a>
            <a href="javascript:history.back()" class="btn-back">
                <i class="fas fa-arrow-left"></i> Go Back
            </a>
        </div>
    </div>
</body>
</html>
