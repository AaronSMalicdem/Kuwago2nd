<div>
    @if ($isModalOpen)
        <!-- This example requires Tailwind CSS v2.0+ -->
        <div class="z-40 inset-0 fixed" aria-labelledby="modal-title" role="dialog" aria-modal="true" x-data>
            <div
                class="flex items-start justify-center h-screen pt-4 px-4 text-center sm:block sm:p-0 overflow-y-auto scrollbar-thin">
                <!--
            Background overlay, show/hide based on modal state.

            Entering: "ease-out duration-300"
              From: "opacity-0"
              To: "opacity-100"
            Leaving: "ease-in duration-200"
              From: "opacity-100"
              To: "opacity-0"
          -->
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

                <!-- This element is to trick the browser into centering the modal contents. -->
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <!--
            Modal panel, show/hide based on modal state.

            Entering: "ease-out duration-300"
              From: "opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
              To: "opacity-100 translate-y-0 sm:scale-100"
            Leaving: "ease-in duration-200"
              From: "opacity-100 translate-y-0 sm:scale-100"
              To: "opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
          -->
                <div x-data="checkout()" x-init="init()"
                    class="inline-block bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all w-full max-w-xl">
                    <div class="flex flex-col justify-between h-screen">
                        <div class="flex-shrink flex bg-white py-3">
                            <div class="flex-shrink-0 flex flex-col items-start justify-center px-5">
                                <!-- Heroicon name: outline/exclamation -->
                                <div>
                                    {{ $table->name ?? '' }}
                                </div>
                                <div>
                                    Order # {{ $orderNumber }}
                                </div>
                            </div>
                        </div>

                        <div class="flex flex-grow overflow-y-auto border p-1.5">
                            <div class="w-full">
                                @foreach ($orderDetails as $i => $item)
                                    <div class="flex justify-between mb-1 text-sm w-full px-3">
                                        <div class="flex flex-col w-52">
                                            <div class="flex flex-col">
                                                <span>
                                                    {{ $item['name'] }}
                                                </span>
                                                <span class="text-xs">
                                                    {{ isset($item['side_dish'])
                                                        ? 'with
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    ' .
                                                            $item['side_dish']
                                                        : '' }}
                                                </span>
                                            </div>
                                            <div>
                                                X{{ $item['quantity'] }}
                                            </div>
                                        </div>
                                        <div class="flex items-end">
                                            ₱ {{ number_format($item['price'], 2, '.', ',') }}
                                        </div>
                                    </div>
                                @endforeach

                            </div>
                        </div>
                        <div class="bg-gray-50 px-4 py-3 sm:px-6 flex flex-col flex-shrink justify-center">

                            <div class="text-sm font-bold flex flex-row justify-between mb-2">
                                <span>
                                    Name:
                                </span>
                                <span>
                                    {{ $order->full_name }}
                                </span>
                            </div>

                            @if ($order->care_off)
                                <div class="text-sm font-bold flex flex-row justify-between mb-2">
                                    <span>
                                        Care Off:
                                    </span>
                                    <span>
                                        {{ $order->by }}
                                    </span>
                                </div>
                            @endif

                            <div class="text-sm font-bold flex flex-row justify-between mb-2">
                                <span>
                                    Total:
                                </span>
                                <span>
                                    ₱ {{ number_format($totalPrice, 2, '.', ',') }}
                                </span>
                            </div>


                            <div class="text-sm font-bold flex flex-row justify-between mb-2 items-center">
                                <span>
                                    Payment Type:
                                </span>
                                <div class="flex space-x-3">
                                    <div class="flex space-x-2 items-center">
                                        <x-input type="radio" name="paymentType" wire:model.lazy="paymentType"
                                            id="cash" x-bind:disabled="paid ? true : false" value="cash" />
                                        <x-label for="cash" :value="__('Cash')" />
                                    </div>
                                    <div class="flex space-x-2 items-center">
                                        <x-input type="radio" name="paymentType" wire:model.lazy="paymentType"
                                            id="gcash" x-bind:disabled="paid ? true : false" value="gcash" />
                                        <x-label for="gcash" :value="__('GCash')" />
                                    </div>
                                </div>
                            </div>

                            <div class="text-sm font-bold flex flex-row justify-between mb-2 items-center">
                                <span>
                                    Cash:
                                </span>
                                <div class="flex flex-col">
                                    <x-input class="text-right h-8" {{-- wire:model.number="cash" wire:keyup="computeChange"  --}}
                                        x-bind:disabled="paid ? true : false" x-model="cash"
                                        x-on:keyUp="computeChange()" id="cash" type="number" />
                                    @error('cash')
                                        <span class="text-xs text-red-500 text-right">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="text-sm font-bold flex flex-row justify-between mb-2">
                                <span>
                                    Change:
                                </span>
                                {{-- <span>₱ {{ number_format($change, 2, '.', ',') ?? '0' }} </span> --}}
                                ₱ <span x-text="change"></span>
                            </div>

                            <button type="button" wire:click="confirmCheckOut" id="cOut"
                                wire:loading.attr="disabled"
                                class="mt-3 bg-green-500 hover:bg-green-700 py-2 w-full text-center rounded-lg text-white text-sm">
                                <div wire:loading wire:target="confirmCheckOut" class="mr-2">
                                    <i class="fas fa-circle-notch fa-spin"></i>
                                </div>
                                Check Out
                            </button>

                            <button type="button" wire:click="close"
                                class="mt-3 bg-red-500 hover:bg-red-700 py-2 w-full text-center rounded-lg text-white text-sm">
                                Close
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

<script>
    function checkout() {
        return {
            totalPrice: @entangle('totalPrice').defer,
            cash: @entangle('cash').defer,
            change: @entangle('change').defer,
            paid: false,
            init() {
                this.change = numberWithCommas(this.cash - this.totalPrice)
                if (this.change >= 0) this.paid = true
            },
            computeChange() {
                this.change = this.cash - this.totalPrice
                this.change = numberWithCommas(this.change)
            },
        }
    }

    function numberWithCommas(x) {
        return x.toFixed(2).toString().replace(/\B(?<!\.\d*)(?=(\d{3})+(?!\d))/g, ",");
    }

    window.addEventListener('printPO', event => {
        var button = document.getElementById('cOut');
        if (button != null) button.disabled = true;

        // var id = event.detail.orderId;
        // a = window.open('/print-po/' + id, 'myWin', 'left=50, top=50, width=400, height=800');
        // a.screenX = 0;
        // a.screenY = 0;
        // a.document.title = "Print";
        // a.focus();
        setTimeout(() => {
            // a.close();
            location.href = "{{ url('/waiter-order') }}"
        }, 1000);
    });
</script>
