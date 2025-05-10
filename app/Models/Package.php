<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Package extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
        'price',
        'max_users',
        'features',
        'category_id',
        'category',
        'category_group',
        'is_shared',
        'is_combo',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'max_users' => 'integer',
            'features' => 'array',
            'is_shared' => 'boolean',
            'is_combo' => 'boolean',
        ];
    }

    /**
     * Get the subscriptions for the package.
     */
    public function subscriptions(): HasMany
    {
        return $this->hasMany(Subscription::class);
    }

    /**
     * Get the category that owns the package.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Các khuyến mãi áp dụng cho gói dịch vụ này.
     */
    public function promotions(): BelongsToMany
    {
        return $this->belongsToMany(Promotion::class, 'package_promotion');
    }

    /**
     * Lấy khuyến mãi đang hoạt động cho gói dịch vụ này.
     */
    public function getActivePromotion()
    {
        return $this->promotions()
            ->where('is_active', true)
            ->where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->orderBy('discount_value', 'desc')
            ->first();
    }

    /**
     * Tính giá sau khuyến mãi.
     */
    public function getDiscountedPrice(): float
    {
        $promotion = $this->getActivePromotion();

        if (!$promotion) {
            return (float) $this->price;
        }

        $discount = $promotion->calculateDiscount((float) $this->price);
        return max(0, (float) $this->price - $discount);
    }
}
