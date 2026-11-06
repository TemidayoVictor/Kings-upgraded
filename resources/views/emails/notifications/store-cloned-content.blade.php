@component('emails.layouts.layout', ['title' => 'New Store Clone Request'])

    {{-- Context badge (informational / partnership) --}}
    <table role="presentation" border="0" cellspacing="0" cellpadding="0" style="margin:0 0 16px 0;">
        <tr>
            <td style="background-color:#e8efff; border-radius:999px; padding:5px 12px;">
                <span style="display:inline-block; width:6px; height:6px; border-radius:3px; background-color:#2563eb; vertical-align:middle; margin-right:6px;"></span><span style="font-family:'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; font-size:11px; line-height:14px; font-weight:600; letter-spacing:0.08em; text-transform:uppercase; color:#1e40af; vertical-align:middle;">Store Partnership</span>
            </td>
        </tr>
    </table>

    {{-- Greeting --}}
    <h1 style="margin:0 0 16px 0; font-family:'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; font-size:22px; line-height:28px; font-weight:600; letter-spacing:-0.01em; color:#1a1c1c;">
        {{ $headline ?? 'Hello ' . ($name ?? 'Store Owner') . ',' }}
    </h1>

    {{-- Body copy --}}
    <p style="margin:0 0 24px 0; font-family:'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; font-size:14px; line-height:22px; color:#524439;">
        {{ $bodyText ?? 'A dropshipper has requested to clone your store catalog on KING\'S to sell products on your behalf and expand your sales reach.' }}
    </p>

    {{-- Dropshipper details box --}}
    <table role="presentation" width="100%" border="0" cellspacing="0" cellpadding="0" style="margin:0 0 24px 0;">
        <tr>
            <td style="background-color:#f9f9f9; border:1px solid #e8e8e8; border-radius:10px; padding:16px 20px;">
                <table role="presentation" width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td style="padding:0 0 12px 0; font-family:'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; font-size:13px; line-height:20px; color:#737373;">Dropshipper Name:</td>
                        <td align="right" style="padding:0 0 12px 0; font-family:'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; font-size:13px; line-height:20px; font-weight:600; color:#1a1c1c;">{{ $dropshipperName ?? 'Alex Smith' }}</td>
                    </tr>
                    <tr>
                        <td style="font-family:'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; font-size:13px; line-height:20px; color:#737373;">Request Date:</td>
                        <td align="right" style="font-family:'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; font-size:13px; line-height:20px; font-weight:600; color:#1a1c1c;">{{ $requestDate ?? 'July 26, 2026' }}</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    {{-- CTA --}}
    <table role="presentation" border="0" cellspacing="0" cellpadding="0" width="100%" style="margin:32px 0 24px 0;">
        <tr>
            <td align="center" bgcolor="#1a1c1c" style="border-radius:8px;">
                <a href="{{ $url }}" target="_blank" style="display:block; width:100%; box-sizing:border-box; padding:14px 24px; font-family:'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; font-size:14px; line-height:20px; font-weight:600; color:#ffffff; text-decoration:none; text-align:center; border-radius:8px;">Review Clone Request</a>
            </td>
        </tr>
    </table>

    {{-- Secondary notes --}}
    <p style="margin:0 0 8px 0; font-family:'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; font-size:12px; line-height:18px; color:#737373;">
        You can choose to approve or decline this cloning request from your dashboard at any time.
    </p>
    <p style="margin:0; font-family:'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; font-size:12px; line-height:18px; color:#737373;">
        If you did not expect this request, you can safely ignore this email and no changes will be made to your store.
    </p>

    {{-- Troubleshooting fallback URL --}}
    <table role="presentation" width="100%" border="0" cellspacing="0" cellpadding="0" style="margin:24px 0 0 0;">
        <tr>
            <td style="border-top:1px solid #e8e8e8; padding-top:20px;">
                <p style="margin:0; font-family:'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; font-size:12px; line-height:18px; color:#847467;">
                    If you are having trouble clicking the button, copy and paste the URL below directly into your web browser:
                </p>
                <p style="margin:8px 0 0 0; font-family:'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; font-size:12px; line-height:18px; word-break:break-all; overflow-wrap:anywhere; color:#885211;">
                    <a href="{{ $url }}" target="_blank" style="color:#885211; text-decoration:underline;">{{ $url }}</a>
                </p>
            </td>
        </tr>
    </table>

@endcomponent
