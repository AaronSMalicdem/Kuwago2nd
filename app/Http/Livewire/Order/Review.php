<?php

namespace App\Http\Livewire\Order;

use App\Http\Livewire\Modal;
use App\Models\Configuration;
use App\Events\OrderUpdatedEvent;
use App\Events\AnyOrderUpdatedEvent;
use App\Events\PrintKitchenEvent;
use DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Review extends Modal
{
    use AuthorizesRequests;

    public $config;
    public $order;
    public $table;
    public $orderDetails;
    public $totalPrice;
    public $pax;
    public $action;
    public $address;
    public $contact;

    protected $listeners = [
        'fillOrder' => 'fillOrder',
        'close' => 'close',
    ];

    public function mount()
    {
        $this->pax = $this->order->pax ?? '';
        $this->config = Configuration::get()->first();

    }

    protected $rules = [
        'orderDetails' => 'array|required',
        'orderDetails.*' => 'required',
    ];

    protected $messages = [
        'orderDetails.required' => 'You must have at least one order.',
    ];

    public function close()
    {
        $this->emitTo('order.details', 'cancelReview');
        $this->resetValidation();
        $this->toggleModal();
    }

    public function fillOrder($orderedDishes)
    {
        $this->isModalOpen = true;
        $this->orderDetails = $orderedDishes;
        $this->totalPrice = 0;
        foreach ($this->orderDetails as $d) {
            $this->totalPrice += $d['price'];
        }
    }

    public function updated()
    {
        $this->resetValidation();
        if ($this->pax < 1) {
            $this->addError('pax', 'You must enter a number of person');
        }
        if ($this->action === 'Delivery') {
            if ($this->address === '' || empty($this->address)) {
                $this->addError('address', 'You must enter address');
            }

            if ($this->contact === '' || empty($this->contact)) {
                $this->addError('contact', 'You must enter contact');
            }
        }
    }

    public function createOrder()
    {
        if ($this->action === 'Delivery') {
            if ($this->address === '' || empty($this->address)) {
                $this->addError('address', 'You must enter address');
                return;
            }

            if ($this->contact === '' || empty($this->contact)) {
                $this->addError('contact', 'You must enter contact');
                return;
            }
        }
        if ($this->pax < 1) {
            $this->addError('pax', 'You must enter a number of person');
            return;
        }
        $this->validate();

        DB::transaction(function () {

            if ($this->order->getAttributes() == null) {

                $this->order = Auth::user()->orders()->create([
                    'order_number' => $this->config->order_no,
                    'pax' => $this->pax,
                    'action' => $this->action,
                    'address' => $this->address,
                    'contact' => $this->contact,
                ]);
                if ($this->table) {
                    $this->order->tables()->sync($this->table);
                }
            } else {
                $this->order->update([
                    'pax' => $this->pax,
                ]);
            }

            $orderDetails = [];
            $customDishes = [];

            try {
                foreach ($this->orderDetails as $item) {
                    if (array_key_exists('id', $item)) {

                        $orderDetails = $this->order->orderDetails()->create( [
                            'dish_id' => $item['id'],
                            'pcs' => $item['quantity'],
                            'price' => $item['price'],
                            'price_per_piece' => $item['price_per_piece'],
                            'note' => $item['note'],
                            'printed' => 0,
                        ]);

                        if(array_key_exists('sides', $item) && $item['sides'] != null)
                        {
                            foreach($item['sides'] as $side)
                            {
                                $orderDetails->sideDishes()->create([
                                    'side_dish_id' => $side['id']
                                ]);
                            }
                        }

                    } else {
                        $customDishes[] = [
                            'name' => str_replace("(Custom)", "", $item['name']),
                            'pcs' => $item['quantity'],
                            'description' => $item['desc'],
                            'price' => $item['price'],
                            'price_per_piece' => $item['price_per_piece'],
                            'type' => $item['type'],
                            'printed' => 0,
                        ];
                    }
                }

                if (count($customDishes) > 0) {
                    $this->order->customOrderDetails()->createMany($customDishes);
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

        // return redirect()->to('/waiter-order');
    }



    public function render()
    {
        return view('livewire.order.review');
    }
}
