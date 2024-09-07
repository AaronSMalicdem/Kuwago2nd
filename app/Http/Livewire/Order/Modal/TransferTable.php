<?php

namespace App\Http\Livewire\Order\Modal;

use App\Events\AnyOrderUpdatedEvent;
use App\Models\User;
use App\Models\Order;
use App\Models\Table;
use App\Http\Livewire\Modal;
use App\Events\OrderUpdatedEvent;

class TransferTable extends Modal
{

    public $order;
    public $newTable;
    public $newServer;

    protected $rules = [
        'newServer' => 'required'
    ];

    protected $listeners = ['transferOrder' => 'transferOrder'];

    public function transferOrder($orderId)
    {
        $this->toggleModal();
        $this->order = Order::find($orderId);
    }

    public function confirmTransfer()
    {
        $this->validate();
        if($this->newTable)
        {
            $this->order->tables()->sync($this->newTable);
        }
        $this->order->update([
            'waiter_id' => $this->newServer,
        ]);

        event(new AnyOrderUpdatedEvent());

        $this->close();
    }

    public function close()
    {
        $this->toggleModal();
        $this->reset();
    }

    public function render()
    {
        $servers = User::when($this->order, function($query){
                $query->where('id', '!=', $this->order->waiter_id);
            })->where(function($query){
                $query->whereHas('role', function ($role) {
                    $role->where('name', 'waiter');
                    // })->whereHas('assignTables', function($query){
                    //     $query->where('id', $this->newTable);
                    // });
                });
            })->orWhereHas('role', function($role){
                $role->where('name', 'operation');
            })
            ->get();

        $tables = Table::all();

        return view('livewire.order.modal.transfer-table',[
            'tables' => $tables,
            'servers' => $servers,
        ]);
    }
}
