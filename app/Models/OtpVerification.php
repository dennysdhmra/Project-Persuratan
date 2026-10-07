<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OtpVerification extends Model
{
    use HasFactory;

    protected $fillable = [
        'email',
        'otp_code',
        'action',
        'payload',
        'expires_at',
        'attempts',
        'verified_at',
    ];

    protected function casts(): array
    {
        return [
            'payload' => 'array',
            'expires_at' => 'datetime',
            'verified_at' => 'datetime',
        ];
    }

    /**
     * Generate or renew an OTP for given email.
     */
    public static function createOtp(string $email, string $action = 'register', array $payload = [], int $expiryMinutes = 10): self
    {
        // Invalidate prior active OTPs for this email and action
        self::where('email', $email)
            ->where('action', $action)
            ->whereNull('verified_at')
            ->delete();

        $code = str_pad((string) random_int(100000, 999999), 6, '0', STR_PAD_LEFT);

        return self::create([
            'email' => $email,
            'otp_code' => $code,
            'action' => $action,
            'payload' => $payload,
            'expires_at' => Carbon::now()->addMinutes($expiryMinutes),
            'attempts' => 0,
        ]);
    }

    /**
     * Check if this OTP instance is valid and not expired.
     */
    public function isValid(string $inputCode): bool
    {
        if ($this->verified_at !== null) {
            return false;
        }

        if (Carbon::now()->isAfter($this->expires_at)) {
            return false;
        }

        if ($this->attempts >= 5) {
            return false;
        }

        return hash_equals($this->otp_code, trim($inputCode));
    }

    /**
     * Record an invalid attempt.
     */
    public function recordFailedAttempt(): void
    {
        $this->increment('attempts');
    }

    /**
     * Mark OTP as verified.
     */
    public function markAsVerified(): void
    {
        $this->update([
            'verified_at' => Carbon::now(),
        ]);
    }
}
