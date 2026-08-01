@component('emails.layouts.layout', ['title' => 'New Order Received'])
    <!-- Main Content Panel Frame -->
    <table width="100%" max-width="570" border="0" cellspacing="0" cellpadding="0" style="max-width: 570px; background-color: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 1px 3px rgba(0,0,0,0.02);">

        <!-- Top Body Content Panel -->
        <tr>
            <td style="padding: 40px 40px 32px 40px;">
                <!-- Context / Action Purpose Identifier Badge -->
                <table border="0" cellspacing="0" cellpadding="0" style="margin-bottom: 16px;">
                    <tr>
                        <td style="background-color: #f0fdf4; border-radius: 6px; padding: 4px 10px; font-size: 11px; font-weight: 600; color: #16a34a; text-transform: uppercase; letter-spacing: 0.5px;">
                            New Order
                        </td>
                    </tr>
                </table>

                <!-- Primary Subject Headline Greeting -->
                <h1 style="margin: 0 0 16px 0; font-size: 20px; font-weight: 500; color: #1a1a1a; letter-spacing: -0.3px;">
                    {{ 'Hello ' . ($emailData['name'] ?? 'Store Owner') . ',' }}
                </h1>

                <!-- Main Context Body Text Description -->
                <p style="margin: 0 0 24px 0; font-size: 14px; line-height: 1.6; color: #555555; font-weight: 400;">
                    {{ 'Great news! You have received a new order on KING\'S. Review the details below and log in to your dashboard to view it.' }}
                </p>

                <!-- Order Details Highlight Box -->
                <table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-bottom: 24px; background-color: #fafafa; border: 1px solid #f0f0f0; border-radius: 10px;">
                    <tr>
                        <td style="padding: 20px;">
                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td style="padding-bottom: 12px; font-size: 13px; color: #737373;">Order Number:</td>
                                    <td align="right" style="padding-bottom: 12px; font-size: 13px; font-weight: 600; color: #1a1a1a;">{{ $emailData['orderNumber']}}</td>
                                </tr>
                                <tr>
                                    <td style="padding-bottom: 12px; font-size: 13px; color: #737373;">Customer Name:</td>
                                    <td align="right" style="padding-bottom: 12px; font-size: 13px; font-weight: 600; color: #1a1a1a;">{{ $emailData['customerName'] }}</td>
                                </tr>
                                <tr>
                                    <td style="font-size: 13px; color: #737373;">Total Amount:</td>
                                    <td align="right" style="font-size: 15px; font-weight: 700; color: #1a1a1a;">₦{{ number_format($emailData['amount']) }}</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>

                <!-- Conditional Action Call to Action Button Box -->
                <table border="0" cellspacing="0" cellpadding="0" style="margin: 32px 0;">
                    <tr>
                        <td align="center" style="border-radius: 10px; background-color: #0a0a0a;">
                            <a href="{{ $emailData['url'] }}" target="_blank" style="display: inline-block; padding: 14px 32px; font-size: 13px; font-weight: 600; color: #ffffff; text-decoration: none; border-radius: 10px; letter-spacing: 0.5px;">
                                View Order Details
                            </a>
                        </td>
                    </tr>
                </table>

                <!-- Secondary Security / Expiration Details Instruction -->
                <p style="margin: 0; font-size: 13px; line-height: 1.5; color: #737373; font-weight: 400;">
                    Make sure to process this order promptly to maintain a great customer experience on KING'S.
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
