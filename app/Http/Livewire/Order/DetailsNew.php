<?php

namespace App\Http\Livewire\Order;

use App\Models\Dish;
use App\Models\Order;
use Livewire\Component;
use App\Models\Category;
use App\Models\Configuration;
use App\Events\PrintKitchenEvent;
use Illuminate\Support\Facades\DB;
use App\Events\AnyOrderUpdatedEvent;
use Illuminate\Support\Facades\Auth;

class DetailsNew extends Component
{

    public $categories;
    public $dishes;
    public $orderedDishes = [];
    public $selectedCategory = 1;
    public $paymentType = 'cash';
    public $totalPrice = 0;
    public $cash = null;
    public $change = 0;
    public $care_off = false;
    public $by = '';

    public $oldOrders = [];
    public $order;

    public $isReviewing;
    public $fullName = '';

    public $config;

    protected $listeners = [
        'createOrder'
    ];

    public function mount(Order $order = null)
    {
        $this->config = Configuration::get()->first();
        $this->order = $order;
        $this->isReviewing = false;
        $this->categories = Category::where('status', 1)->get();
        $dishes = Dish::orderBy('name')->where('status', 1)->get();
        $this->dishes = $dishes->each(function ($dish) {
            $dish['quantity'] = 1;
        })->toArray();

        // if ($this->order->getAttributes()) {
        //     $this->oldOrders = $this->order->orderDetails->load(['dish']);
        //     $this->pax = $this->order->pax;
        // }
    }

    public function createOrder()
    {

        DB::transaction(function () {

            if ($this->order->getAttributes() == null) {

                $this->order = Auth::user()->orders()->create([
                    'order_number' => $this->config->order_no,
                    'full_name' => $this->fullName,
                    'payment_type' => $this->paymentType,
                    'total' => $this->totalPrice,
                    'cash' => $this->cash != '' ? $this->cash : null,
                    'change' => $this->change,
                    'care_off' => $this->care_off,
                    'by' => $this->care_off ? $this->by : '',
                ]);
            } else {
                $this->order->update([
                    'full_name' => $this->fullName,
                ]);
            }

            try {
                foreach ($this->orderedDishes as $item) {

                    if (isset($item['new_price'])) {
                        $orig_price = $item['price'];
                        $price = $item['new_price'];
                    } else {
                        $price = $item['price'];
                    }

                    $this->order->orderDetails()->create([
                        'dish_id' => $item['id'],
                        'pcs' => $item['quantity'],
                        'price' => $price * $item['quantity'],
                        'price_per_piece' => $price,
                        'note' => $item['note'],
                        'printed' => 0,
                        'discounted' => $item['enable_discount'] ?? false,
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
        return view('livewire.order.details-new');
    }
}
