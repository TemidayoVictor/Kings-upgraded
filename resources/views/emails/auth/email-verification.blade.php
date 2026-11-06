@component('emails.layouts.layout', ['title' => 'Verify Your Email'])

    {{-- Context badge --}}
    <table role="presentation" border="0" cellspacing="0" cellpadding="0" style="margin:0 0 16px 0;">
        <tr>
            <td style="background-color:#eeeeee; border-radius:999px; padding:5px 12px;">
                <span style="font-family:'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; font-size:11px; line-height:14px; font-weight:600; letter-spacing:0.08em; text-transform:uppercase; color:#524439;">Email Verification</span>
            </td>
        </tr>
    </table>

    {{-- Greeting --}}
    <h1 style="margin:0 0 16px 0; font-family:'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; font-size:22px; line-height:28px; font-weight:600; letter-spacing:-0.01em; color:#1a1c1c;">
        Hello, {{ $emailData['name'] }}!
    </h1>

    {{-- Body copy --}}
    <p style="margin:0 0 24px 0; font-family:'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; font-size:14px; line-height:22px; color:#524439;">
        Thank you for signing up with KING'S! Please use the 6-digit verification code below to confirm your email address.
    </p>

    {{-- Verification code box --}}
    <table role="presentation" width="100%" border="0" cellspacing="0" cellpadding="0" style="margin:0 0 24px 0;">
        <tr>
            <td align="center" style="background-color:#f9f9f9; border:1px solid #e8e8e8; border-radius:10px; padding:24px;">
                <span style="display:inline-block; padding-left:8px; font-family:'SFMono-Regular', Consolas, 'Liberation Mono', Menlo, monospace; font-size:32px; line-height:38px; font-weight:700; letter-spacing:8px; color:#1a1c1c;">{{ $emailData['code'] }}</span>
            </td>
        </tr>
    </table>

    {{-- Expiry / safety notes --}}
    <p style="margin:0 0 8px 0; font-family:'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; font-size:12px; line-height:18px; color:#737373;">
        This verification code will expire in 15 minutes.
    </p>
    <p style="margin:0; font-family:'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; font-size:12px; line-height:18px; color:#737373;">
        If you did not sign up for KING'S, you can safely ignore this email.
    </p>

@endcomponent
