<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SideDish extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function order()
    {
        return $this->belongsTo(OrderDetails::class, 'order_details_id');
    }

    public function dish()
    {
        return $this->belongsTo(Dish::class, 'side_dish_id');
    }
}
