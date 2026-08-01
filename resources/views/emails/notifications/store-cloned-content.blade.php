@component('emails.layouts.layout', ['title' => 'New Store Clone Request'])
    <!-- Main Content Panel Frame -->
    <table width="100%" max-width="570" border="0" cellspacing="0" cellpadding="0" style="max-width: 570px; background-color: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 1px 3px rgba(0,0,0,0.02);">

        <!-- Top Body Content Panel -->
        <tr>
            <td style="padding: 40px 40px 32px 40px;">
                <!-- Context / Action Purpose Identifier Badge -->
                <table border="0" cellspacing="0" cellpadding="0" style="margin-bottom: 16px;">
                    <tr>
                        <td style="background-color: #eff6ff; border-radius: 6px; padding: 4px 10px; font-size: 11px; font-weight: 600; color: #2563eb; text-transform: uppercase; letter-spacing: 0.5px;">
                            Store Partnership
                        </td>
                    </tr>
                </table>

                <!-- Primary Subject Headline Greeting -->
                <h1 style="margin: 0 0 16px 0; font-size: 20px; font-weight: 500; color: #1a1a1a; letter-spacing: -0.3px;">
                    {{ $headline ?? 'Hello ' . ($name ?? 'Store Owner') . ',' }}
                </h1>

                <!-- Main Context Body Text Description -->
                <p style="margin: 0 0 24px 0; font-size: 14px; line-height: 1.6; color: #555555; font-weight: 400;">
                    {{ $bodyText ?? 'A dropshipper has requested to clone your store catalog on KING\'S to sell products on your behalf and expand your sales reach.' }}
                </p>

                <!-- Dropshipper Details Highlight Box -->
                <table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-bottom: 24px; background-color: #fafafa; border: 1px solid #f0f0f0; border-radius: 10px;">
                    <tr>
                        <td style="padding: 20px;">
                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td style="padding-bottom: 12px; font-size: 13px; color: #737373;">Dropshipper Name:</td>
                                    <td align="right" style="padding-bottom: 12px; font-size: 13px; font-weight: 600; color: #1a1a1a;">{{ $dropshipperName ?? 'Alex Smith' }}</td>
                                </tr>
                                <tr>
                                    <td style="font-size: 13px; color: #737373;">Request Date:</td>
                                    <td align="right" style="font-size: 13px; font-weight: 600; color: #1a1a1a;">{{ $requestDate ?? 'July 26, 2026' }}</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>

                <!-- Conditional Action Call to Action Button Box -->
                <table border="0" cellspacing="0" cellpadding="0" style="margin: 32px 0;">
                    <tr>
                        <td align="center" style="border-radius: 10px; background-color: #0a0a0a;">
                            <a href="{{ $url }}" target="_blank" style="display: inline-block; padding: 14px 32px; font-size: 13px; font-weight: 600; color: #ffffff; text-decoration: none; border-radius: 10px; letter-spacing: 0.5px;">
                                Review Clone Request
                            </a>
                        </td>
                    </tr>
                </table>

                <!-- Secondary Security / Expiration Details Instruction -->
                <p style="margin: 0 0 8px 0; font-size: 13px; line-height: 1.5; color: #737373; font-weight: 400;">
                    You can choose to approve or decline this cloning request from your dashboard at any time.
                </p>
                <p style="margin: 0; font-size: 13px; line-height: 1.5; color: #737373; font-weight: 400;">
                    If you did not expect this request, you can safely ignore this email and no changes will be made to your store.
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
