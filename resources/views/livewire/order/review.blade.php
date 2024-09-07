<div>
    @if($isModalOpen)
    <!-- This example requires Tailwind CSS v2.0+ -->
    <div class="absolute z-50 inset-0" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-start justify-center h-1/2 pt-4 px-4 text-center sm:block sm:p-0">
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
            <div
                class="inline-block overflow-hidden bg-white rounded-lg text-left shadow-xl transform transition-all w-96">
                <div class="flex flex-col justify-between h-screen">
                    <div class="flex flex-col flex-shrink bg-white py-2 lg:py-4 text-center">
                        {{ __('ORDER REVIEW') }}
                    </div>
                    <div class="flex flex-grow overflow-y-auto border">
                        <div class="w-full mt-2 px-5">
                            @forelse ($orderDetails as $i => $item)
                                <div class="flex justify-between text-sm w-full">
                                    <div class="flex flex-col">
                                        <div class="flex flex-col">
                                            <span>
                                                {{ $item['name'] }}
                                            </span>
                                            <span class="text-xs">
                                                {{ array_key_exists('side_name', $item) && $item['side_name'] ? 'with '.$item['side_name'] : '' }}
                                            </span>
                                        </div>
                                        <div class="ml-2">
                                            X{{ $item['quantity'] }}
                                        </div>
                                    </div>
                                    <div class="flex items-end">
                                        ₱ {{number_format( $item['price'], 2, '.', ',') }}
                                    </div>
                                </div>
                            @empty
                            <div class="text-center text-sm">
                                <div>
                                    No order Yet
                                </div>
                            </div>
                            @endforelse
                        </div>
                    </div>


                    <div class="flex flex-shrink items-end bg-gray-50">
                        <div class="flex flex-col px-4 py-3 sm:px-6 justify-center w-full">
                            <span class="text-red-500 text-xs text-center">
                                @error('orderDetails') {{ $message }} @enderror
                            </span>
                            <div class="font-bold flex flex-row justify-between mb-2 text-sm">
                                <span>
                                    Total:
                                </span>
                                <span>
                                    ₱ {{number_format( $totalPrice, 2, '.', ',') }}
                                </span>
                            </div>
                            <div class="font-bold flex flex-row justify-between items-center mb-2 text-sm">
                                <span>
                                    Pax:
                                </span>
                                <div class="flex flex-col">
                                    <x-input class="text-right h-8" type="number" wire:model.number.defer="pax" />
                                    @error('pax')
                                    <span class="text-xs text-red-500 text-right">
                                        {{ $message }}
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            @if($action == 'Delivery')
                            <div class="font-bold flex flex-row justify-between items-center mb-2 text-sm">
                                <span>
                                    Address:
                                </span>
                                <div class="flex flex-col">
                                    <x-input class="text-right h-8" type="text" wire:model.defer="address" />
                                    @error('address')
                                    <span class="text-xs text-red-500 text-right">
                                        {{ $message }}
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="font-bold flex flex-row justify-between items-center mb-2 text-sm">
                                <span>
                                    Contact:
                                </span>
                                <div class="flex flex-col">
                                    <x-input class="text-right h-8" type="text" wire:model.defer="contact" />
                                    @error('contact')
                                    <span class="text-xs text-red-500 text-right">
                                        {{ $message }}
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            @endif
                            <button type="button" wire:click="createOrder" id="cOrder" wire:loading.attr="disabled"
                                class="mt-3 bg-green-500 hover:bg-green-700 py-2 w-full text-center rounded-lg text-white text-sm">
                                <div wire:loading wire:target="createOrder" class="mr-2">
                                    <i class="fas fa-circle-notch fa-spin"></i>
                                </div>
                                Place Order on {{ $table->name ?? $action }}
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
    </div>
    @endif
</div>
<script>
    window.addEventListener('printOrder', event => {
        document.getElementById('cOrder').disabled = true;
        Livewire.emit('close');
        var id = event.detail.orderId;
        a = window.open('/print/'+id, 'myWin', 'left=50, top=50, width=400, height=800');
        a.screenX = 0;
        a.screenY = 0;
        a.document.title = "Print";
        a.focus();
        setTimeout(() => {
            a.close();
            window.location.href = "{{ url('/waiter-order') }}";
        }, 1000);
    });
</script>
