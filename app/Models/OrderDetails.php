<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderDetails extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    protected $casts = [
        'side_dishes' => 'array'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function cancel()
    {
        return $this->morphMany(Cancel::class, 'cancellable');
    }

    public function dish()
    {
        return $this->belongsTo(Dish::class);
    }

    public function sideDishes()
    {
        return $this->hasMany(SideDish::class, 'order_details_id');
    }

    public function scopeDrinks($query)
    {
        return $query->whereHas('dish', function ($dish) {
            $dish->whereHas('category', function ($category) {
                $category->where('type', 'drinks');
            });
        });
    }

    public function isDrink()
    {
        return ($this->dish->category->type == "alcoholic" || $this->dish->category->type == "drinks");
    }

    public function isFood()
    {
        return $this->dish->category->type == "foods";
    }

    // public function discountItem()
    // {
    //     return $this->morphOne(DiscountedItem::class, 'discountable');
    // }

    public function getPrice()
    {
        return $this->attributes['price'] - $this->getDiscount();
    }

    // public function getDiscount()
    // {
    //     if ($this->discountItem()->exists()) {
    //         if ($this->discountItem->getDiscountType() === 'percent') {
    //             return ($this->attributes['price_per_piece'] * $this->discountItem->items * $this->discountItem->getDiscountValue() / 100);
    //         }

    //         if ($this->discountItem->getDiscountType() === 'fixed') {
    //             return ($this->discountItem->items * $this->discountItem->getDiscountValue());
    //         }
    //     }
    //     return 0;
    // }

    public function getPriceFormattedAttribute()
    {
        return "₱ " . number_format($this->price, 2, '.', ',');
    }
}
