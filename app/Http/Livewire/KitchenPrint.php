<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Order;

class KitchenPrint extends Component
{
    public Order $order;

    protected $listeners = [
        'echo:kitchenPrint,PrintKitchenEvent' => 'print'
    ];

    public function print(Order $order)
    {
        $this->order = $order;
    }

    public function render()
    {
        return view('livewire.kitchen-print')->layout('layouts.guest');
    }
}
