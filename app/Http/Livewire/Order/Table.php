<?php

namespace App\Http\Livewire\Order;

use App\Http\Livewire\Order\Table\Orders;


class Table extends Orders
{

    public $table;
    public $hasOrder;

    public function render()
    {
        $this->order = $this->table->order();
        $this->hasOrder = $this->table->order() ? true : false;

        return view('livewire.order.table');
    }
}
