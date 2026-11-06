@component('emails.layouts.layout', ['title' => 'New Order Received'])

    {{-- Context badge (success / new order) --}}
    <table role="presentation" border="0" cellspacing="0" cellpadding="0" style="margin:0 0 16px 0;">
        <tr>
            <td style="background-color:#e8f5e9; border-radius:999px; padding:5px 12px;">
                <span style="display:inline-block; width:6px; height:6px; border-radius:3px; background-color:#2e7d32; vertical-align:middle; margin-right:6px;"></span><span style="font-family:'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; font-size:11px; line-height:14px; font-weight:600; letter-spacing:0.08em; text-transform:uppercase; color:#1b5e20; vertical-align:middle;">New Order</span>
            </td>
        </tr>
    </table>

    {{-- Greeting --}}
    <h1 style="margin:0 0 16px 0; font-family:'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; font-size:22px; line-height:28px; font-weight:600; letter-spacing:-0.01em; color:#1a1c1c;">
        Hello {{ $emailData['name'] ?? 'Store Owner' }},
    </h1>

    {{-- Body copy --}}
    <p style="margin:0 0 24px 0; font-family:'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; font-size:14px; line-height:22px; color:#524439;">
        Great news! You have received a new order on KING'S. Review the details below and log in to your dashboard to view it.
    </p>

    {{-- Order details box --}}
    <table role="presentation" width="100%" border="0" cellspacing="0" cellpadding="0" style="margin:0 0 24px 0;">
        <tr>
            <td style="background-color:#f9f9f9; border:1px solid #e8e8e8; border-radius:10px; padding:16px 20px;">
                <table role="presentation" width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td style="padding:0 0 12px 0; font-family:'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; font-size:13px; line-height:20px; color:#737373;">Order Number:</td>
                        <td align="right" style="padding:0 0 12px 0; font-family:'SFMono-Regular', Consolas, 'Liberation Mono', Menlo, monospace; font-size:13px; line-height:20px; font-weight:600; color:#1a1c1c;">{{ $emailData['orderNumber'] }}</td>
                    </tr>
                    <tr>
                        <td style="padding:0 0 12px 0; font-family:'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; font-size:13px; line-height:20px; color:#737373;">Customer Name:</td>
                        <td align="right" style="padding:0 0 12px 0; font-family:'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; font-size:13px; line-height:20px; font-weight:600; color:#1a1c1c;">{{ $emailData['customerName'] }}</td>
                    </tr>
                    <tr>
                        <td style="font-family:'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; font-size:13px; line-height:20px; color:#737373;">Total Amount:</td>
                        <td align="right" style="font-family:'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; font-size:15px; line-height:20px; font-weight:700; color:#1a1c1c;">&#8358;{{ number_format($emailData['amount']) }}</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    {{-- CTA --}}
    <table role="presentation" border="0" cellspacing="0" cellpadding="0" width="100%" style="margin:32px 0 24px 0;">
        <tr>
            <td align="center" bgcolor="#1a1c1c" style="border-radius:8px;">
                <a href="{{ $emailData['url'] }}" target="_blank" style="display:block; width:100%; box-sizing:border-box; padding:14px 24px; font-family:'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; font-size:14px; line-height:20px; font-weight:600; color:#ffffff; text-decoration:none; text-align:center; border-radius:8px;">View Order Details</a>
            </td>
        </tr>
    </table>

    {{-- Closing note --}}
    <p style="margin:0; font-family:'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; font-size:12px; line-height:18px; color:#737373;">
        Make sure to process this order promptly to maintain a great customer experience on KING'S.
    </p>

@endcomponent
