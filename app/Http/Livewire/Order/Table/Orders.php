<?php

namespace App\Http\Livewire\Order\Table;

use App\Events\AnyOrderUpdatedEvent;
use App\Events\OrderUpdatedEvent;
use App\Models\Order;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class Orders extends Component
{
    use AuthorizesRequests;

    public $message = '';
    public $enableDiscount;
    public $enableServiceCharge;
    public $discountType;
    public $discount;
    public $action;
    public $order;

    public function getListeners()
    {
        $listeners = [

        ];
        if($this->order) {

            $listeners["voidOrder.{$this->order->id}"] = 'void';
        }
        return $listeners;
    }

    public function void($itemId, $isCustom)
    {
        $this->authorize('manage');

        $item = Order::find($itemId);
        if ($item == null) return;

        $item->cancel()->create([
            'waiter_id' => $item->waiter_id,
            'reason' => 'Order voided',
        ]);

        $item->orderDetails()->delete();
        $item->delete();

        //
    }


}
