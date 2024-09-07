<div class="h-80">
    <div class="border border-gray-300 rounded-lg p-1 flex flex-col justify-between flex-grow" x-data>

        <div class="flex justify-between items-center">

            <div>Order # {{ $order->order_number }}</div>
            <div class="flex">
                <button onclick="event.preventDefault(); print({{ $order->id }})">
                    <i class="fa fa-print"></i>
                </button>
                @if (!empty($order))
                    <div wire:loading>
                        <i class="fa fa-spin fa-spinner"></i>
                    </div>
                    <div wire:loading.remove>
                        <button type="button" class="w-5"
                            wire:click.prevent="$emitTo('auth.passcode', 'voidPasscode', {{ $order->id }}, 1, 'order')">
                            <i class="fa fa-trash {{ Gate::check('manage') ? 'text-red-500' : 'text-gray-200' }}"></i>
                        </button>
                    </div>
                @endif
            </div>

        </div>
        <hr class="bg-gray-300 -mx-1">
        <div class="text-xs text-right">
            {{ $order->created_at->format('F d, Y h:i a') }}
        </div>

        <div class="grow text-sm px-2">
            {{-- <a href="{{ route('orders.show', [  'order' => $order]) }}"> --}}

            <div>Name: {{ $order->full_name }}</div>
            <div>
                Amount: ₱ {{ number_format($order->totalPriceWithoutDiscount(), 2, '.', ',') }}
                <span
                    class="italic {{ $order->cash ? 'text-green-600' : 'text-red-500' }}">{{ $order->cash ? 'Paid' : 'Not Paid' }}</span>
            </div>
            @if ($order->care_off)
                <span class="text-xs italic">
                    Care off: {{ $order->by }}
                </span>
            @endif
            Orders:
            <ul
                class="list-disc list-inside h-40 overflow-y-auto scrollbar-thin scrollbar-track-white scrollbar-thumb-blue-400 border-t px-1">
                @foreach ($order->orderDetails as $details)
                    <li>
                        {{ $details->dish->name }} ({{ $details->dish->properties }}) - {{ $details->pcs }} pc/s
                    </li>
                @endforeach
            </ul>
            {{-- </a> --}}

        </div>


        <hr class="bg-gray-300 -mx-1">
        <div class="rounded-b-lg text-center text-sm font-bold">

            <button class="w-full text-red-500 font-bold" type="button"
                x-on:click="window.livewire.emitTo('order.checkout', 'checkOut', {{ $order->id }})">
                Done
            </button>

        </div>

    </div>
</div>

<script>
    function print(id) {
        a = window.open('/print-po/'+id, 'myWin', 'left=50, top=50, width=400, height=800');
        // a = window.open('/print-bill/' + id, 'myWin', 'left=50, top=50, width=400, height=800');
        a.screenX = 0;
        a.screenY = 0;
        a.document.title = "Print";
        a.focus();
        setTimeout(() => {
            a.close();
        }, 1000);
    };
</script>
