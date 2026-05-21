<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'NCTU') }} - Register</title>
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

        .register-container {
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
        }

        .input-group {
            margin-bottom: 25px;
            position: relative;
        }

        .input-wrapper {
            position: relative;
            display: flex;
            align-items: center;
        }

        .input-icon {
            position: absolute;
            left: 0;
            color: #9ca3af;
            font-size: 18px;
            z-index: 1;
        }

        .form-input {
            width: 100%;
            padding: 12px 0 12px 35px;
            border: none;
            border-bottom: 2px solid #e5e7eb;
            font-size: 15px;
            color: #1f2937;
            background: transparent;
            transition: all 0.3s ease;
            outline: none;
        }

        .form-input:focus {
            border-bottom-color: #1e3c72;
        }

        .form-input::placeholder {
            color: #9ca3af;
        }

        .input-error {
            color: #ef4444;
            font-size: 12px;
            margin-top: 6px;
            display: block;
        }

        .submit-btn {
            width: 100%;
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
            margin-top: 10px;
        }

        .submit-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(30, 60, 114, 0.4);
        }

        .submit-btn:active {
            transform: translateY(0);
        }

        .form-links {
            margin-top: 25px;
            text-align: center;
        }

        .form-link {
            color: #1e3c72;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            transition: color 0.3s ease;
        }

        .form-link:hover {
            color: #2a5298;
            text-decoration: underline;
        }

        .divider {
            margin: 20px 0;
            text-align: center;
            color: #9ca3af;
            font-size: 13px;
        }

        @media (max-width: 768px) {
            .register-container {
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
        }
    </style>
</head>
<body>
    <div class="register-container">
        <div class="brand-section">
            <div class="brand-content">
                <div class="brand-logo">
                    <i class="fas fa-graduation-cap"></i>
                </div>
                <h1 class="brand-title">Join Us</h1>
                <h2 class="brand-subtitle">New Cairo Technological University</h2>
            </div>
        </div>

        <div class="form-section">
            <div class="form-header">
                <h2 class="form-title">Create Account</h2>
                <p class="form-subtitle">Fill in your details to get started</p>
            </div>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="input-group">
                    <div class="input-wrapper">
                        <i class="fas fa-user input-icon"></i>
                        <input 
                            type="text" 
                            name="name" 
                            id="name"
                            class="form-input" 
                            placeholder="Enter username"
                            value="{{ old('name') }}"
                            required 
                            autofocus 
                            autocomplete="name"
                        >
                    </div>
                    @error('name')
                        <span class="input-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="input-group">
                    <div class="input-wrapper">
                        <i class="fas fa-envelope input-icon"></i>
                        <input 
                            type="email" 
                            name="email" 
                            id="email"
                            class="form-input" 
                            placeholder="Enter your email"
                            value="{{ old('email') }}"
                            required 
                            autocomplete="email"
                        >
                    </div>
                    @error('email')
                        <span class="input-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="input-group">
                    <div class="input-wrapper">
                        <i class="fas fa-lock input-icon"></i>
                        <input 
                            type="password" 
                            name="password" 
                            id="password"
                            class="form-input" 
                            placeholder="Create a password"
                            required 
                            autocomplete="new-password"
                        >
                    </div>
                    @error('password')
                        <span class="input-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="input-group">
                    <div class="input-wrapper">
                        <i class="fas fa-lock input-icon"></i>
                        <input 
                            type="password" 
                            name="password_confirmation" 
                            id="password_confirmation"
                            class="form-input" 
                            placeholder="Confirm your password"
                            required 
                            autocomplete="new-password"
                        >
                    </div>
                    @error('password_confirmation')
                        <span class="input-error">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit" class="submit-btn">
                    Create Account
                </button>

                <div class="divider">Already have an account?</div>
                <div class="form-links">
                    <a href="{{ route('login') }}" class="form-link">
                        Sign in here
                    </a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
