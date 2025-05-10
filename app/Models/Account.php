<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use \Illuminate\Database\Eloquent\Factories\HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
        'password',
        'cost_price',
        'account_type',
        'description',
        'is_active',
        'max_users',
        'current_users',
        'last_used_at',
        'start_date',
        'end_date',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'max_users' => 'integer',
            'current_users' => 'integer',
            'cost_price' => 'decimal:2',
            'last_used_at' => 'datetime',
            'start_date' => 'date',
            'end_date' => 'date',
        ];
    }

    /**
     * Get the subscriptions associated with this account.
     */
    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    /**
     * Get the users using this account through subscriptions.
     */
    public function users()
    {
        return $this->hasManyThrough(User::class, Subscription::class, 'account_id', 'id', 'id', 'user_id');
    }
}
