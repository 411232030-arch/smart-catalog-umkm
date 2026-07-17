<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;

class AuthSecurityService
{
    const LOGIN_ATTEMPT_LIMIT = 5;
    const LOGIN_ATTEMPT_DECAY_MINUTES = 15;

    /**
     * Check if user can attempt login
     */
    public function canAttemptLogin(string $email): bool
    {
        $key = $this->getLimitKey($email);
        $attemptKey = "login_attempt:{$key}";

        return RateLimiter::remaining($attemptKey, self::LOGIN_ATTEMPT_LIMIT) > 0;
    }

    /**
     * Record failed login attempt
     */
    public function recordFailedAttempt(string $email): void
    {
        $key = $this->getLimitKey($email);
        $attemptKey = "login_attempt:{$key}";

        RateLimiter::hit($attemptKey, self::LOGIN_ATTEMPT_DECAY_MINUTES * 60);
    }

    /**
     * Get remaining attempts
     */
    public function getRemainingAttempts(string $email): int
    {
        $key = $this->getLimitKey($email);
        $attemptKey = "login_attempt:{$key}";

        return RateLimiter::remaining($attemptKey, self::LOGIN_ATTEMPT_LIMIT);
    }

    /**
     * Clear login attempts
     */
    public function clearAttempts(string $email): void
    {
        $key = $this->getLimitKey($email);
        $attemptKey = "login_attempt:{$key}";

        RateLimiter::clear($attemptKey);
    }

    /**
     * Get throttle key
     */
    private function getLimitKey(string $email): string
    {
        return Str::lower($email) . '|' . request()->ip();
    }

    /**
     * Generate login session token
     */
    public function generateSessionToken(): string
    {
        return Str::random(40);
    }

    /**
     * Verify user credentials with enhanced security
     */
    public function verifyCredentials(string $email, string $password): ?User
    {
        $user = User::where('email', $email)->first();

        if (!$user) {
            return null;
        }

        if (!\Hash::check($password, $user->password)) {
            return null;
        }

        return $user;
    }
}
