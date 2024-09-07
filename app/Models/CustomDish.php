<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomDish extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function cancel()
    {
        return $this->morphMany(Cancel::class, 'cancellable');
    }

    public function isDrink()
    {
        return $this->type == 'alcoholic' || $this->type == 'drinks';
    }

    public function isFood()
    {
        return $this->type == "foods";
    }

    public function discountItem()
    {
        return $this->morphOne(DiscountedItem::class, 'discountable');
    }


}
