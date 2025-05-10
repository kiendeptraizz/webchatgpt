<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReferralCommission extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'referrer_id',
        'referred_id',
        'subscription_id',
        'amount',
        'status',
        'paid_at',
        'reward_type',
        'reward_days',
    ];

    /**
     * The attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
            'paid_at' => 'datetime',
            'reward_days' => 'integer',
        ];
    }

    /**
     * Get the referrer user.
     */
    public function referrer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'referrer_id');
    }

    /**
     * Get the referred user.
     */
    public function referred(): BelongsTo
    {
        return $this->belongsTo(User::class, 'referred_id');
    }

    /**
     * Get the subscription that generated this commission.
     */
    public function subscription(): BelongsTo
    {
        return $this->belongsTo(Subscription::class);
    }
}
