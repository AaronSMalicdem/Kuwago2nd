<?php

namespace App\Http\Livewire\Order;

use App\Models\Dish;
use Livewire\Component;
use App\Models\Category;
use App\Models\Configuration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class OrderNow extends Component
{
    public $order;

    public $categories;
    public $dishes;
    public $orderedDishes;
    public $total;
    public $fullName;
    public $careOff;
    public $by;
    public $payment;
    public $paymentType;
    public $change;

    public $config;

    protected $listeners = [
        'createOrder'
    ];

    public function mount()
    {
        $this->config = Configuration::get()->first();
        $this->categories = Category::with(['dishes'])->where('status', 1)->get()->toArray();
        $this->dishes = Dish::with(['category'])->where('status', 1)->orderBy('name')->get()->map(function ($dish) {
            $dish['quantity'] = 1;
            return $dish;
        })->toArray();

        $this->orderedDishes = [];
        $this->total = 0;
    }

    public function createOrder()
    {
        // dd($this->orderedDish);

        DB::transaction(function () {

            $this->order = Auth::user()->orders()->create([
                'order_number' => $this->config->order_no,
                'full_name' => $this->fullName,
                'payment_type' => $this->paymentType,
                'total' => $this->total,
                'cash' => $this->payment != '' ? $this->payment : null,
                'change' => $this->change,
                'care_off' => $this->careOff ?? false,
                'by' => $this->careOff ? $this->by : '',
            ]);


            try {
                foreach ($this->orderedDishes as $item) {

                    if (isset($item['origPrice'])) {
                        $orig_price = $item['origPrice'];
                    }
                    $price = $item['price'];

                    $this->order->orderDetails()->create([
                        'dish_id' => $item['id'],
                        'pcs' => $item['quantity'],
                        'price' => $price * $item['quantity'],
                        'price_per_piece' => $price,
                        'note' => $item['note'] ?? null,
                        'printed' => 0,
                        'discount' => $item['discount'] ?? null,
                        'discount_type' => $item['discountType'] ?? null,
                        'orig_price' => $orig_price ?? null
                    ]);
                }

                $this->config->increment('order_no');
                DB::commit();
            } catch (\Exception $e) {
                dd($e->getMessage());
                DB::rollBack();
            }
        });

        // event(new AnyOrderUpdatedEvent());
        // event(new PrintKitchenEvent($this->order));
        $this->dispatchBrowserEvent('printOrder', ['orderId' => $this->order->id]);
    }

    public function render()
    {
        return view('livewire.order.order-now');
    }
}
