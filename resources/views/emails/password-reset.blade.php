@component('emails.layouts.layout', ['title' => 'Reset Password'])

    <table border="0" cellspacing="0" cellpadding="0" style="margin-bottom: 16px;">
        <tr>
            <td style="background-color: #f4f4f5; border-radius: 6px; padding: 4px 10px; font-size: 11px; color: #52525b; text-transform: uppercase;">
                Security Alert
            </td>
        </tr>
    </table>

    <h1 style="margin: 0 0 16px 0; font-size: 20px; color: #1a1a1a;">Hello {{ $name }},</h1>
    <p style="color: #555555; line-height: 1.6;">We received a request to change your password.</p>

    <table border="0" cellspacing="0" cellpadding="0" style="margin: 32px 0;">
        <tr>
            <td align="center" style="border-radius: 10px; background-color: #0a0a0a;">
                <a href="{{ $url }}" style="display: block; padding: 14px 32px; color: #ffffff; text-decoration: none; font-weight: 600;">Reset Password</a>
            </td>
        </tr>
    </table>

@endcomponent
