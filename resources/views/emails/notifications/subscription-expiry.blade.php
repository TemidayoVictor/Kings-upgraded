@component('emails.layouts.layout', ['title' => 'Subscription Expiring Soon'])
    <!-- Main Content Panel Frame -->
    <table width="100%" max-width="570" border="0" cellspacing="0" cellpadding="0" style="max-width: 570px; background-color: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 1px 3px rgba(0,0,0,0.02);">

        <!-- Top Body Content Panel -->
        <tr>
            <td style="padding: 40px 40px 32px 40px;">
                <!-- Context / Action Purpose Identifier Badge -->
                <table border="0" cellspacing="0" cellpadding="0" style="margin-bottom: 16px;">
                    <tr>
                        <td style="background-color: #fef2f2; border-radius: 6px; padding: 4px 10px; font-size: 11px; font-weight: 600; color: #dc2626; text-transform: uppercase; letter-spacing: 0.5px;">
                            Subscription Alert
                        </td>
                    </tr>
                </table>

                <!-- Primary Subject Headline Greeting -->
                <h1 style="margin: 0 0 16px 0; font-size: 20px; font-weight: 500; color: #1a1a1a; letter-spacing: -0.3px;">
                    {{ 'Hello ' . ($emailData['name'] ?? 'there') . ',' }}
                </h1>

                <!-- Main Context Body Text Description -->
                <p style="margin: 0 0 24px 0; font-size: 14px; line-height: 1.6; color: #555555; font-weight: 400;">
                    @if($emailData['type'] == 'brand')
                        Your subscription to KING'S {{$emailData['plan']}} plan is set to expire soon. To keep enjoying uninterrupted access your current features, please renew your plan before it lapses.
                    @else
                        Your subscription to the KING'S dropshippers monthly plan is set to expire soon. To keep enjoying uninterrupted access your current features, please renew your plan before it lapses.
                    @endif
                </p>

                <!-- Expiry Date Highlight Box -->
                <table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-bottom: 24px; background-color: #fafafa; border: 1px solid #f0f0f0; border-radius: 10px;">
                    <tr>
                        <td style="padding: 16px 20px;">
                            <span style="font-size: 12px; color: #737373; text-transform: uppercase; letter-spacing: 0.5px; display: block; margin-bottom: 4px;">Expiration Date</span>
                            <span style="font-size: 15px; font-weight: 600; color: #1a1a1a;">{{ $emailData['expiry'] }}</span>
                        </td>
                    </tr>
                </table>

                <!-- Conditional Action Call to Action Button Box -->
                <table border="0" cellspacing="0" cellpadding="0" style="margin: 32px 0;">
                    <tr>
                        <td align="center" style="border-radius: 10px; background-color: #0a0a0a;">
                            <a href="{{ $emailData['url'] }}" target="_blank" style="display: inline-block; padding: 14px 32px; font-size: 13px; font-weight: 600; color: #ffffff; text-decoration: none; border-radius: 10px; letter-spacing: 0.5px;">
                                Renew Subscription
                            </a>
                        </td>
                    </tr>
                </table>

                <!-- Secondary Security / Expiration Details Instruction -->
                <p style="margin: 0 0 8px 0; font-size: 13px; line-height: 1.5; color: #737373; font-weight: 400;">
                    If you have already renewed your plan, please disregard this message.
                </p>
                <p style="margin: 0; font-size: 13px; line-height: 1.5; color: #737373; font-weight: 400;">
                    Need help or have questions about your billing? Reach out to our support team anytime.
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
