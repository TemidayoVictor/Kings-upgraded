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

            <!-- Header Section -->
            <table width="100%" style="max-width: 570px; margin-bottom: 24px;">
                <tr>
                    <td align="center">
                        <table border="0" cellspacing="0" cellpadding="0">
                            <tr>
                                <td align="center" style="padding-bottom: 12px;">
                                    <a href="{{ url('/') }}" style="text-decoration: none;">
                                        <img src="{{ asset('images/Logo-Crown.png') }}" alt="Logo" width="48" height="48" style="display: block;">
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td align="center">
                                    <div style="background: linear-gradient(145deg, #f8f8fa, #eaeef5); border-radius: .8rem; padding: 8px 22px; font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif; font-size: 1.8rem; font-weight: 900; text-transform: uppercase; letter-spacing: 1px; box-shadow: 0 4px 12px rgba(0,0,0,0.02), inset 0 1px 0 rgba(255,255,255,0.8); border: 1px solid #e8e8e8; display: inline-block;">
                                        <span style="background: #e9a35d; -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; font-weight: 700;">
                                            KING’S
                                        </span>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>

            <!-- Main Content Card -->
            <table width="100%" style="max-width: 570px; background-color: #ffffff; border: 1px solid #e8e8e8; border-radius: 16px; overflow: hidden;">
                <tr>
                    <td style="padding: 40px;">
                        {{ $slot }}
                    </td>
                </tr>
            </table>

            <!-- Footer Section -->
            <table width="100%" style="max-width: 570px; margin-top: 24px;">
                <tr>
                    <td align="center" style="padding: 0 20px;">

                        <!-- Social Media Icons Row -->
                        <table border="0" cellspacing="0" cellpadding="0" style="margin-bottom: 16px;">
                            <tr>
                                <td style="padding: 0 8px;">
                                    <a href="https://twitter.com/yourhandle" target="_blank" style="text-decoration: none;">
                                        <img src="https://img.icons8.com/ios-filled/50/a3a3a3/twitter.png" alt="Twitter" width="18" height="18" style="display: block;">
                                    </a>
                                </td>
                                <td style="padding: 0 8px;">
                                    <a href="https://instagram.com/yourhandle" target="_blank" style="text-decoration: none;">
                                        <img src="https://img.icons8.com/ios-filled/50/a3a3a3/instagram-new.png" alt="Instagram" width="18" height="18" style="display: block;">
                                    </a>
                                </td>
                                <td style="padding: 0 8px;">
                                    <a href="https://facebook.com/yourhandle" target="_blank" style="text-decoration: none;">
                                        <img src="https://img.icons8.com/ios-filled/50/a3a3a3/facebook-new.png" alt="Facebook" width="18" height="18" style="display: block;">
                                    </a>
                                </td>
                                <td style="padding: 0 8px;">
                                    <a href="https://linkedin.com/company/yourhandle" target="_blank" style="text-decoration: none;">
                                        <img src="https://img.icons8.com/ios-filled/50/a3a3a3/linkedin.png" alt="LinkedIn" width="18" height="18" style="display: block;">
                                    </a>
                                </td>
                            </tr>
                        </table>

                        <!-- Copyright & Links -->
                        <p style="font-size: 11px; color: #a3a3a3; text-transform: uppercase; letter-spacing: 0.5px; margin: 0 0 8px 0;">
                            &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
                        </p>
                        <p style="font-size: 11px; color: #a3a3a3; margin: 0;">
                            <a href="#" style="color: #a3a3a3; text-decoration: underline;">Unsubscribe</a> | <a href="#" style="color: #a3a3a3; text-decoration: underline;">Privacy Policy</a>
                        </p>
                    </td>
                </tr>
            </table>

        </td>
    </tr>
</table>
</body>
</html>
