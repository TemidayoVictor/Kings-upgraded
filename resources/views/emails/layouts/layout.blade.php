<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? config('app.name') }}</title>
</head>
<body style="margin: 0; padding: 0; background-color: #f9f9f9; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; -webkit-font-smoothing: antialiased;">

<table width="100%" border="0" cellspacing="0" cellpadding="0" style="background-color: #f9f9f9; padding: 40px 20px;">
    <tr>
        <td align="center">

            <table width="100%" style="max-width: 570px; margin-bottom: 24px;">
                <tr>
                    <td align="center">
                        <a href="{{ url('/') }}" style="text-decoration: none;">
{{--                            <img src="{{ $message->embed(public_path('images/Logo-Crown.svg')) }}" alt="Logo" width="48" height="48" style="display: block;">--}}
                            <img src="{{ asset('images/Logo-Crown.svg') }}" alt="Logo" width="48" height="48" style="display: block;">
                        </a>
                    </td>
                </tr>
            </table>

            <table width="100%" style="max-width: 570px; background-color: #ffffff; border: 1px solid #e8e8e8; border-radius: 16px; overflow: hidden;">
                <tr>
                    <td style="padding: 40px;">
                        {{ $slot }}
                    </td>
                </tr>
            </table>

            <table width="100%" style="max-width: 570px; margin-top: 24px;">
                <tr>
                    <td align="center" style="padding: 0 20px;">
                        <p style="font-size: 11px; color: #a3a3a3; text-transform: uppercase; letter-spacing: 0.5px;">
                            &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
                        </p>
                        <p style="font-size: 11px; color: #a3a3a3;">
                            <a href="#" style="color: #a3a3a3;">Unsubscribe</a> | <a href="#" style="color: #a3a3a3;">Privacy Policy</a>
                        </p>
                    </td>
                </tr>
            </table>

        </td>
    </tr>
</table>
</body>
</html>
