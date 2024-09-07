<div>
    <button class="w-full text-green-500 font-bold" type="button" wire:click="setBillingType">
        Billing Type
    </button>

    @if($isModalOpen)
    <!-- This example requires Tailwind CSS v2.0+ -->
    <div class="absolute z-50 inset-0" aria-labelledby="modal-title" role="dialog" aria-modal="true" x-data>
        <div class="flex items-start justify-center h-screen pt-4 px-4 text-center sm:block sm:p-0">
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
                class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="flex-shrink-0 flex items-center justify-center mx-auto">
                        <!-- Heroicon name: outline/exclamation -->
                        {{ __('BILLING TYPE') }}
                    </div>
                </div>
                <div class="flex justify-center space-x-2">
                    <x-input id="single" type="radio" wire:model.lazy="billingType" value="single" />
                    <x-label for="single" :value="__('Single')" />
                    <x-input id="multiple" type="radio" wire:model.lazy="billingType" value="multiple" />
                    <x-label for="multiple" :value="__('Multiple')" />
                </div>
                @if($billingType == "multiple")
                <div class="px-4 mt-2">
                    <div class="flex justify-between">
                        <div>
                            <button type="button"
                                class="bg-green-500 hover:bg-green-700 py-2 px-2 text-center rounded-lg text-white text-xs"
                                wire:click="addReceipient">
                                Add Receipient
                            </button>
                        </div>
                        <div>
                            <div class="flex flex-col items-end">
                                <div class="flex">
                                    <div wire:loading class="mr-2">
                                        <i class="fas fa-circle-notch fa-spin"></i>
                                    </div>
                                    <div wire:loading.remove class="mr-2">
                                        @if(!$isBillEqualPrice)
                                        <span class="font-bold text-red-500">
                                            (Remaining: ₱ {{ number_format($remaining, 2, '.', ',')  }})
                                        </span>
                                        @else
                                        <span class="text-green-500">
                                            <i class="fa fa-check"></i>
                                        </span>
                                        @endif
                                    </div>

                                    <span>
                                        Total: ₱ {{ number_format($order->totalPrice(), 2, '.', ',') }}
                                    </span>
                                </div>
                                <span class="text-xs text-red-500">
                                    @error('equal')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                @foreach ($receipts as $i => $receipt)
                <div class="text-sm font-bold flex flex-col py-4 px-4">
                    <div>
                        <span>
                            Receipt Name:
                        </span>
                        <div class="flex flex-col">
                            <x-input class="h-8 w-full" wire:model.defer="receipts.{{ $i }}.name" type="text" autofocus />
                            @error('receipts.'.$i .'.name')
                            <span class="text-xs text-red-500 text-right">
                                {{ $message }}
                            </span>
                            @enderror
                        </div>
                    </div>
                    <span>
                        Receipt Address:
                    </span>
                    <div class="flex flex-col">
                        <x-input class="h-8 w-full" wire:model.defer="receipts.{{ $i }}.address" type="text" />
                        @error('receipts.'.$i .'.address')
                        <span class="text-xs text-red-500 text-right">
                            {{ $message }}
                        </span>
                        @enderror
                    </div>
                    <span>
                        Receipt Contact:
                    </span>
                    <div class="flex flex-col">

                        <x-input class="h-8 w-full" wire:model.defer="receipts.{{ $i }}.contact" type="text" />
                        @error('receipts.'.$i .'.contact')
                        <span class="text-xs text-red-500 text-right">
                            {{ $message }}
                        </span>
                        @enderror
                    </div>
                    @if($billingType == "multiple")
                    <span>
                        Receipt Amount (You can leave it blank):
                    </span>
                    <div class="flex flex-col">

                        <x-input class="h-8 w-full" wire:model="receipts.{{ $i }}.amount" type="number" min='0' />
                        @error('receipts.'.$i .'.amount')
                        <span class="text-xs text-red-500 text-right">
                            {{ $message }}
                        </span>
                        @enderror
                    </div>
                    @endif
                </div>
                @endforeach
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="button" wire:click="saveReceipts"
                        class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-green-500 text-base font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Save
                    </button>
                    <button type="button" wire:click="close"
                        class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-red-500 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
