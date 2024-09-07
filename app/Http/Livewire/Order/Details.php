<?php

namespace App\Http\Livewire\Order;

use App\Models\Dish;
use App\Models\Order;
use Livewire\Component;
use App\Models\Category;

class Details extends Component
{
    public $action;
    public $table;
    public $categories;
    public $dishes;
    public $sideDishes = [];
    public $orderedDishes = [];
    public $selectedCategory = 1;
    public $totalPrice = 0;
    public $oldOrders = [];
    public $oldCustomOrders = [];
    public $order;
    public $isReviewing;

    public function getListeners()
    {
        return [
            'addToDish' => 'addCustomDish',
            'addSideDish' => 'addDish',
            'cancelReview' => 'setReview',
            "echo:updatedOrder.{$this->order->id},OrderUpdatedEvent" => '$refresh',
        ];
    }

    protected $rules = [
        'dishes.*.quantity' => 'required|numeric',
        'dishes.*.name' => 'required',
        'dishes.*.side' => 'nullable'
    ];

    public function mount(Order $order = null)
    {
        $this->order = $order;
        $this->isReviewing = false;
        $this->sideDishes = Dish::sideDish()->get();
        $this->categories = Category::with(['dishes'])->get();
        // $dishes = Category::with(['dishes'])->find(1)->dishes->sortBy('name');
        // $dishes = $this->categories->where('id', 1)->dishes->sortBy('name');
        $dishes = $this->categories->where('id', 1)->first()->dishes->sortBy('name');

        $this->dishes = $dishes->each(function ($dish) {
            $dish['quantity'] = 1;
        });

        if ($this->order->getAttributes()) {
            $this->oldOrders = $this->order->orderDetails;
            $this->oldCustomOrders = $this->order->customOrderDetails;
        }
    }

    public function setReview()
    {
        $this->isReviewing = false;
    }

    public function viewDishes($categoryId = null)
    {
        $this->dishes = [];

        if ($categoryId) {
            $this->selectedCategory = $categoryId;
            // $category = Category::with(['dishes'])->find($categoryId);
            $category = $this->categories->where('id', $categoryId)->first();
            $dishes = $category->dishes->sortBy('name');
            $this->dishes = $dishes->each(function ($dish) {
                $dish['quantity'] = 1;
            });
        }
    }

    public function incrementQuantity($index)
    {
        $this->dishes[$index]['quantity'] += 1;
    }

    public function decrementQuantity($index)
    {
        if ($this->dishes[$index]['quantity'] > 1)
            $this->dishes[$index]['quantity'] -= 1;
    }

    public function addDish(Dish $dish, $quantity, $note = null, $sides = null)
    {
        if (!$dish->status) return;

        $newDish = [];
        foreach ($this->orderedDishes as $i => $d) {
            if (array_key_exists('id', $d)) {
                if ( $d['id'] == $dish->id && $d['sides'] == null && ( $d['note'] == $note ) ) {
                    $d['quantity'] += $quantity;
                    $d['price'] = $d['quantity'] * $dish->price;
                    $d['price_per_piece'] = $dish->price;
                    $d['note'] = $note;
                    $newDish[$i] = $d;
                }
            }
        }
        if (count($newDish) > 0) {
            $this->orderedDishes = $newDish + $this->orderedDishes;
        } else {
            $this->orderedDishes[] = [
                'id' => $dish->id,
                'name' => $dish->name,
                'price' => $dish->price * $quantity,
                'price_per_piece' => $dish->price,
                'quantity' => $quantity,
                'note' => $note,
                'sides' => $sides != null ? Dish::select('id', 'name')->whereIn('id', $sides)->get()->toArray() : null,
            ];
        }

        $this->total();
    }

    public function addCustomDish($customDish)
    {
        if (!$customDish) return;

        $this->orderedDishes[] = [
            'name' => $customDish['name'],
            'price' => $customDish['price'] * $customDish['pcs'],
            'price_per_piece' => $customDish['price'],
            'desc' => $customDish['desc'],
            'quantity' => $customDish['pcs'],
            'type' => $customDish['type'],
        ];

        $this->total();
    }

    public function removeDish($index)
    {
        if($this->orderedDishes[$index]['quantity'] > 1) {
            $this->orderedDishes[$index]['quantity']--;
            $this->orderedDishes[$index]['price'] = $this->orderedDishes[$index]['quantity'] * $this->orderedDishes[$index]['price_per_piece'];
        }else{

            unset($this->orderedDishes[$index]);
            $this->orderedDishes = array_values($this->orderedDishes);
        }
        $this->total();
    }

    public function total()
    {
        $this->totalPrice = 0;
        foreach ($this->orderedDishes as $d) {
            $this->totalPrice += $d['price_per_piece'] * $d['quantity'];
        }
    }

    public function placeOrders()
    {
        $this->isReviewing = true;
        $this->emitTo('order.review', 'fillOrder', $this->orderedDishes);
    }

    public function render()
    {
        return view('livewire.order.details');
    }
}
