<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

class RegistrationRateLimit
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $key = $this->resolveRequestSignature($request);

        // Rate limit: 3 registrations per hour per IP
        if (RateLimiter::tooManyAttempts($key, 3)) {
            $seconds = RateLimiter::availableIn($key);
            
            return back()->withErrors([
                'email' => "Too many registration attempts. Please try again in {$seconds} seconds."
            ])->withInput();
        }

        // Rate limit: 1 registration per 5 minutes per IP
        $minuteKey = $key . ':minute';
        if (RateLimiter::tooManyAttempts($minuteKey, 1)) {
            $seconds = RateLimiter::availableIn($minuteKey);
            
            return back()->withErrors([
                'email' => "Please wait {$seconds} seconds before trying again."
            ])->withInput();
        }

        // Check for suspicious patterns
        if ($this->isSuspiciousRequest($request)) {
            return back()->withErrors([
                'email' => "Registration blocked due to suspicious activity."
            ])->withInput();
        }

        $response = $next($request);

        // Increment rate limiters
        RateLimiter::hit($key, 3600); // 1 hour
        RateLimiter::hit($minuteKey, 300); // 5 minutes

        return $response;
    }

    /**
     * Resolve request signature for rate limiting
     */
    private function resolveRequestSignature(Request $request): string
    {
        $ip = $request->ip();
        $userAgent = $request->userAgent();
        
        return sha1($ip . '|' . $userAgent . '|registration');
    }

    /**
     * Check for suspicious registration patterns
     */
    private function isSuspiciousRequest(Request $request): bool
    {
        $email = $request->input('email');
        $name = $request->input('name');
        $phone = $request->input('phone');

        // Check for disposable email domains
        $disposableDomains = [
            'tempmail.org', '10minutemail.com', 'guerrillamail.com',
            'mailinator.com', 'yopmail.com', 'temp-mail.org',
            'fakeinbox.com', 'sharklasers.com', 'getairmail.com'
        ];

        $emailDomain = strtolower(substr(strrchr($email, "@"), 1));
        if (in_array($emailDomain, $disposableDomains)) {
            return true;
        }

        // Check for suspicious patterns in name
        if (preg_match('/^(test|admin|user|guest|demo|temp|fake)/i', $name)) {
            return true;
        }

        // Check for suspicious phone patterns
        if (preg_match('/^(123|000|111|999)/', $phone)) {
            return true;
        }

        // Check for rapid submissions from same IP
        $ip = $request->ip();
        $recentRegistrations = Cache::get("recent_registrations_{$ip}", 0);
        
        if ($recentRegistrations > 5) {
            return true;
        }

        // Increment recent registrations counter
        Cache::put("recent_registrations_{$ip}", $recentRegistrations + 1, 3600);

        return false;
    }
}
