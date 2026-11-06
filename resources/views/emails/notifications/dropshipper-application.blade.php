@component('emails.layouts.layout', ['title' => 'New Dropshipper Application'])

    {{-- Context badge (new application) --}}
    <table role="presentation" border="0" cellspacing="0" cellpadding="0" style="margin:0 0 16px 0;">
        <tr>
            <td style="background-color:#e8f5e9; border-radius:999px; padding:5px 12px;">
                <span style="display:inline-block; width:6px; height:6px; border-radius:3px; background-color:#2e7d32; vertical-align:middle; margin-right:6px;"></span><span style="font-family:'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; font-size:11px; line-height:14px; font-weight:600; letter-spacing:0.08em; text-transform:uppercase; color:#1b5e20; vertical-align:middle;">New Application</span>
            </td>
        </tr>
    </table>

    {{-- Greeting --}}
    <h1 style="margin:0 0 16px 0; font-family:'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; font-size:22px; line-height:28px; font-weight:600; letter-spacing:-0.01em; color:#1a1c1c;">
        Hello {{ $emailData['name'] ?? 'there' }},
    </h1>

    {{-- Body copy --}}
    <p style="margin:0 0 24px 0; font-family:'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; font-size:14px; line-height:22px; color:#524439;">
        A new dropshipper has applied to partner with your brand. You can review their application and decide whether to approve or decline the request.
    </p>

    {{-- Applicant highlight box --}}
    <table role="presentation" width="100%" border="0" cellspacing="0" cellpadding="0" style="margin:0 0 24px 0;">
        <tr>
            <td style="background-color:#f9f9f9; border:1px solid #e8e8e8; border-radius:10px; padding:16px 20px;">
                <span style="display:block; margin-bottom:4px; font-family:'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; font-size:11px; line-height:14px; font-weight:600; letter-spacing:0.08em; text-transform:uppercase; color:#737373;">Applicant</span>
                <span style="display:block; font-family:'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; font-size:14px; line-height:20px; font-weight:600; color:#1a1c1c;">{{ $emailData['dropshipper'] }}</span>
            </td>
        </tr>
    </table>

    {{-- CTA --}}
    <table role="presentation" border="0" cellspacing="0" cellpadding="0" width="100%" style="margin:32px 0 24px 0;">
        <tr>
            <td align="center" bgcolor="#1a1c1c" style="border-radius:8px;">
                <a href="{{ $emailData['url'] }}" target="_blank" style="display:block; width:100%; box-sizing:border-box; padding:14px 24px; font-family:'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; font-size:14px; line-height:20px; font-weight:600; color:#ffffff; text-decoration:none; text-align:center; border-radius:8px;">Review Application</a>
            </td>
        </tr>
    </table>

    {{-- Closing note --}}
    <p style="margin:0; font-family:'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; font-size:12px; line-height:18px; color:#737373;">
        Please visit your dashboard to review the application and take the appropriate action.
    </p>

@endcomponent
