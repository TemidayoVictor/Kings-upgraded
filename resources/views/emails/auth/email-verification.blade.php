@component('emails.layouts.layout', ['title' => 'Verify Your Email'])
    <!-- Main Content Panel Frame -->
    <table width="100%" max-width="570" border="0" cellspacing="0" cellpadding="0" style="max-width: 570px; background-color: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 1px 3px rgba(0,0,0,0.02);">

        <!-- Top Body Content Panel -->
        <tr>
            <td style="padding: 40px 40px 32px 40px;">
                <!-- Context / Action Purpose Identifier Badge -->
                <table border="0" cellspacing="0" cellpadding="0" style="margin-bottom: 16px;">
                    <tr>
                        <td style="background-color: #f4f4f5; border-radius: 6px; padding: 4px 10px; font-size: 11px; font-weight: 600; color: #52525b; text-transform: uppercase; letter-spacing: 0.5px;">
                            Email Verification
                        </td>
                    </tr>
                </table>

                <!-- Primary Subject Headline Greeting -->
                <h1 style="margin: 0 0 16px 0; font-size: 20px; font-weight: 500; color: #1a1a1a; letter-spacing: -0.3px;">
                    Hello, {{ $emailData['name'] }}!
                </h1>

                <!-- Main Context Body Text Description -->
                <p style="margin: 0 0 24px 0; font-size: 14px; line-height: 1.6; color: #555555; font-weight: 400;">
                    {{ 'Thank you for signing up with KING\'S! Please use the 6-digit verification code below to confirm your email address.' }}
                </p>

                <!-- 6-Digit Code Display Box -->
                <table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-bottom: 24px; background-color: #fafafa; border: 1px solid #f0f0f0; border-radius: 10px;">
                    <tr>
                        <td align="center" style="padding: 24px;">
                            <span style="font-size: 32px; font-weight: 700; color: #1a1a1a; letter-spacing: 8px; font-family: monospace;">
                                {{ $emailData['code'] }}
                            </span>
                        </td>
                    </tr>
                </table>

                <!-- Secondary Security / Expiration Details Instruction -->
                <p style="margin: 0 0 8px 0; font-size: 13px; line-height: 1.5; color: #737373; font-weight: 400;">
                    This verification code will expire in 15 minutes.
                </p>
                <p style="margin: 0; font-size: 13px; line-height: 1.5; color: #737373; font-weight: 400;">
                    If you did not sign up for KING'S, you can safely ignore this email.
                </p>

            </td>
        </tr>

        <!-- Separator line Divider -->
        <tr>
            <td style="padding: 0 40px;">
                <div style="border-top: 1px solid #f0f0f0; height: 1px; line-height: 1px;"></div>
            </td>
        </tr>
    </table>
@endcomponent
