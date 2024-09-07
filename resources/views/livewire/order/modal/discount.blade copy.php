<div>

    @if($isModalOpen)
    <!-- This example requires Tailwind CSS v2.0+ -->
    <div class="fixed z-50 inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
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
                class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-xl sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="flex-shrink-0 flex items-center justify-center mx-auto">
                        <!-- Heroicon name: outline/exclamation -->
                        {{ __('DISCOUNT') }}
                    </div>
                </div>
                <div class="px-4 ">
                    Order #: {{ $order->order_number }}

                    <div class="flex flex-col mt-1 space-y-1">
                        <div class="flex justify-between">
                            <span>
                                Enable Discount:
                            </span>
                            <x-input wire:model="enableDiscount" type="checkbox" value="1" />
                        </div>
                    </div>

                    <div class="flex flex-col mt-1 space-y-1 bg-gray-100 p-2">
                        <div class="flex justify-between">
                            <span>
                                Type:
                            </span>
                            <x-select class="h-8 w-80 text-xs" wire:model="discountType" :disabled="!$enableDiscount" >
                                <option value="percent">{{ _('Percent') }}</option>
                                <option value="fixed">{{ _('Fixed') }}</option>
                            </x-select>
                        </div>
                        <div class="flex justify-between">
                            <span>
                                Discount:
                            </span>
                            <x-input :disabled="!$enableDiscount"
                                class="text-right w-80 text-xs p-2 {{ $errors->get('discount') ? 'border border-red-500' : '' }}"
                                wire:model="discount" />
                        </div>
                        <div class="flex justify-between">
                            <span>
                                Description:
                            </span>
                            <textarea {{ !$enableDiscount ? 'disabled' : '' }}
                                class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring
                                focus:ring-indigo-200 focus:ring-opacity-50 resize-y w-80 text-xs p-2 {{ $errors->get('discountDescription') ? 'border border-red-500' : '' }}"
                                wire:model="discountDescription"></textarea>
                        </div>
                    </div>


                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="button" wire:click="saveDiscount"
                        class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-green-500 text-base font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        <div wire:loading wire:target="saveDiscount" class="mr-2">
                            <i class="fas fa-circle-notch fa-spin"></i>
                        </div>
                        Save
                    </button>
                    <button type="button" wire:click="close"
                        class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
