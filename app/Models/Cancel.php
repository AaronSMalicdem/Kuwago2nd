<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cancel extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function waiter()
    {
        return $this->belongsTo(User::class, 'waiter_id');
    }

    public function cancellable()
    {
        return $this->morphTo();
    }
}
