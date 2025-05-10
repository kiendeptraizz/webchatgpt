<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Promotion extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'code',
        'description',
        'discount_type',
        'discount_value',
        'minimum_order',
        'maximum_discount',
        'is_active',
        'start_date',
        'end_date',
        'usage_limit',
        'used_count',
    ];

    /**
     * The attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'discount_value' => 'decimal:2',
            'minimum_order' => 'decimal:2',
            'maximum_discount' => 'decimal:2',
            'is_active' => 'boolean',
            'start_date' => 'datetime',
            'end_date' => 'datetime',
            'usage_limit' => 'integer',
            'used_count' => 'integer',
        ];
    }

    /**
     * Các gói dịch vụ được áp dụng khuyến mãi này.
     */
    public function packages(): BelongsToMany
    {
        return $this->belongsToMany(Package::class, 'package_promotion');
    }

    /**
     * Kiểm tra xem khuyến mãi có còn hiệu lực không.
     */
    public function isValid(): bool
    {
        $now = now();

        // Kiểm tra thời gian hiệu lực
        if ($now < $this->start_date || $now > $this->end_date) {
            return false;
        }

        // Kiểm tra trạng thái
        if (!$this->is_active) {
            return false;
        }

        // Kiểm tra giới hạn sử dụng
        if ($this->usage_limit !== null && $this->used_count >= $this->usage_limit) {
            return false;
        }

        return true;
    }

    /**
     * Tính toán giá trị giảm giá dựa trên giá gốc.
     */
    public function calculateDiscount(float $originalPrice): float
    {
        if ($originalPrice < $this->minimum_order) {
            return 0;
        }

        $discount = 0;

        if ($this->discount_type === 'percentage') {
            $discount = $originalPrice * ($this->discount_value / 100);

            // Áp dụng giới hạn giảm giá tối đa nếu có
            if ($this->maximum_discount !== null && $discount > $this->maximum_discount) {
                $discount = $this->maximum_discount;
            }
        } else { // fixed_amount
            $discount = $this->discount_value;

            // Đảm bảo giảm giá không vượt quá giá gốc
            if ($discount > $originalPrice) {
                $discount = $originalPrice;
            }
        }

        return $discount;
    }
}
