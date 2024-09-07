<?php

namespace App\Http\Livewire\Order\Modal;

use App\Models\Dish;
use App\Models\Category;
use App\Http\Livewire\Modal;

class AddOn extends Modal
{

    public $addOns = [];
    public $note;
    public $sideDish;
    public $dish;
    public $quantity;

    protected $listeners = [
        'addOn' => 'addOn'
    ];


    public function updateSideDish($index)
    {
        if(!$this->sideDish[$index]){
            unset($this->sideDish[$index]);
        }
    }

    public function addOn(Dish $dish, $quantity)
    {
        $this->addOns = Dish::sideDish()->active()->get();
        $this->sideDish = [];

        if (!$dish->status) return;
        $this->toggleModal();
        $this->dish = $dish;
        $this->quantity = $quantity;
    }

    public function addToOrder()
    {
        if($this->dish->add_on)
        {
            $this->validate(
                ['sideDish' => 'required|array|size:2',],
                ['sideDish.required' => 'Please choose two side dishes']
            );
        }

        $this->emitTo('order.details', 'addSideDish', $this->dish, $this->quantity, $this->note, $this->sideDish);
        $this->reset('sideDish', 'dish', 'quantity', 'note');
        $this->close();
    }

    public function close()
    {
        $this->resetValidation();
        $this->toggleModal();
    }

    public function render()
    {
        return view('livewire.order.modal.add-on');
    }
}
