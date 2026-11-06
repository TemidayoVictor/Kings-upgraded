@component('emails.layouts.layout', ['title' => 'Welcome to KING\'S'])

    {{-- Context badge --}}
    <table role="presentation" border="0" cellspacing="0" cellpadding="0" style="margin:0 0 16px 0;">
        <tr>
            <td style="background-color:#e8f5e9; border-radius:999px; padding:5px 12px;">
                <span style="display:inline-block; width:6px; height:6px; border-radius:3px; background-color:#2e7d32; vertical-align:middle; margin-right:6px;"></span><span style="font-family:'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; font-size:11px; line-height:14px; font-weight:600; letter-spacing:0.08em; text-transform:uppercase; color:#1b5e20; vertical-align:middle;">Welcome to KING'S</span>
            </td>
        </tr>
    </table>

    {{-- Greeting --}}
    <h1 style="margin:0 0 16px 0; font-family:'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; font-size:22px; line-height:28px; font-weight:600; letter-spacing:-0.01em; color:#1a1c1c;">
        Hi {{ $emailData['name'] ?? 'there' }},
    </h1>

    @if(($emailData['type'] ?? 'client') === App\Enums\UserType::BRAND)
        <p style="margin:0 0 16px 0; font-family:'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; font-size:14px; line-height:22px; color:#524439;">Welcome to KING'S! We're thrilled to have you join our growing network of entrepreneurs and business owners.</p>
        <p style="margin:0 0 16px 0; font-family:'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; font-size:14px; line-height:22px; color:#524439;">As a Brand Owner, you can list your products, connect with verified dropshippers who can sell on your behalf, and expand your market reach without the operational headaches.</p>
        <p style="margin:0 0 12px 0; font-family:'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; font-size:14px; line-height:22px; font-weight:600; color:#1a1c1c;">With KING'S, you can:</p>
        <ul style="margin:0 0 24px 0; padding-left:20px; font-family:'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; font-size:14px; line-height:22px; color:#524439;">
            <li style="margin-bottom:6px;">List and manage your product catalogs effortlessly.</li>
            <li style="margin-bottom:6px;">Partner with trusted dropshippers to scale your sales.</li>
            <li style="margin-bottom:6px;">Focus on fulfillment while partners handle marketing.</li>
            <li style="margin-bottom:6px;">Grow your business revenue securely.</li>
        </ul>
        <p style="margin:0 0 24px 0; font-family:'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; font-size:14px; line-height:22px; color:#524439;">Log in to your dashboard, set up your store, and take your brand to the next level. We're excited to be part of your journey!</p>

    @elseif(($emailData['type'] ?? 'client') === App\Enums\UserType::DROPSHIPPER)
        <p style="margin:0 0 16px 0; font-family:'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; font-size:14px; line-height:22px; color:#524439;">Welcome to KING'S! We're thrilled to have you join our growing network of entrepreneurs.</p>
        <p style="margin:0 0 16px 0; font-family:'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; font-size:14px; line-height:22px; color:#524439;">As a Dropshipper, you can build your business without the cost and risk of holding inventory. Simply discover products from trusted brands, market them to your audience, and earn profits on every successful sale.</p>
        <p style="margin:0 0 12px 0; font-family:'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; font-size:14px; line-height:22px; font-weight:600; color:#1a1c1c;">With KING'S, you can:</p>
        <ul style="margin:0 0 24px 0; padding-left:20px; font-family:'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; font-size:14px; line-height:22px; color:#524439;">
            <li style="margin-bottom:6px;">Browse products from verified Brand Owners.</li>
            <li style="margin-bottom:6px;">Start selling without purchasing inventory upfront.</li>
            <li style="margin-bottom:6px;">Focus on marketing while brands handle fulfillment.</li>
            <li style="margin-bottom:6px;">Grow your income at your own pace.</li>
        </ul>
        <p style="margin:0 0 24px 0; font-family:'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; font-size:14px; line-height:22px; color:#524439;">Your next opportunity could be just one product away. Log in, explore available products, and start selling today. We're excited to be part of your journey!</p>

    @else
        <p style="margin:0 0 16px 0; font-family:'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; font-size:14px; line-height:22px; color:#524439;">Welcome to KING'S! We're delighted you've joined our community.</p>
        <p style="margin:0 0 16px 0; font-family:'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; font-size:14px; line-height:22px; color:#524439;">As a Client, you can explore products from trusted brands, discover great deals, and shop with confidence—all in one place.</p>
        <p style="margin:0 0 12px 0; font-family:'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; font-size:14px; line-height:22px; font-weight:600; color:#1a1c1c;">Here's what you can do:</p>
        <ul style="margin:0 0 24px 0; padding-left:20px; font-family:'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; font-size:14px; line-height:22px; color:#524439;">
            <li style="margin-bottom:6px;">Browse a wide range of products from trusted businesses.</li>
            <li style="margin-bottom:6px;">Connect directly with reputable sellers.</li>
            <li style="margin-bottom:6px;">Enjoy a simple and seamless shopping experience.</li>
            <li style="margin-bottom:6px;">Stay updated on new products and exclusive offers.</li>
        </ul>
        <p style="margin:0 0 24px 0; font-family:'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; font-size:14px; line-height:22px; color:#524439;">Whether you're shopping for something specific or simply exploring, we're here to make every experience enjoyable. Start browsing today and discover something you'll love.</p>
    @endif

    {{-- CTA --}}
    <table role="presentation" border="0" cellspacing="0" cellpadding="0" width="100%" style="margin:32px 0 8px 0;">
        <tr>
            <td align="center" bgcolor="#1a1c1c" style="border-radius:8px;">
                <a href="{{ $url ?? url('/login') }}" target="_blank" style="display:block; width:100%; box-sizing:border-box; padding:14px 24px; font-family:'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; font-size:14px; line-height:20px; font-weight:600; color:#ffffff; text-decoration:none; text-align:center; border-radius:8px;">
                    @if(($emailData['type'] ?? 'client') === App\Enums\UserType::BRAND)
                        Go to Brand Dashboard
                    @elseif(($emailData['type'] ?? 'client') === App\Enums\UserType::DROPSHIPPER)
                        Explore Products
                    @else
                        Start Shopping
                    @endif
                </a>
            </td>
        </tr>
    </table>

    {{-- Sign-off --}}
    <p style="margin:24px 0 0 0; font-family:'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; font-size:14px; line-height:22px; color:#524439;">
        @if(($emailData['type'] ?? 'client') === \App\Enums\UserType::CLIENT)
            Happy shopping!<br>
        @endif
        Best regards,<br>
        <strong style="color:#1a1c1c;">The KING'S Team</strong>
    </p>

@endcomponent
