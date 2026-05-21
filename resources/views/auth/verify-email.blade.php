<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'NCTU') }} - Verify Email</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .verify-container {
            display: flex;
            width: 100%;
            max-width: 1000px;
            min-height: 600px;
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        }

        .brand-section {
            flex: 1;
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 50%, #7e8ba3 100%);
            padding: 60px 50px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            color: white;
            position: relative;
            overflow: hidden;
        }

        .brand-section::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -20%;
            width: 400px;
            height: 400px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
        }

        .brand-section::after {
            content: '';
            position: absolute;
            bottom: -30%;
            left: -10%;
            width: 300px;
            height: 300px;
            background: rgba(255, 255, 255, 0.08);
            border-radius: 50%;
        }

        .brand-content {
            position: relative;
            z-index: 1;
            text-align: center;
        }

        .brand-logo {
            width: 120px;
            height: 120px;
            background: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 30px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        }

        .brand-logo i {
            font-size: 60px;
            color: #1e3c72;
        }

        .brand-title {
            font-size: 32px;
            font-weight: 700;
            margin-bottom: 10px;
            letter-spacing: 1px;
        }

        .brand-subtitle {
            font-size: 18px;
            font-weight: 300;
            opacity: 0.9;
            margin-bottom: 30px;
        }

        .brand-description {
            font-size: 14px;
            line-height: 1.8;
            opacity: 0.85;
            max-width: 350px;
        }

        .form-section {
            flex: 1;
            padding: 60px 50px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .form-header {
            margin-bottom: 40px;
        }

        .form-title {
            font-size: 32px;
            font-weight: 700;
            color: #1e3c72;
            margin-bottom: 10px;
        }

        .form-subtitle {
            font-size: 14px;
            color: #6b7280;
            line-height: 1.6;
        }

        .success-status {
            background: #d1fae5;
            color: #065f46;
            padding: 12px 16px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 14px;
        }

        .button-group {
            display: flex;
            gap: 12px;
            margin-top: 30px;
        }

        .submit-btn {
            flex: 1;
            padding: 14px;
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(30, 60, 114, 0.3);
        }

        .submit-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(30, 60, 114, 0.4);
        }

        .submit-btn:active {
            transform: translateY(0);
        }

        .logout-btn {
            flex: 1;
            padding: 14px;
            background: white;
            color: #1e3c72;
            border: 2px solid #1e3c72;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .logout-btn:hover {
            background: #f3f4f6;
            transform: translateY(-2px);
        }

        .logout-btn:active {
            transform: translateY(0);
        }

        @media (max-width: 768px) {
            .verify-container {
                flex-direction: column;
                max-width: 450px;
            }

            .brand-section {
                padding: 40px 30px;
                min-height: 300px;
            }

            .brand-logo {
                width: 80px;
                height: 80px;
            }

            .brand-logo i {
                font-size: 40px;
            }

            .brand-title {
                font-size: 24px;
            }

            .brand-subtitle {
                font-size: 16px;
            }

            .form-section {
                padding: 40px 30px;
            }

            .form-title {
                font-size: 26px;
            }

            .button-group {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <div class="verify-container">
        <div class="brand-section">
            <div class="brand-content">
                <div class="brand-logo">
                    <i class="fas fa-envelope-open"></i>
                </div>
                <h1 class="brand-title">Almost There!</h1>
                <h2 class="brand-subtitle">NCTU</h2>
                <p class="brand-description">
                    We've sent you a verification email. Click the link in the email to verify your account and get started.
                </p>
            </div>
        </div>

        <div class="form-section">
            <div class="form-header">
                <h2 class="form-title">Verify Email</h2>
                <p class="form-subtitle">
                    Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn't receive the email, we will gladly send you another.
                </p>
            </div>

            @if (session('status') == 'verification-link-sent')
                <div class="success-status">
                    A new verification link has been sent to the email address you provided during registration.
                </div>
            @endif

            <div class="button-group">
                <form method="POST" action="{{ route('verification.send') }}" style="flex: 1;">
                    @csrf
                    <button type="submit" class="submit-btn">
                        Resend Verification Email
                    </button>
                </form>

                <form method="POST" action="{{ route('logout') }}" style="flex: 1;">
                    @csrf
                    <button type="submit" class="logout-btn">
                        Log Out
                    </button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
