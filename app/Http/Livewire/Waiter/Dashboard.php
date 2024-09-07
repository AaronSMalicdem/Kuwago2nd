<?php

namespace App\Http\Livewire\Waiter;

use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class Dashboard extends Component
{
    use WithPagination;

    public $date;

    //Order
    public $total;
    public $totalCash;
    public $totalGCash;

    //LateOrder
    public $lateTotal;
    public $lateTotalCash;
    public $lateTotalGCash;

    public function mount()
    {
        $this->date = now()->toDateString();
        $this->action = 'all';
    }

    public function nextDate()
    {
        $date = Carbon::parse($this->date);
        $date->addDay();
        $this->date = $date->toDateString();
        $this->resetPage();
    }

    public function prevDate()
    {
        $date = Carbon::parse($this->date);
        $date->subDay();
        $this->date = $date->toDateString();
        $this->resetPage();
    }

    public function render()
    {
        $orders = Auth::user()->orders()
            ->whereDate('created_at', $this->date);

        $lateOrders = Auth::user()->orders()
            ->whereDate('created_at', '<>', $this->date)
            ->whereDate('paid_on', $this->date);

        $this->total = (clone $orders)->sum('total');
        $this->lateTotal = (clone $lateOrders)->sum('total');

        $paidOrder = (clone $orders)->where('paid_on', '<>', null);
        $latePaid = (clone $lateOrders);

        $this->totalCash = $paidOrder->get()->sum(function ($order) {
            if($order->payment_type == 'cash') return $order->total;
        });

        $this->totalGCash = $paidOrder->get()->sum(function ($order) {
            if($order->payment_type == 'gcash') return $order->total;
        });

        $this->lateTotalCash = $latePaid->get()->sum(function ($order) {
            if($order->payment_type == 'cash') return $order->total;
        });

        $this->lateTotalGCash = $latePaid->get()->sum(function ($order) {
            if($order->payment_type == 'gcash') return $order->total;
        });

        $orders = $orders->paginate(15);
        $lateOrders = $lateOrders->paginate(15);

        return view('livewire.waiter.dashboard', [
            'orders' => $orders,
            'lateOrders' => $lateOrders,
        ]);
    }
}
