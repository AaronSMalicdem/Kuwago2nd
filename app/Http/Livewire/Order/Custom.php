<?php

namespace App\Http\Livewire\Order;

use App\Http\Livewire\Modal;

class Custom extends Modal
{
    public $customDish;
    public $customDescription;
    public $customPrice;
    public $customPcs;
    public $customType = null;

    protected $listeners = [
        'addCustomDish' => 'addCustomDish'
    ];

    protected $rules = [
        'customDish' => 'required',
        'customDescription' => 'required',
        'customPrice' => 'required',
        'customPcs' => 'required',
        'customType' => 'required|in:foods,drinks,alcoholic',
    ];

    public function addCustomDish()
    {
        $this->reset();
        $this->toggleModal();
    }

    public function addToDish()
    {
        $this->validate();
        $customDish = [
            'name' => $this->customDish . " (Custom)",
            'desc' => $this->customDescription,
            'price' => $this->customPrice,
            'type' => $this->customType,
            'pcs' => $this->customPcs,
        ];

        $this->emitTo('order.details', 'addToDish', $customDish);

        $this->toggleModal();
    }

    public function close()
    {

        $this->resetValidation();
        $this->toggleModal();

    }

    public function render()
    {
        return view('livewire.order.custom');
    }
}
