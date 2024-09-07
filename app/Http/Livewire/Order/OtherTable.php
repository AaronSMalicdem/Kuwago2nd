<?php

namespace App\Http\Livewire\Order;


use App\Http\Livewire\Order\Table\Orders;

class OtherTable extends Orders
{

    public function render()
    {
        return view('livewire.order.other-table');
    }
}
