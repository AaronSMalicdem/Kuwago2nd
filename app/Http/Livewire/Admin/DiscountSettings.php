<?php

namespace App\Http\Livewire\Admin;

use App\Models\Discount;
use Livewire\Component;

class DiscountSettings extends Component
{

    public $name;
    public $value;
    public $type = "";

    public $isEditing;
    public $discount;

    protected $rules = [
        'name' => 'required',
        'value' => 'required',
        'type' => 'required|in:percent,fixed',
    ];

    public function updatedIsEditing($value)
    {
        if(!$this->isEditing){
            $this->reset();
        }
    }

    public function addDiscount()
    {
        $this->validate();

        Discount::create([
            'name' => $this->name,
            'value' => $this->value,
            'type' => $this->type,
        ]);

        $this->reset();
    }

    public function updateDiscount()
    {
        $this->validate();

        $this->discount->update([
            'name' => $this->name,
            'value' => $this->value,
            'type' => $this->type,
        ]);

        $this->reset();
    }

    public function editDiscount(Discount $discount)
    {
        $this->name = $discount->name;
        $this->value = $discount->value;
        $this->type = $discount->type;

        $this->isEditing = true;
        $this->discount = $discount;
    }

    public function deactiveDiscount(Discount $discount)
    {
        $discount->update(['status' => 0]);
    }

    public function activeDiscount(Discount $discount)
    {
        $discount->update(['status' => 1]);
    }

    public function render()
    {
        return view('livewire.admin.discount-settings', [
            'discounts' => Discount::all(),
        ]);
    }
}
