<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="color-scheme" content="light">
    <meta name="supported-color-schemes" content="light">
    <title> @yield('subject') </title>
    <style>
        /* Reset */
        body, table, td, p, a {
            margin: 0;
            padding: 0;
            border: 0;
            font-size: 100%;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            line-height: 1.5;
        }

        body {
            background-color: #f6f9fc;
            padding: 40px 20px;
            -webkit-font-smoothing: antialiased;
        }

        /* Container */
        .email-wrapper {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.05);
        }

        /* Header */
        .email-header {
            background: linear-gradient(135deg, #2563eb, #1e40af);
            padding: 40px 30px;
            text-align: center;
        }

        .email-header h1 {
            color: white;
            font-size: 28px;
            font-weight: 700;
            margin: 0;
            letter-spacing: -0.5px;
        }

        .email-header p {
            color: rgba(255, 255, 255, 0.9);
            font-size: 16px;
            margin-top: 8px;
        }

        /* Body */
        .email-body {
            padding: 40px 30px;
            background-color: #ffffff;
        }

        /* Footer */
        .email-footer {
            padding: 30px;
            background-color: #f8fafc;
            border-top: 1px solid #e2e8f0;
            text-align: center;
            color: #64748b;
            font-size: 14px;
        }

        /* Typography */
        h2 {
            color: #0f172a;
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 16px;
        }

        p {
            color: #334155;
            font-size: 16px;
            margin-bottom: 24px;
        }

        /* Code Block */
        .code-block {
            background: linear-gradient(135deg, #f1f5f9, #e2e8f0);
            border-radius: 16px;
            padding: 32px 24px;
            margin: 32px 0;
            text-align: center;
            border: 1px solid #cbd5e1;
        }

        .code-label {
            font-size: 14px;
            font-weight: 600;
            color: #475569;
            text-transform: uppercase;
            letter-spacing: 3px;
            margin-bottom: 12px;
        }

        .code {
            font-size: 52px;
            font-weight: 700;
            color: #0f172a;
            letter-spacing: 12px;
            font-family: 'Courier New', Courier, monospace;
            line-height: 1.2;
            word-break: break-all;
        }

        .code-expiry {
            font-size: 14px;
            color: #64748b;
            margin-top: 16px;
            font-style: italic;
        }

        /* Button */
        .button {
            display: inline-block;
            background: linear-gradient(135deg, #2563eb, #1d4ed8);
            color: white !important;
            font-weight: 600;
            font-size: 16px;
            padding: 14px 32px;
            border-radius: 40px;
            text-decoration: none;
            margin: 16px 0 8px;
            box-shadow: 0 4px 6px rgba(37, 99, 235, 0.2);
            transition: all 0.2s;
        }

        .button:hover {
            background: linear-gradient(135deg, #1d4ed8, #1e40af);
            box-shadow: 0 6px 10px rgba(37, 99, 235, 0.3);
        }

        /* Divider */
        .divider {
            height: 1px;
            background: linear-gradient(to right, transparent, #e2e8f0, transparent);
            margin: 32px 0;
        }

        /* Links */
        a {
            color: #2563eb;
            text-decoration: none;
            font-weight: 500;
        }

        a:hover {
            text-decoration: underline;
        }

        /* Responsive */
        @media only screen and (max-width: 600px) {
            .email-wrapper {
                border-radius: 0;
            }
            .email-header {
                padding: 30px 20px;
            }
            .email-body {
                padding: 30px 20px;
            }
            .code {
                font-size: 40px;
                letter-spacing: 8px;
            }
        }
    </style>
</head>
<body>
<div class="email-wrapper">
    {{-- Header --}}
    <div class="email-header">
        <h1>{{ config('app.name') }}</h1>
        <p> @yield('header') </p>
    </div>

    {{-- Main Content --}}
    <div class="email-body">
        @yield('content')
    </div>

    {{-- Footer --}}
    <div class="email-footer">
        <p style="margin-bottom: 8px;">© {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
        <p style="margin-bottom: 0; font-size: 13px;">
            {{ config('app.address') ?? 'This is an automated message, please do not reply.' }}
        </p>
    </div>
</div>
</body>
</html>
