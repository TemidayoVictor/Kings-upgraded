@component('emails.layouts.layout', ['title' => 'Welcome to KING\'S'])
    <!-- Main Content Panel Frame -->
    <table width="100%" max-width="570" border="0" cellspacing="0" cellpadding="0" style="max-width: 570px; background-color: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 1px 3px rgba(0,0,0,0.02);">

        <!-- Top Body Content Panel -->
        <tr>
            <td style="padding: 40px 40px 32px 40px;">
                <!-- Context / Action Purpose Identifier Badge -->
                <table border="0" cellspacing="0" cellpadding="0" style="margin-bottom: 16px;">
                    <tr>
                        <td style="background-color: #f4f4f5; border-radius: 6px; padding: 4px 10px; font-size: 11px; font-weight: 600; color: #52525b; text-transform: uppercase; letter-spacing: 0.5px;">
                            Welcome to KING'S
                        </td>
                    </tr>
                </table>

                <!-- Primary Subject Headline Greeting -->
                <h1 style="margin: 0 0 16px 0; font-size: 20px; font-weight: 500; color: #1a1a1a; letter-spacing: -0.3px;">
                    Hi {{ $emailData['name'] ?? 'there' }},
                </h1>

                @if(($emailData['type'] ?? 'client') === App\Enums\UserType::BRAND)
                    <!-- BRAND WELCOME CONTENT -->
                    <p style="margin: 0 0 16px 0; font-size: 14px; line-height: 1.6; color: #555555; font-weight: 400;">
                        Welcome to KING'S! We're thrilled to have you join our growing network of entrepreneurs and business owners.
                    </p>
                    <p style="margin: 0 0 16px 0; font-size: 14px; line-height: 1.6; color: #555555; font-weight: 400;">
                        As a Brand Owner, you can list your products, connect with verified dropshippers who can sell on your behalf, and expand your market reach without the operational headaches.
                    </p>
                    <p style="margin: 0 0 12px 0; font-size: 14px; font-weight: 600; color: #1a1a1a;">
                        With KING'S, you can:
                    </p>
                    <ul style="margin: 0 0 24px 0; padding-left: 20px; font-size: 14px; line-height: 1.6; color: #555555;">
                        <li style="margin-bottom: 6px;">List and manage your product catalogs effortlessly.</li>
                        <li style="margin-bottom: 6px;">Partner with trusted dropshippers to scale your sales.</li>
                        <li style="margin-bottom: 6px;">Focus on fulfillment while partners handle marketing.</li>
                        <li style="margin-bottom: 6px;">Grow your business revenue securely.</li>
                    </ul>
                    <p style="margin: 0 0 24px 0; font-size: 14px; line-height: 1.6; color: #555555; font-weight: 400;">
                        Log in to your dashboard, set up your store, and take your brand to the next level. We're excited to be part of your journey!
                    </p>

                @elseif(($emailData['type'] ?? 'client') === App\Enums\UserType::DROPSHIPPER)
                    <!-- DROPSHIPPER WELCOME CONTENT -->
                    <p style="margin: 0 0 16px 0; font-size: 14px; line-height: 1.6; color: #555555; font-weight: 400;">
                        Welcome to KING'S! We're thrilled to have you join our growing network of entrepreneurs.
                    </p>
                    <p style="margin: 0 0 16px 0; font-size: 14px; line-height: 1.6; color: #555555; font-weight: 400;">
                        As a Dropshipper, you can build your business without the cost and risk of holding inventory. Simply discover products from trusted brands, market them to your audience, and earn profits on every successful sale.
                    </p>
                    <p style="margin: 0 0 12px 0; font-size: 14px; font-weight: 600; color: #1a1a1a;">
                        With KING'S, you can:
                    </p>
                    <ul style="margin: 0 0 24px 0; padding-left: 20px; font-size: 14px; line-height: 1.6; color: #555555;">
                        <li style="margin-bottom: 6px;">Browse products from verified Brand Owners.</li>
                        <li style="margin-bottom: 6px;">Start selling without purchasing inventory upfront.</li>
                        <li style="margin-bottom: 6px;">Focus on marketing while brands handle fulfillment.</li>
                        <li style="margin-bottom: 6px;">Grow your income at your own pace.</li>
                    </ul>
                    <p style="margin: 0 0 24px 0; font-size: 14px; line-height: 1.6; color: #555555; font-weight: 400;">
                        Your next opportunity could be just one product away. Log in, explore available products, and start selling today. We're excited to be part of your journey!
                    </p>

                @else
                    <!-- CLIENT WELCOME CONTENT -->
                    <p style="margin: 0 0 16px 0; font-size: 14px; line-height: 1.6; color: #555555; font-weight: 400;">
                        Welcome to KING'S! We're delighted you've joined our community.
                    </p>
                    <p style="margin: 0 0 16px 0; font-size: 14px; line-height: 1.6; color: #555555; font-weight: 400;">
                        As a Client, you can explore products from trusted brands, discover great deals, and shop with confidence—all in one place.
                    </p>
                    <p style="margin: 0 0 12px 0; font-size: 14px; font-weight: 600; color: #1a1a1a;">
                        Here's what you can do:
                    </p>
                    <ul style="margin: 0 0 24px 0; padding-left: 20px; font-size: 14px; line-height: 1.6; color: #555555;">
                        <li style="margin-bottom: 6px;">Browse a wide range of products from trusted businesses.</li>
                        <li style="margin-bottom: 6px;">Connect directly with reputable sellers.</li>
                        <li style="margin-bottom: 6px;">Enjoy a simple and seamless shopping experience.</li>
                        <li style="margin-bottom: 6px;">Stay updated on new products and exclusive offers.</li>
                    </ul>
                    <p style="margin: 0 0 24px 0; font-size: 14px; line-height: 1.6; color: #555555; font-weight: 400;">
                        Whether you're shopping for something specific or simply exploring, we're here to make every experience enjoyable. Start browsing today and discover something you'll love.
                    </p>
                @endif

                <!-- Conditional Action Call to Action Button Box -->
                <table border="0" cellspacing="0" cellpadding="0" style="margin: 32px 0 16px 0;">
                    <tr>
                        <td align="center" style="border-radius: 10px; background-color: #0a0a0a;">
                            <a href="{{ $url ?? url('/login') }}" target="_blank" style="display: inline-block; padding: 14px 32px; font-size: 13px; font-weight: 600; color: #ffffff; text-decoration: none; border-radius: 10px; letter-spacing: 0.5px;">
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

                <!-- Closing Sign-off -->
                <p style="margin: 24px 0 0 0; font-size: 14px; line-height: 1.5; color: #555555; font-weight: 400;">
                    @if(($emailData['type'] ?? 'client') === \App\Enums\UserType::CLIENT)
                        Happy shopping!<br>
                    @endif
                    Best regards,<br>
                    <strong style="color: #1a1a1a;">The KING'S Team</strong>
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
