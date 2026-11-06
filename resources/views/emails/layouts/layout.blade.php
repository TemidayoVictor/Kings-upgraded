<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="x-apple-disable-message-reformatting">
    <meta name="format-detection" content="telephone=no,address=no,email=no,date=no,url=no">
    <title>{{ $title ?? config('app.name') }}</title>
    <!--[if mso]>
    <noscript><xml><o:OfficeDocumentSettings><o:PixelsPerInch>96</o:PixelsPerInch></o:OfficeDocumentSettings></xml></noscript>
    <![endif]-->
    <style>
        html, body { margin:0 !important; padding:0 !important; height:100% !important; width:100% !important; }
        * { -ms-text-size-adjust:100%; -webkit-text-size-adjust:100%; }
        table, td { mso-table-lspace:0pt !important; mso-table-rspace:0pt !important; }
        table { border-spacing:0 !important; border-collapse:collapse !important; }
        img { -ms-interpolation-mode:bicubic; border:0; height:auto; line-height:100%; outline:none; text-decoration:none; }
        a { text-decoration:none; }

        @media screen and (max-width: 600px) {
            .email-container { width:100% !important; border-radius:0 !important; border-left:0 !important; border-right:0 !important; }
            .pad-x { padding-left:20px !important; padding-right:20px !important; }
            .brand-bar { padding-top:24px !important; padding-bottom:8px !important; }
            .body-cell { padding-top:8px !important; padding-bottom:24px !important; }
            .footer-cell { padding-top:20px !important; padding-bottom:20px !important; }
        }
    </style>
</head>
<body style="margin:0; padding:0; background-color:#f9f9f9; font-family:'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; -webkit-font-smoothing:antialiased;">

<table role="presentation" width="100%" border="0" cellspacing="0" cellpadding="0" style="background-color:#f9f9f9;">
    <tr>
        <td align="center" style="padding:40px 20px;">

            <table role="presentation" class="email-container" width="600" border="0" cellspacing="0" cellpadding="0" style="width:100%; max-width:600px; background-color:#ffffff; border:1px solid #e8e8e8; border-radius:12px; overflow:hidden;">

                <!-- Brand Bar -->
                <tr>
                    <td class="brand-bar pad-x" style="padding:32px 36px 8px 36px;">
                        <table role="presentation" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                                <td style="padding-right:8px; vertical-align:middle;">
                                    <a href="{{ url('/') }}" style="text-decoration:none;">
                                        <img src="{{ asset('images/Logo-Crown.png') }}" alt="KING'S" width="29" height="24" style="display:block; height:24px; width:auto; border:0;">
                                    </a>
                                </td>
                                <td style="vertical-align:middle;">
                                    <span style="font-family:'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; font-size:18px; line-height:24px; font-weight:600; letter-spacing:-0.005em; text-transform:uppercase; color:#1a1c1c;">KING'S</span>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>

                <!-- Content -->
                <tr>
                    <td class="body-cell pad-x" style="padding:8px 36px 32px 36px; font-family:'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; color:#1a1c1c;">
                        {{ $slot }}
                    </td>
                </tr>

                <!-- Footer -->
                <tr>
                    <td class="footer-cell pad-x" style="background-color:#f3f3f3; padding:24px 36px; text-align:center;">

                        <!-- Social Icons -->
                        <table role="presentation" border="0" cellspacing="0" cellpadding="0" align="center" style="margin:0 auto 16px auto;">
                            <tr>
                                <td style="padding:0 8px;">
                                    <a href="https://twitter.com/yourhandle" target="_blank" style="text-decoration:none;">
                                        <img src="https://img.icons8.com/ios-filled/50/a3a3a3/twitter.png" alt="Twitter" width="18" height="18" style="display:block; border:0;">
                                    </a>
                                </td>
                                <td style="padding:0 8px;">
                                    <a href="https://instagram.com/yourhandle" target="_blank" style="text-decoration:none;">
                                        <img src="https://img.icons8.com/ios-filled/50/a3a3a3/instagram-new.png" alt="Instagram" width="18" height="18" style="display:block; border:0;">
                                    </a>
                                </td>
                                <td style="padding:0 8px;">
                                    <a href="https://facebook.com/yourhandle" target="_blank" style="text-decoration:none;">
                                        <img src="https://img.icons8.com/ios-filled/50/a3a3a3/facebook-new.png" alt="Facebook" width="18" height="18" style="display:block; border:0;">
                                    </a>
                                </td>
                                <td style="padding:0 8px;">
                                    <a href="https://linkedin.com/company/yourhandle" target="_blank" style="text-decoration:none;">
                                        <img src="https://img.icons8.com/ios-filled/50/a3a3a3/linkedin.png" alt="LinkedIn" width="18" height="18" style="display:block; border:0;">
                                    </a>
                                </td>
                            </tr>
                        </table>

                        <!-- Copyright -->
                        <p style="margin:0 0 8px 0; font-family:'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; font-size:11px; line-height:14px; letter-spacing:0.08em; font-weight:600; text-transform:uppercase; color:#847467;">
                            &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
                        </p>

                        <!-- Utility Links -->
                        <p style="margin:0; font-family:'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; font-size:12px; line-height:18px; color:#524439;">
                            <a href="#" style="color:#885211; text-decoration:underline;">Unsubscribe</a>
                            <span style="color:#d6c3b4; padding:0 4px;">&bull;</span>
                            <a href="#" style="color:#885211; text-decoration:underline;">Privacy Policy</a>
                        </p>

                    </td>
                </tr>

            </table>

        </td>
    </tr>
</table>

</body>
</html>
