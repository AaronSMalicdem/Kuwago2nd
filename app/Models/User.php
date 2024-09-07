<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'middle_name',
        'last_name',
        'email',
        'password',
        'role_id',
        'employee_no',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get the roles that owns the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function hasRole($role)
    {
        return $this->role->name == $role;
    }

    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->middle_name} {$this->last_name}";
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'waiter_id');
    }

    public function ordersBy()
    {

        $total = $this->orders->sum('total');

        return number_format($total, 2, '.', ',');
    }

    // public function runInBar()
    // {
    //     $total = $this->orders->map->orderDetails->flatten()->map(function($item) {
    //         if($item->dish->category->type == 'alcoholic'){
    //             return $item->price;
    //         }
    //     })->sum();

    //     return number_format($total, 2, '.', ',');
    // }

    public function runInKitchen()
    {
        $total = $this->orders->map->orderDetails->flatten()->map(function($item) {
            if($item->dish->category->type <> 'alcoholic'){
                return $item->price;
            }
        })->sum();

        return number_format($total, 2, '.', ',');
    }

    // public function getTip()
    // {
    //     $tip = $this->orders->map(function ($order) {
    //         return ['orderTip' => $order->serviceCharge()];
    //     })->sum('orderTip');
    //     return number_format($tip, 2, '.', ',');
    // }

    public function trashedOrders()
    {
        return $this->cancelled->where('cancellable_type', '=', 'App\Models\Order')->count();
        //return $this->orders->where('deleted_at', '!=', NULL)->count();
    }

    public function orderErrors()
    {
        // $orders =  $this->orders->where('deleted_at', '==', NULL);
        // $orderDetailsSum = $orders->map(function ($order) {
        //     return $order->orderDetails()->onlyTrashed()->count();
        // })->sum();
        // $customDetailSum = $orders->map(function ($order) {
        //     return $order->customOrderDetails()->onlyTrashed()->count();
        // })->sum();
        // return $orderDetailsSum + $customDetailSum;
        return $this->cancelled->where('cancellable_type', '<>', 'App\Models\Order')->count();;
    }

    // public function assignTables()
    // {
    //     return $this->belongsToMany(Table::class, 'table_waiter', 'waiter_id', 'table_id')->withPivot(['table_name']);
    // }

    public function cancelled()
    {
        return $this->hasMany(Cancel::class, 'waiter_id');
    }
}
