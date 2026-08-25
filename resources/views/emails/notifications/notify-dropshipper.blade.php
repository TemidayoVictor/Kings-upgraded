@component('emails.layouts.layout', ['title' => 'Dropshipper Application Update']) <!-- Main Content Panel Frame -->
    <table width="100%" border="0" cellspacing="0" cellpadding="0" style="max-width: 570px; background-color: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 1px 3px rgba(0,0,0,0.02);">
        <!-- Top Body Content Panel -->
        <tr>
            <td style="padding: 40px 40px 32px 40px;">

                <!-- Context Badge -->
                <table border="0" cellspacing="0" cellpadding="0" style="margin-bottom: 16px;">
                    <tr>
                        <td style="background-color: #f0fdf4; border-radius: 6px; padding: 4px 10px; font-size: 11px; font-weight: 600; color: #16a34a; text-transform: uppercase; letter-spacing: 0.5px;">
                            Application Update
                        </td>
                    </tr>
                </table>

                <!-- Greeting -->
                <h1 style="margin: 0 0 16px 0; font-size: 20px; font-weight: 500; color: #1a1a1a; letter-spacing: -0.3px;">
                    {{ 'Hello ' . ($emailData['name'] ?? 'there') . ',' }}
                </h1>

                @if($emailData['type'] == 'approved')

                    <h2 style="margin: 0 0 16px 0; font-size: 17px; font-weight: 600; color: #1a1a1a;">
                        Your application has been accepted 🎉
                    </h2>

                    <p style="margin: 0 0 24px 0; font-size: 14px; line-height: 1.6; color: #555555; font-weight: 400;">
                        Great news! Your application to become a dropshipper for
                        <strong style="color: #1a1a1a;">{{ $emailData['brandName'] }}</strong>
                        has been accepted.
                    </p>

                    <p style="margin: 0 0 24px 0; font-size: 14px; line-height: 1.6; color: #555555; font-weight: 400;">
                        You can now access the brand's available products and start your dropshipping journey. Log in to your dashboard to explore the products and get started.
                    </p>

                @elseif($emailData['type'] == 'rejected')

                    <h2 style="margin: 0 0 16px 0; font-size: 17px; font-weight: 600; color: #1a1a1a;">
                        Your application was not approved
                    </h2>

                    <p style="margin: 0 0 24px 0; font-size: 14px; line-height: 1.6; color: #555555; font-weight: 400;">
                        Thank you for your interest in partnering with
                        <strong style="color: #1a1a1a;">{{ $emailData['brandName'] }}</strong>.
                    </p>

                    <p style="margin: 0 0 24px 0; font-size: 14px; line-height: 1.6; color: #555555; font-weight: 400;">
                        After reviewing your application, the brand owner has decided not to approve your request at this time.
                        We appreciate your interest and encourage you to explore other brands and opportunities available on the platform.
                    </p>

                @elseif($emailData['type'] == 'revoked')

                    <h2 style="margin: 0 0 16px 0; font-size: 17px; font-weight: 600; color: #1a1a1a;">
                        Your dropshipping partnership has been revoked
                    </h2>

                    <p style="margin: 0 0 24px 0; font-size: 14px; line-height: 1.6; color: #555555; font-weight: 400;">
                        We’re writing to let you know that your dropshipping partnership with
                        <strong style="color: #1a1a1a;">{{ $emailData['brandName'] }}</strong>
                        has been revoked by the brand owner.
                    </p>

                    <p style="margin: 0 0 24px 0; font-size: 14px; line-height: 1.6; color: #555555; font-weight: 400;">
                        As a result, you will no longer have access to this brand's dropshipping products and partnership benefits.
                        If you believe this was done in error or would like further clarification, please contact the brand owner or reach out to our support team.
                    </p>

                @endif

                <!-- Brand Highlight Box -->
                <table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-bottom: 24px; background-color: #fafafa; border: 1px solid #f0f0f0; border-radius: 10px;">
                    <tr>
                        <td style="padding: 16px 20px;">
                            <span style="font-size: 12px; color: #737373; text-transform: uppercase; letter-spacing: 0.5px; display: block; margin-bottom: 4px;">
                                Brand
                            </span>

                            <span style="font-size: 15px; font-weight: 600; color: #1a1a1a;">
                                {{ $emailData['brandName'] }}
                            </span>
                        </td>
                    </tr>
                </table>

                <!-- Call to Action -->
                <table border="0" cellspacing="0" cellpadding="0" style="margin: 32px 0;">
                    <tr>
                        <td align="center" style="border-radius: 10px; background-color: #0a0a0a;">
                            <a href="{{ $emailData['url'] }}" target="_blank" style="display: inline-block; padding: 14px 32px; font-size: 13px; font-weight: 600; color: #ffffff; text-decoration: none; border-radius: 10px; letter-spacing: 0.5px;">
                                @if($emailData['type'] == 'approved')
                                    View Brand
                                @elseif($emailData['type'] == 'rejected')
                                    Explore Other Brands
                                @else
                                    View Dashboard
                                @endif
                            </a>
                        </td>
                    </tr>
                </table>

                @if($emailData['type'] == 'approved')
                    <p style="margin: 0; font-size: 13px; line-height: 1.6; color: #737373; font-weight: 400;">
                        We’re excited to have you on board and look forward to seeing what you accomplish!
                    </p>
                @elseif($emailData['type'] == 'rejected')
                    <p style="margin: 0; font-size: 13px; line-height: 1.6; color: #737373; font-weight: 400;">
                        Keep exploring — there are more brands and opportunities waiting for you on the platform.
                    </p>
                @elseif($emailData['type'] == 'revoked')
                    <p style="margin: 0; font-size: 13px; line-height: 1.6; color: #737373; font-weight: 400;">
                        If you have any questions regarding this decision, please contact the brand owner or our support team.
                    </p>
                @endif

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
