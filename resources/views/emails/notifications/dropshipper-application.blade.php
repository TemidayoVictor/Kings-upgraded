@component('emails.layouts.layout', ['title' => 'New Dropshipper Application']) <!-- Main Content Panel Frame --> <table width="100%" border="0" cellspacing="0" cellpadding="0" style="max-width: 570px; background-color: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 1px 3px rgba(0,0,0,0.02);">
    <!-- Top Body Content Panel -->
    <tr>
        <td style="padding: 40px 40px 32px 40px;">

            <!-- Context / Action Purpose Identifier Badge -->
            <table border="0" cellspacing="0" cellpadding="0" style="margin-bottom: 16px;">
                <tr>
                    <td style="background-color: #f0fdf4; border-radius: 6px; padding: 4px 10px; font-size: 11px; font-weight: 600; color: #16a34a; text-transform: uppercase; letter-spacing: 0.5px;">
                        New Application
                    </td>
                </tr>
            </table>

            <!-- Greeting -->
            <h1 style="margin: 0 0 16px 0; font-size: 20px; font-weight: 500; color: #1a1a1a; letter-spacing: -0.3px;">
                {{ 'Hello ' . ($emailData['name'] ?? 'there') . ',' }}
            </h1>

            <!-- Main Message -->
            <p style="margin: 0 0 24px 0; font-size: 14px; line-height: 1.6; color: #555555; font-weight: 400;">
                A new dropshipper has applied to partner with your brand. You can review their application and decide whether to approve or decline the request.
            </p>

            <!-- Applicant Highlight Box -->
            <table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-bottom: 24px; background-color: #fafafa; border: 1px solid #f0f0f0; border-radius: 10px;">
                <tr>
                    <td style="padding: 16px 20px;">
                        <span style="font-size: 12px; color: #737373; text-transform: uppercase; letter-spacing: 0.5px; display: block; margin-bottom: 4px;">
                            Applicant
                        </span>

                        <span style="font-size: 15px; font-weight: 600; color: #1a1a1a;">
                            {{ $emailData['dropshipper'] }}
                        </span>
                    </td>
                </tr>
            </table>

            <!-- Call to Action -->
            <table border="0" cellspacing="0" cellpadding="0" style="margin: 32px 0;">
                <tr>
                    <td align="center" style="border-radius: 10px; background-color: #0a0a0a;">
                        <a href="{{ $emailData['url'] }}" target="_blank" style="display: inline-block; padding: 14px 32px; font-size: 13px; font-weight: 600; color: #ffffff; text-decoration: none; border-radius: 10px; letter-spacing: 0.5px;">
                            Review Application
                        </a>
                    </td>
                </tr>
            </table>

            <!-- Closing Message -->
            <p style="margin: 0; font-size: 13px; line-height: 1.6; color: #737373; font-weight: 400;">
                Please visit your dashboard to review the application and take the appropriate action.
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
