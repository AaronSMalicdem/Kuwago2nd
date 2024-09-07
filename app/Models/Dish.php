<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Dish extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $appends = [
        'price_formatted'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function orderDetails()
    {
        return $this->hasMany(OrderDetails::class);
    }

    //for reporting purposes
    public function getTotalSales()
    {
        return $this->orderDetails->sum('price');
    }

    public function getTotalDiscount()
    {
        return $this->orderDetails->sum(function ($detail) {
            return $detail->orig_price ?? $detail->price;
        }) - $this->getTotalSales();
    }

    public function scopeActive($query)
    {
        return $query->where('status', '1');
    }

    public function getPriceFormattedAttribute()
    {
        return "₱ " . number_format($this->price, 2, '.', ',');
    }
}
