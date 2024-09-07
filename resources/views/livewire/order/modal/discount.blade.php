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
                class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-5xl sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="flex-shrink-0 flex items-center justify-center mx-auto">
                        <!-- Heroicon name: outline/exclamation -->
                        {{ __('DISCOUNT') }}
                    </div>
                </div>

                <div class="px-4 ">
                    <x-auth-validation-errors />
                    Order #: {{ $order->order_number }}

                    <div class="flex flex-col mt-1 space-y-1">
                        <div class="flex justify-between">
                            <span>
                                Enable Discount:
                            </span>
                            <x-input wire:model="enableDiscount" type="checkbox" value="1" />
                        </div>

                    </div>
                    @if ($enableDiscount)
                        <div class="flex flex-col mt-1 space-y-1 p-2 bg-gray-100">


                                <div class="flex justify-between">
                                    <span>
                                        Discount Settings: {{ $discountSettings }}
                                    </span>
                                    <div class="flex space-x-2">
                                        <input type="radio" wire:model.debounce="discountSettings" id="whole" value="whole" {{ !$enableDiscount ? 'disabled' : '' }} >
                                        <x-label for="whole">{{ __('Whole') }}</x-label>
                                        <input type="radio" wire:model.debounce="discountSettings" id="per_item" value="per_item" {{ !$enableDiscount ? 'disabled' : '' }} >
                                        <x-label for="per_item">{{ __('Per Item') }}</x-label>
                                    </div>
                                </div>


                            @if ($discountSettings == 'whole')
                                <div class="flex justify-between">
                                    <span>
                                        Type:
                                    </span>
                                    <x-select class="h-8 w-80 text-xs" wire:model="discountType" :disabled="!$enableDiscount" >
                                        <option value="" selected>{{ __('Select Type') }}</option>
                                        <option value="percent">{{ __('Percent') }}</option>
                                        <option value="fixed">{{ __('Fixed') }}</option>
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
                            @endif

                            @if ($discountSettings == 'per_item')

                                @foreach ($order->orderDetails as $o)

                                    <div class="flex justify-between items-end mb-1 text-sm w-full">
                                        <div class="flex justify-between w-full px-3">
                                            <div class="flex flex-col">
                                                <div class="flex flex-col">
                                                    <span>
                                                        {{ $o->dish->name }}
                                                    </span>
                                                    <span class="text-xs">
                                                        <ul>
                                                            @foreach ($o->sideDishes as $side)
                                                                <li>with: {{ $side->dish->name }}</li>
                                                            @endforeach
                                                        </ul>
                                                    </span>
                                                </div>
                                                <div>
                                                    X{{ $o->pcs }}
                                                </div>
                                            </div>
                                            <div class="flex items-end">
                                                ₱ {{number_format( $o->getPrice(), 2, '.', ',') }}
                                                <span class="line-through ml-1">
                                                    {{ $o->discountItem()->exists() ? number_format(
                                                    $o->price, 2, '.', ',') : '' }}
                                                </span>
                                            </div>
                                        </div>

                                        <div class="flex space-x-2 items-center">
                                            <div>
                                                <x-input type="text" class="text-xs" placeholder="Quantity to discount" :disabled=!$enableDiscount wire:model="discounts.{{ $o->id }}.def.items" />
                                            </div>
                                            <div>
                                                <x-select class="text-xs" :disabled=!$enableDiscount wire:model="discounts.{{ $o->id }}.def.discountId" >
                                                    <option value="" selected>Select Discount</option>
                                                    @foreach ($allDiscounts as $d)
                                                        <option value="{{ $d->id }}">{{ $d->name }} ({{ $d->value }}{{ $d->type == "percent" ? "%" : '' }})</option>
                                                    @endforeach
                                                </x-select>
                                            </div>
                                            <div>
                                                <x-input type="text" class="text-xs" placeholder="Discount Description" :disabled=!$enableDiscount wire:model="discounts.{{ $o->id }}.def.discount_details" />
                                            </div>
                                            <div class="flex space-x-2">

                                                @if($o->discountItem)

                                                    <button class=" text-red-500 hover:text-red-300" wire:click="deleteDiscount({{ $o->id }})">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                @else
                                                    <button class="text-green-500 hover:text-green-300" wire:click="resetDiscount({{ $o->id }})">
                                                        <i class="fa fa-undo"></i>
                                                    </button>

                                                @endif


                                            </div>
                                        </div>

                                    </div>
                                @endforeach

                                @foreach ($order->customOrderDetails as $c)

                                @endforeach

                            @endif



                        </div>


                    @endif
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
