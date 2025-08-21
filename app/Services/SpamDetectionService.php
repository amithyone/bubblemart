<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SpamDetectionService
{
    /**
     * Check if registration request is spam
     * Now only checks for obvious spam patterns, relies on captcha for protection
     */
    public function isSpamRegistration(Request $request): bool
    {
        $checks = [
            $this->checkHoneypot($request),
            $this->checkDisposableEmail($request->input('email')),
            $this->checkSuspiciousPatterns($request),
            $this->checkUserAgent($request->userAgent()),
        ];

        return in_array(true, $checks);
    }

    /**
     * Check honeypot field
     */
    private function checkHoneypot(Request $request): bool
    {
        // Hidden field that should be empty
        $honeypot = $request->input('website');
        return !empty($honeypot);
    }

    /**
     * Check for disposable email domains
     */
    private function checkDisposableEmail(string $email): bool
    {
        $disposableDomains = [
            'tempmail.org', '10minutemail.com', 'guerrillamail.com',
            'mailinator.com', 'yopmail.com', 'temp-mail.org',
            'fakeinbox.com', 'sharklasers.com', 'getairmail.com',
            'throwaway.email', 'mailnesia.com', 'maildrop.cc',
            'tempr.email', 'spam4.me', 'bccto.me', 'chacuo.net'
        ];

        $emailDomain = strtolower(substr(strrchr($email, "@"), 1));
        return in_array($emailDomain, $disposableDomains);
    }

    /**
     * Check for suspicious patterns
     */
    private function checkSuspiciousPatterns(Request $request): bool
    {
        $name = $request->input('name');
        $phone = $request->input('phone');

        // Suspicious name patterns
        $suspiciousNames = [
            '/^(test|admin|user|guest|demo|temp|fake|spam)/i',
            '/^(a{3,}|b{3,}|c{3,})/i', // Repeated characters
            '/^[0-9]+$/', // Only numbers
        ];

        foreach ($suspiciousNames as $pattern) {
            if (preg_match($pattern, $name)) {
                return true;
            }
        }

        // Suspicious phone patterns
        $suspiciousPhones = [
            '/^(123|000|111|999)/',
            '/^(\d)\1{7,}$/', // Repeated digits
        ];

        foreach ($suspiciousPhones as $pattern) {
            if (preg_match($pattern, $phone)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Check user agent
     */
    private function checkUserAgent(?string $userAgent): bool
    {
        if (empty($userAgent)) {
            return true;
        }

        $suspiciousAgents = [
            'bot', 'crawler', 'spider', 'scraper',
            'curl', 'wget', 'python', 'java',
            'headless', 'phantom', 'selenium'
        ];

        $userAgentLower = strtolower($userAgent);
        foreach ($suspiciousAgents as $suspicious) {
            if (str_contains($userAgentLower, $suspicious)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Get spam score for registration
     */
    public function getSpamScore(Request $request): int
    {
        $score = 0;

        if ($this->checkDisposableEmail($request->input('email'))) {
            $score += 10;
        }

        if ($this->checkSuspiciousPatterns($request)) {
            $score += 5;
        }

        if ($this->checkUserAgent($request->userAgent())) {
            $score += 8;
        }

        return $score;
    }
} 