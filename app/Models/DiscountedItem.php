<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiscountedItem extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function discountable()
    {
        return $this->morphTo();
    }

    public function discountType()
    {
        return $this->belongsTo(Discount::class, 'discount_type');
    }

    public function getDiscountType()
    {
        return $this->discountType->type;
    }

    public function getDiscountValue()
    {
        return $this->discountType->value;
    }
}
