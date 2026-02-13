@extends('emails.layouts.email')

@section('subject', 'Verify Your Email Address - ' . config('app.name'))
@section('header', 'Welcome Aboard! 🚀')

@section('content')
    <h2>Hello, {{ $emailData['name'] }}!</h2>

    <p>
        Thanks for signing up for {{ config('app.name') }}! We're excited to have you on board.
        To complete your registration, please verify your email address using the code below:
    </p>

    {{-- Verification Code Card --}}
    <div class="code-block">
        <div class="code-label">Verification Code</div>
        <div class="code">{{ $emailData['code'] }}</div>
        <div class="code-expiry">⏰ Expires in 10 minutes</div>
    </div>

    <p style="text-align: center; margin-bottom: 8px;">
        <strong>Can't copy the code?</strong>
    </p>

    {{-- Alternative Button --}}
{{--    <div style="text-align: center;">--}}
{{--        <a href="{{ route('verification.verify', ['code' => $code]) }}" class="button">--}}
{{--            Verify Email Instantly--}}
{{--        </a>--}}
{{--        <p style="font-size: 14px; color: #64748b; margin-top: 8px;">--}}
{{--            This link will also expire in 10 minutes--}}
{{--        </p>--}}
{{--    </div>--}}

    <div class="divider"></div>

    <p style="font-size: 15px; color: #475569; margin-bottom: 0;">
        <strong>Didn't request this?</strong> If you didn't create an account with
        {{ config('app.name') }}, you can safely ignore this email. No changes have been made to your account.
    </p>
@endsection
