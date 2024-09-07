<?php

namespace App\Http\Livewire\Order\Modal;

use App\Models\Order;
use App\Http\Livewire\Modal;
use App\Events\OrderUpdatedEvent;
use App\Models\Discount as DiscountModel;
use App\Models\DiscountedItem;
use App\Models\OrderDetails;
use Exception;

class Discount extends Modal
{
    public Order $order;

    public $enableDiscount;
    public $discountType;
    public $discount;
    public $discountDescription;
    public $allDiscounts;
    public $discounts = [];

    public $discountSettings;

    protected $rules = [
        'discounts.*.*.items' => 'nullable',
        'discounts.*.*.discountId' => 'nullable',
        'discounts.*.*.discount_details' => 'nullable',
    ];

    public function mount(Order $order)
    {
        $this->order = $order;
        $this->allDiscounts = DiscountModel::orderBy('name')->get();
    }

    public function getListeners()
    {
        return [
            "openDiscount.{$this->order->id}" => 'openDiscount',
            'echo:newOrder,AnyOrderUpdatedEvent' => '$refresh',
        ];
    }

    public function openDiscount()
    {

        $this->enableDiscount = $this->order->enable_discount;

        if($this->enableDiscount)
        {
            $this->discountSettings = $this->order->discount_settings;

            if($this->order->discount_settings == 'whole')
            {

                $this->discountType = $this->order->discount_type;
                $this->discount = $this->order->discount;
                $this->discountDescription = $this->order->discount_ref;
            }

            if($this->order->discount_settings == 'per_item')
            {
                foreach($this->order->orderDetails as $d)
                {

                    if($d->discountItem()->exists())
                    {

                        $this->discounts[$d->id]['def']['items'] = $d->discountItem->items;
                        $this->discounts[$d->id]['def']['discountId'] = $d->discountItem->discount_type;
                        $this->discounts[$d->id]['def']['discount_details'] = $d->discountItem->discount_details;
                    }

                }

                foreach($this->order->customOrderDetails as $c)
                {
                    if($c->discountItem()->exists())
                    {
                        $this->discounts[$c->id]['custom']['items'] = $c->discountItem->items;
                        $this->discounts[$c->id]['custom']['discountId'] = $c->discountItem->discount_type;
                        $this->discounts[$c->id]['custom']['discount_details'] = $c->discountItem->discount_details;
                    }

                }
            }
        }

        $this->toggleModal();

    }

    public function saveDiscount()
    {

        try{

            if($this->discountSettings == 'whole')
            {
                $this->order->update([
                    'enable_discount' => $this->enableDiscount ?? false,
                    'discount_type' => $this->enableDiscount ? $this->discountType : 'percent',
                    'discount' => $this->enableDiscount ? $this->discount : null,
                    'discount_ref' => $this->enableDiscount ? $this->discountDescription : null,
                    'discount_settings' => $this->discountSettings,
                ]);

            }

            if($this->discountSettings == 'per_item')
            {
                $this->order->update([
                    'enable_discount' => $this->enableDiscount ?? false,
                    'discount_settings' => $this->discountSettings,
                ]);

                foreach($this->order->orderDetails as $d)
                {
                    if(isset($this->discounts[$d->id]['def']))
                    {
                        if($this->discounts[$d->id]['def']['items'] > $d->pcs)
                            return $this->addError('pcs', 'Item exceeded!');
                        $d->discountItem()->updateOrCreate(
                            ['discountable_id' => $d->id],
                            [
                            'discount_type' => $this->discounts[$d->id]['def']['discountId'],
                            'items' => $this->discounts[$d->id]['def']['items'],
                            'discount_details' => $this->discounts[$d->id]['def']['discount_details'],
                        ]
                    );
                    }
                }

                foreach($this->order->customOrderDetails() as $c)
                {
                    if(isset($this->discounts[$c->id]['custom']))
                    {
                        if($this->discounts[$c->id]['custom']['items'] > $c->pcs)
                            return $this->addError('pcs', 'Item exceeded!');
                        $c->discountItem()->updateOrCreate(
                            ['discountable_id' => $c->id],
                            [
                            'discount_type' => $this->discounts[$c->id]['custom']['discountId'],
                            'items' => $this->discounts[$c->id]['custom']['items'],
                            'discount_details' => $this->discounts[$c->id]['custom']['discount_details'],
                        ]
                    );
                    }
                }
            }

            event(new OrderUpdatedEvent($this->order));

            $this->close();
        }catch (Exception $e)
        {
            dd($e->getMessage());
        }

    }

    public function resetDiscount($id)
    {
        unset($this->discounts[$id]);
    }

    public function deleteDiscount($id)
    {
        $oDetail = OrderDetails::find($id);
        $oDetail->discountItem()->delete();

        unset($this->discounts[$id]);
        event(new OrderUpdatedEvent($this->order));
    }

    public function close()
    {
        $this->discountSettings = '';
        $this->toggleModal();
    }

    public function render()
    {
        return view('livewire.order.modal.discount');
    }
}
