<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Hotel Maintenance System') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            * {
                font-family: 'Poppins', 'Figtree', sans-serif;
            }

            body {
                margin: 0;
                min-height: 100vh;
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            }

            .guest-theme {
                min-height: 100vh;
                display: flex;
                align-items: center;
                justify-content: center;
                padding: 32px 16px;
                position: relative;
                overflow: hidden;
            }

            .guest-theme::before,
            .guest-theme::after {
                content: "";
                position: absolute;
                width: 320px;
                height: 320px;
                border-radius: 50%;
                background: rgba(255, 255, 255, 0.12);
                filter: blur(2px);
            }

            .guest-theme::before {
                top: -90px;
                left: -90px;
            }

            .guest-theme::after {
                right: -110px;
                bottom: -110px;
            }

            .guest-shell {
                position: relative;
                z-index: 1;
                width: min(760px, 100%);
            }

            .guest-logo {
                text-align: center;
                margin-bottom: 22px;
                color: #ffffff;
            }

            .guest-logo-icon {
                width: 76px;
                height: 76px;
                border-radius: 22px;
                margin: 0 auto 12px;
                display: flex;
                align-items: center;
                justify-content: center;
                background: rgba(255, 255, 255, 0.18);
                box-shadow: 0 15px 45px rgba(0, 0, 0, 0.18);
                backdrop-filter: blur(10px);
                font-size: 34px;
            }

            .guest-logo h2 {
                margin: 0;
                font-size: 30px;
                font-weight: 700;
                letter-spacing: 0.02em;
                text-shadow: 0 2px 12px rgba(0, 0, 0, 0.2);
            }

            .guest-logo p {
                margin: 6px 0 0;
                color: rgba(255, 255, 255, 0.82);
                font-size: 14px;
            }

            .guest-card {
                background: rgba(255, 255, 255, 0.96);
                border-radius: 22px;
                padding: 30px;
                box-shadow: 0 20px 60px rgba(0, 0, 0, 0.22);
                border: 1px solid rgba(255, 255, 255, 0.45);
                backdrop-filter: blur(10px);
            }

            .guest-card input,
            .guest-card select,
            .guest-card textarea {
                border-radius: 12px !important;
                border: 1px solid #d9def5 !important;
                background: #ffffff !important;
                min-height: 46px;
            }

            .guest-card input:focus,
            .guest-card select:focus,
            .guest-card textarea:focus {
                border-color: #667eea !important;
                box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.15) !important;
            }

            .guest-card button[type="submit"],
            .guest-card .primary-action {
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
                border: none !important;
                border-radius: 12px !important;
                color: #ffffff !important;
                font-weight: 700 !important;
                letter-spacing: 0.06em;
                padding: 11px 20px !important;
                box-shadow: 0 8px 24px rgba(102, 126, 234, 0.35);
            }

            .guest-card button[type="submit"]:hover,
            .guest-card .primary-action:hover {
                transform: translateY(-1px);
                box-shadow: 0 12px 30px rgba(102, 126, 234, 0.45);
            }

            .guest-page-title {
                text-align: center;
                margin-bottom: 24px;
            }

            .guest-page-title .badge-icon {
                width: 58px;
                height: 58px;
                margin: 0 auto 12px;
                border-radius: 18px;
                display: flex;
                align-items: center;
                justify-content: center;
                color: #ffffff;
                background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
                font-size: 26px;
                box-shadow: 0 10px 25px rgba(245, 87, 108, 0.28);
            }

            .guest-page-title h1 {
                margin: 0;
                color: #26334d;
                font-size: 26px;
                font-weight: 700;
            }

            .guest-page-title p {
                margin: 8px auto 0;
                color: #718096;
                max-width: 560px;
                font-size: 14px;
                line-height: 1.6;
            }

            .guest-success {
                margin-bottom: 18px;
                padding: 14px 16px;
                border-radius: 14px;
                background: rgba(46, 204, 113, 0.12);
                color: #16864c;
                font-size: 14px;
                font-weight: 600;
            }

            .guest-secondary-link {
                color: #667eea;
                font-weight: 600;
                text-decoration: none;
            }

            .guest-secondary-link:hover {
                color: #764ba2;
                text-decoration: underline;
            }
        </style>
    </head>
    <body>
        <div class="guest-theme">
            <div class="guest-shell">
                <a href="/">
                    <div class="guest-logo">
                        <div class="guest-logo-icon">🏨</div>
                        <h2>HMMS</h2>
                        <p>Hotel Maintenance Management System</p>
                    </div>
                </a>

                <div class="guest-card">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </body>
</html>
