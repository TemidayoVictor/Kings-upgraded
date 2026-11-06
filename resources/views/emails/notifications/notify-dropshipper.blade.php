@component('emails.layouts.layout', ['title' => 'Dropshipper Application Update'])

    @php
        $type = $emailData['type'] ?? 'approved';
    @endphp

    {{-- Context badge (state-aware) --}}
    <table role="presentation" border="0" cellspacing="0" cellpadding="0" style="margin:0 0 16px 0;">
        <tr>
            <td style="background-color:{{ $type === 'approved' ? '#e8f5e9' : '#eeeeee' }}; border-radius:999px; padding:5px 12px;">
                <span style="display:inline-block; width:6px; height:6px; border-radius:3px; background-color:{{ $type === 'approved' ? '#2e7d32' : '#847467' }}; vertical-align:middle; margin-right:6px;"></span><span style="font-family:'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; font-size:11px; line-height:14px; font-weight:600; letter-spacing:0.08em; text-transform:uppercase; color:{{ $type === 'approved' ? '#1b5e20' : '#524439' }}; vertical-align:middle;">Application Update</span>
            </td>
        </tr>
    </table>

    {{-- Greeting --}}
    <h1 style="margin:0 0 16px 0; font-family:'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; font-size:22px; line-height:28px; font-weight:600; letter-spacing:-0.01em; color:#1a1c1c;">
        Hello {{ $emailData['name'] ?? 'there' }},
    </h1>

    @if($type === 'approved')

        <h2 style="margin:0 0 16px 0; font-family:'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; font-size:18px; line-height:24px; font-weight:600; letter-spacing:-0.005em; color:#1a1c1c;">
            Your application has been accepted &#127881;
        </h2>

        <p style="margin:0 0 24px 0; font-family:'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; font-size:14px; line-height:22px; color:#524439;">
            Great news! Your application to become a dropshipper for <strong style="color:#1a1c1c;">{{ $emailData['brandName'] }}</strong> has been accepted.
        </p>

        <p style="margin:0 0 24px 0; font-family:'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; font-size:14px; line-height:22px; color:#524439;">
            You can now access the brand's available products and start your dropshipping journey. Log in to your dashboard to explore the products and get started.
        </p>

    @elseif($type === 'rejected')

        <h2 style="margin:0 0 16px 0; font-family:'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; font-size:18px; line-height:24px; font-weight:600; letter-spacing:-0.005em; color:#1a1c1c;">
            Your application was not approved
        </h2>

        <p style="margin:0 0 24px 0; font-family:'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; font-size:14px; line-height:22px; color:#524439;">
            Thank you for your interest in partnering with <strong style="color:#1a1c1c;">{{ $emailData['brandName'] }}</strong>.
        </p>

        <p style="margin:0 0 24px 0; font-family:'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; font-size:14px; line-height:22px; color:#524439;">
            After reviewing your application, the brand owner has decided not to approve your request at this time. We appreciate your interest and encourage you to explore other brands and opportunities available on the platform.
        </p>

    @elseif($type === 'revoked')

        <h2 style="margin:0 0 16px 0; font-family:'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; font-size:18px; line-height:24px; font-weight:600; letter-spacing:-0.005em; color:#1a1c1c;">
            Your dropshipping partnership has been revoked
        </h2>

        <p style="margin:0 0 24px 0; font-family:'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; font-size:14px; line-height:22px; color:#524439;">
            We're writing to let you know that your dropshipping partnership with <strong style="color:#1a1c1c;">{{ $emailData['brandName'] }}</strong> has been revoked by the brand owner.
        </p>

        <p style="margin:0 0 24px 0; font-family:'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; font-size:14px; line-height:22px; color:#524439;">
            As a result, you will no longer have access to this brand's dropshipping products and partnership benefits. If you believe this was done in error or would like further clarification, please contact the brand owner or reach out to our support team.
        </p>

    @endif

    {{-- Brand highlight box --}}
    <table role="presentation" width="100%" border="0" cellspacing="0" cellpadding="0" style="margin:0 0 24px 0;">
        <tr>
            <td style="background-color:#f9f9f9; border:1px solid #e8e8e8; border-radius:10px; padding:16px 20px;">
                <span style="display:block; margin-bottom:4px; font-family:'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; font-size:11px; line-height:14px; font-weight:600; letter-spacing:0.08em; text-transform:uppercase; color:#737373;">Brand</span>
                <span style="display:block; font-family:'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; font-size:14px; line-height:20px; font-weight:600; color:#1a1c1c;">{{ $emailData['brandName'] }}</span>
            </td>
        </tr>
    </table>

    {{-- CTA --}}
    <table role="presentation" border="0" cellspacing="0" cellpadding="0" width="100%" style="margin:32px 0 24px 0;">
        <tr>
            <td align="center" bgcolor="#1a1c1c" style="border-radius:8px;">
                <a href="{{ $emailData['url'] }}" target="_blank" style="display:block; width:100%; box-sizing:border-box; padding:14px 24px; font-family:'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; font-size:14px; line-height:20px; font-weight:600; color:#ffffff; text-decoration:none; text-align:center; border-radius:8px;">
                    @if($type === 'approved')
                        View Brand
                    @elseif($type === 'rejected')
                        Explore Other Brands
                    @else
                        View Dashboard
                    @endif
                </a>
            </td>
        </tr>
    </table>

    {{-- Closing note --}}
    @if($type === 'approved')
        <p style="margin:0; font-family:'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; font-size:12px; line-height:18px; color:#737373;">
            We're excited to have you on board and look forward to seeing what you accomplish!
        </p>
    @elseif($type === 'rejected')
        <p style="margin:0; font-family:'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; font-size:12px; line-height:18px; color:#737373;">
            Keep exploring — there are more brands and opportunities waiting for you on the platform.
        </p>
    @elseif($type === 'revoked')
        <p style="margin:0; font-family:'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; font-size:12px; line-height:18px; color:#737373;">
            If you have any questions regarding this decision, please contact the brand owner or our support team.
        </p>
    @endif

@endcomponent
