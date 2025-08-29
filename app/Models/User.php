<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Fortify\TwoFactorAuthenticatable;

class User extends Authenticatable implements MustVerifyEmail

{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_secret',
        'two_factor_recovery_codes'
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    public function accounts()
    {
        return $this->hasMany(Account::class); // both fiat & crypto
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function investments()
    {
        return $this->hasMany(Investment::class);
    }

    public function trades()
    {
        return $this->hasMany(Trade::class);
    }

    public function kycDocuments()
    {
        return $this->hasMany(KycDocument::class);
    }

    public function copyTraders()
    {
        return $this->hasMany(CopyTrader::class, 'follower_id');
    }

    public function activityLogs()
    {
        return $this->hasMany(ActivityLog::class);
    }

    public function notifications()
{
    return $this->morphMany(\Illuminate\Notifications\DatabaseNotification::class, 'notifiable');
}


public function cryptoAccounts()
    {
        return $this->hasMany(Account::class)->where('type', 'crypto')->where('status', 'active');
    }

    // Get only fiat accounts
    public function fiatAccounts()
    {
        return $this->hasMany(Account::class)->where('type', 'fiat')->where('status', 'active');
    }

    // Get total crypto portfolio value (you'd need to implement price fetching)
    public function getTotalCryptoValueAttribute()
    {
        return $this->cryptoAccounts->sum('balance');
    }

    // Get active crypto wallets count
    public function getActiveCryptoWalletsCountAttribute()
    {
        return $this->cryptoAccounts()->count();
    }
}
