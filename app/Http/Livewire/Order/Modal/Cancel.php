<?php

namespace App\Http\Livewire\Order\Modal;

use App\Events\OrderUpdatedEvent;
use App\Http\Livewire\Modal;
use App\Models\Cancel as ModelsCancel;
use App\Models\CustomDish;
use App\Models\OrderDetails;

class Cancel extends Modal
{
    public $qty;
    public $item;
    public $dish;
    public $pcs;
    public $isCustom;

    protected $listeners = [
        'cancelDish' => 'openCancellationDish',
        'voidDish' => 'confirmVoid',
    ];

    protected $rules = [
        'qty' => 'required|numeric|min:0'
    ];

    public function updatedQty($value)
    {
        $this->resetErrorBag();

        $this->validate();
        if($value > $this->pcs)
        {
            $this->addError('pcs', 'Exceeding');
        }
    }

    public function openCancellationDish($dish, $isCustom)
    {
        $this->isCustom = $isCustom;
        if(!$isCustom)
        {
            $item = OrderDetails::findOrFail($dish);
            $this->dish = $item->dish->name;
            $this->pcs = $item->pcs;
        }else{
            $item = CustomDish::findOrFail($dish);
            $this->dish = $item->name;
            $this->pcs = $item->pcs;
        }

        $this->item = $item;
        $this->toggleModal();
    }

    public function voidDish()
    {
        if($this->qty > $this->pcs)
        {
            $this->addError('pcs', 'Exceeding');
            return;
        }
        $this->validate();

        $this->emitTo('auth.passcode', 'voidPasscode', $this->item->id, $this->isCustom, 'dish');
    }

    public function confirmVoid()
    {

        $this->item->decrement('pcs', $this->qty);
        $this->item->update([
            'price' => $this->item->pcs * $this->item->price_per_piece,
        ]);
        if($this->item->pcs == 0){
            $this->item->delete();
        }

        $this->item->cancel()->create([
            'waiter_id' => $this->item->order->waiter_id,
            'reason' => 'Dish removed',
        ]);

        event(new OrderUpdatedEvent($this->item->order));

        $this->close();
    }

    public function close()
    {
        $this->toggleModal();
        $this->reset();
        $this->resetErrorBag();
    }

    public function render()
    {
        return view('livewire.order.modal.cancel');
    }
}
