<?php

namespace App\Http\Livewire\Order;

use App\Models\Order;
use App\Models\Table;
use Livewire\Component;
use App\Http\Livewire\Modal;
use App\Models\OrderReceipt;
use App\Models\Configuration;
use App\Events\OrderUpdatedEvent;
use Illuminate\Support\Facades\DB;
use App\Events\AnyOrderUpdatedEvent;
use Illuminate\Support\Facades\Auth;

class Checkout extends Modal
{
    public $orderDetails = [];
    public $orderNumber;
    public $receiptNumber;
    public $order;

    public $totalPrice;

    public $cash;
    public $change;
    public $paymentType;
    public $refNo;

    public $config;
    public $receiptName;

    protected $listeners = [
        'checkOut' => 'checkOut',
        'close' => 'close',
    ];

    public function mount()
    {
        $this->config = Configuration::first();
    }

    public function updatedEnableServiceCharge()
    {
        $this->computeServiceCharge();
    }

    public function checkOut(Order $order)
    {
        $this->toggleModal();

        $this->order = $order;
        $this->orderNumber = $order->order_number;
        $this->receiptName = '';
        $this->paymentType = $order->payment_type;
        $this->cash = $order->cash;
        $this->change = $order->change;
        $this->refNo = null;

        foreach ($order->orderDetails as $item) {

            $this->orderDetails[] = [
                'name' => $item->dish->name,
                'quantity' => $item->pcs,
                'price' => $item->price,
            ];
        }


        $this->totalPrice = $order->totalPriceWithoutDiscount();

    }

    public function close()
    {
        $this->toggleModal();
        $this->reset(['cash', 'change', 'orderDetails']);
    }


    public function updatingRefNo($value)
    {
        $this->resetErrorBag('refNo');
    }


    public function confirmCheckOut()
    {

        if(strlen($this->cash) >= 10)
        {
            $this->addError('cash', 'Max length exceeded. Maximum: 10 digits');
            return;
        }

        if ($this->totalPrice > $this->cash) {
            $this->addError('cash', 'You do not have enough cash');
            return;
        }

        DB::transaction(function () {

            $this->order->update([
                'checked_out' => true,
                'total' => $this->totalPrice,
                'cash' => $this->cash,
                'change' => $this->change,
                'payment_type' => $this->paymentType,
                'paid_on' => now(),
            ]);

            $this->dispatchBrowserEvent('printPO', ['orderId' => $this->order->id]);

            // event(new AnyOrderUpdatedEvent());
            $this->close();
        });


    }

    public function render()
    {
        return view('livewire.order.checkout');
    }
}
