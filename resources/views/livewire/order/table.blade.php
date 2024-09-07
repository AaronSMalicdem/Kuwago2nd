<div>
    {{ $message }}
    <div class="w-full shadow-lg rounded-lg flex flex-col flex-grow h-64 justify-between" x-data>
        <div
            class="flex flex-row items-center justify-between py-2 px-3 {{ $hasOrder ? 'bg-green-800' : 'bg-gray-300' }} rounded-t-lg">
            <strong class="text-white">
                {{ Auth::user()->assignTables->find($table->id)->pivot->table_name ?? $table->name }} ({{ $table->pax }}
                pax)
            </strong>
            <div class="text-white">
                @if($hasOrder)
                    @can('manage')
                        <button
                            wire:click.prevent="$emitTo('order.modal.transfer-table', 'transferOrder', {{ $table->order()->id }})">
                            <i class="fa fa-exchange-alt"></i>
                        </button>
                    @endcan
                        <button onclick="event.preventDefault(); print({{ $table->order()->id  }})">
                            <i class="fa fa-print"></i>
                        </button>
                @endif
                <button wire:click.prevent="$emitTo('order.modal.edit-table', 'editTable', {{ $table->id }})">
                    <i class="fa fa-edit"></i>
                </button>
            </div>
        </div>
        <div class="px-2 h-full">
            <div class="flex h-full">
                <div class="w-64 p-2">
                    @if($hasOrder)

                    <div>
                        <a href="{{ route('orders.show', ['action' => 'dine_in', 'tableId' => $table->id, 'order' => $table->order()]) }}">
                            <ul class="list-unstyled text-xs">
                                <li>Order # {{ $table->order()->order_number }}</li>
                                <li>
                                    Amount: ₱ {{ number_format( $table->order()->totalPrice(), 2, '.', ',') }}
                                    <span class="line-through">
                                        {{ $order->enable_discount ? number_format(
                                        $table->order()->totalPriceWithoutDiscount(), 2, '.', ',') : '' }}
                                    </span>
                                </li>
                                <li>Pax: {{ $table->order()->pax }}</li>
                                <li>Served by: {{ $table->order()->waiter->full_name }}</li>
                            </ul>
                        </a>
                    </div>
                    @can('manage')
                        <livewire:order.modal.discount :order="$table->order()" key="discount-{{ $table->order()->id }}" />
                        <div class="flex flex-row mt-2 items-center space-x-2">
                            <button class="text-xs py-1 px-2 rounded-md text-white bg-green-500"
                                wire:click="$emitTo('order.modal.discount', '{{ "openDiscount.{$table->order()->id}" }}')">{{ __('Discount') }}</button>
                        </div>

                        <div class=" flex items-center mt-2">

                            <div class="text-xs">

                                <input type="checkbox" class="rounded" id="service_charge{{ $table->order()->id }}" value=1 {{ !$table->order()->enable_tip ? 'checked' : '' }}  wire:model="enableServiceCharge">
                                <label for="service_charge{{ $table->order()->id }}" class="text-gray-500" >Disable Service Charge</label>

                            </div>
                        </div>
                    @endcan
                    @else
                        <a href="{{ route('orders.create', ['action' => 'dine_in', 'tableId' => $table->id]) }}">
                            <span class="text-xs">
                                Click here to select this table
                            </span>
                        </a>
                    @endif
                </div>
                <div class="flex items-center w-8">
                    @if($hasOrder)
                    <div wire:loading>
                        <i class="fa fa-spin fa-spinner"></i>
                    </div>
                    <div wire:loading.remove>

                            <button type="button" class="w-5"
                            wire:click.prevent="$emitTo('auth.passcode', 'voidPasscode', {{ $table->order()->id }}, 1, 'order')">
                            <i class="fa fa-trash {{ Gate::check('manage') ? 'text-red-500' : 'text-gray-200' }}"></i>
                        </button>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="rounded-b-lg p-2 text-center text-sm">
            @if ($hasOrder)
            <div class="flex items-end">
                <div class="w-full">
                    <livewire:order.modal.billing-type :billingType="$table->order()->billing_type"
                        :order="$table->order()" key="billing-{{ $table->order()->id }}" />
                </div>
                <button type="button"
                    class="w-full {{ count($table->order()->orderReceipts) > 0 ? 'text-red-500' : 'text-gray-300' }} font-bold"
                    type="button" {{ count($table->order()->orderReceipts) > 0 ? '' : 'disabled' }}
                    wire:click.prevent="$emitTo('order.checkout', 'checkOut', {{ $table->order()->id }})">
                    Check out
                </button>
            </div>
            @endif
        </div>
    </div>

</div>

<script>
    function print(id){
        a = window.open('/print-bill/'+id, 'myWin', 'left=50, top=50, width=400, height=800');
        a.screenX = 0;
        a.screenY = 0;
        a.document.title = "Print";
        a.focus();
        setTimeout(() => {
            a.close();
        }, 1000);
    };
</script>
