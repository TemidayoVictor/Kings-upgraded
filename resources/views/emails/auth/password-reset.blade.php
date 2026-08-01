@component('emails.layouts.layout', ['title' => 'Reset Password'])
    <!-- Main Content Panel Frame -->
    <table width="100%" max-width="570" border="0" cellspacing="0" cellpadding="0" style="max-width: 570px; background-color: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 1px 3px rgba(0,0,0,0.02);">

        <!-- Top Body Content Panel -->
        <tr>
            <td style="padding: 40px 40px 32px 40px;">
                <!-- Context / Action Purpose Identifier Badge -->
                <table border="0" cellspacing="0" cellpadding="0" style="margin-bottom: 16px;">
                    <tr>
                        <td style="background-color: #f4f4f5; border-radius: 6px; padding: 4px 10px; font-size: 11px; font-weight: 600; color: #52525b; text-transform: uppercase; letter-spacing: 0.5px;">
                            Reset Password
                        </td>
                    </tr>
                </table>

                <!-- Primary Subject Headline Greeting -->
                <h1 style="margin: 0 0 16px 0; font-size: 20px; font-weight: 500; color: #1a1a1a; letter-spacing: -0.3px;">
                    {{ $headline ?? 'Hello ' . ($name ?? 'there') . ',' }}
                </h1>

                <!-- Main Context Body Text Description -->
                <p style="margin: 0 0 24px 0; font-size: 14px; line-height: 1.6; color: #555555; font-weight: 400;">
                    {{ $bodyText ?? 'We received a request to change the password for your account. Click the button below to choose a new password.' }}
                </p>

                <!-- Conditional Action Call to Action Button Box -->
                <table border="0" cellspacing="0" cellpadding="0" style="margin: 32px 0;">
                    <tr>
                        <td align="center" style="border-radius: 10px; background-color: #0a0a0a;">
                            <a href="{{ $url }}" target="_blank" style="display: inline-block; padding: 14px 32px; font-size: 13px; font-weight: 600; color: #ffffff; text-decoration: none; border-radius: 10px; letter-spacing: 0.5px;">
                                Reset Password
                            </a>
                        </td>
                    </tr>
                </table>

                <!-- Secondary Security / Expiration Details Instruction -->
                <p style="margin: 0 0 8px 0; font-size: 13px; line-height: 1.5; color: #737373; font-weight: 400;">
                    This secure link will expire in 60 minutes.
                </p>
                <p style="margin: 0; font-size: 13px; line-height: 1.5; color: #737373; font-weight: 400;">
                    If you did not make this request, you can safely ignore this email. Your account credentials will remain completely safe.
                </p>

            </td>
        </tr>

        <!-- Separator line Divider -->
        <tr>
            <td style="padding: 0 40px;">
                <div style="border-top: 1px solid #f0f0f0; height: 1px; line-height: 1px;"></div>
            </td>
        </tr>

        <!-- Troubleshooting Link Text Section -->
        <tr>
            <td style="padding: 24px 40px 40px 40px;">
                <p style="margin: 0; font-size: 12px; line-height: 1.5; color: #a3a3a3; font-weight: 400;">
                    If you are having trouble clicking the button, copy and paste the URL below directly into your web browser:
                </p>
                <p style="margin: 8px 0 0 0; font-size: 12px; line-height: 1.5; word-break: break-all; color: #2563eb; font-weight: 400;">
                    <a href="{{ $url }}" target="_blank" style="color: #2563eb; text-decoration: none;">{{ $url }}</a>
                </p>
            </td>
        </tr>
    </table>
@endcomponent
