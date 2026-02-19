<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class OnboardingMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        $user = auth()->user();

        if (!$user) {
            return $next($request);
        }

        // Admins skip onboarding
        if ($user->role === 'admin') {
            return $next($request);
        }

        $currentRoute = $request->route()->getName();

        return match ($user->onboarding_step) {

            // User must verify email
            'email_verification' =>
            $currentRoute !== 'verify-email'
                ? redirect()->route('verify-email')
                : $next($request),

            // User must select role
            'role_selection' =>
            $currentRoute !== 'select-role'
                ? redirect()->route('select-role')
                : $next($request),

            // Onboarding complete
            default =>
            in_array($currentRoute, ['verify-email', 'select-role'])
                ? redirect()->route('dashboard')
                : $next($request),
        };
    }
}
