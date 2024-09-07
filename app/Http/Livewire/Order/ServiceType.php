<?php

namespace App\Http\Livewire\Order;

use App\Models\Order;
use Livewire\Component;
use Livewire\WithPagination;

class ServiceType extends Component
{
    use WithPagination;

    public $message = '';
    public $search = '';
    public $unpaidSearch = '';

    protected $queryString = [
        'search' => ['except' => ''],
        'unpaidSearch' => ['except' => '']
    ];

    public function updating()
    {
        $this->resetPage();
    }

    protected $listeners = [
        'echo:newOrder,AnyOrderUpdatedEvent' => '$refresh',
    ];

    public function refreshComponent()
    {
        session()->flash('message', 'Page updated. Please refresh the page!');
    }

    public function render()
    {
        $orders = Order::with(['orderDetails'])->when($this->search, function ($query) {
            $query->where('full_name', 'like', "%" . $this->search . "%");
        })->where('checked_out', 0)->whereDate('created_at', now())->paginate(8);
        $unpaidOrders = Order::with(['orderDetails'])->when($this->unpaidSearch, function ($query) {
            $query->where('full_name', 'like', "%" . $this->unpaidSearch . "%");
        })->where('checked_out', 0)->whereDate('created_at', '<>', now())->paginate(8, ['*'], 'unpaidOrdersPage');

        return view('livewire.order.service-type', [
            'orders' => $orders,
            'unpaidOrders' => $unpaidOrders,
        ]);
    }
}
