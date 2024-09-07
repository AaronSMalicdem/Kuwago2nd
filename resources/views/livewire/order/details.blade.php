<div>
    <div class="pt-2">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-center flex-col sm:flex-row mt-3">
                <div class="flex flex-col w-full">
                    <div class="grid grid-cols-3 md:grid-cols-5">
                        @foreach ($categories as $category)
                            <x-menu-card :img="asset($category->icon)" :category="$category->name"
                                wire:click.prevent="viewDishes({{ $category->id ?? null }})"
                                class="{{ $selectedCategory == $category->id ? 'border-green-500' : '' }}" />
                        @endforeach
                            <x-menu-card :img=" asset('icons/Custom.png')" category="Custom"
                                wire:click.prevent="$emitTo('order.custom', 'addCustomDish')" />
                    </div>
                    <div wire:loading wire:target="viewDishes">
                        <div class="flex justify-center items-center mt-3 w-full">
                            <i class="fas fa-circle-notch text-red-700 text-3xl fa-spin"></i>
                        </div>
                    </div>
                    <div class="mt-3 h-96 w-full overflow-y-auto border">
                        <div wire:loading.remove wire:target="viewDishes">
                            @forelse ($dishes as $index => $dish)
                                <div wire:key="{{ $dish->id }}" class="flex border justify-between items-center py-3 pl-2 pr-3 text-xs lg:text-sm @if(!$dish->status) text-gray-300 @endif">
                                    <div class="flex items-center">
                                        <button type="button" wire:click.prevent.lazy="decrementQuantity({{ $index }})"><i class="fa fa-minus"></i></button>
                                        <x-input type="number" min="1" class="w-12 mx-2" wire:model.defer="dishes.{{ $index }}.quantity" readonly />
                                        <button type="button" wire:click.prevent.lazy="incrementQuantity({{ $index }})"><i class="fa fa-plus"></i></button>
                                    </div>
                                    <div class="flex justify-between w-1/2">
                                        <div class="flex flex-col">
                                            <span>
                                                {{ $dish->name }}
                                            </span>
                                            <span class="text-xs text-green-900">
                                                {{ $dish->add_on ? '(with side dish)' : '' }}
                                            </span>
                                        </div>
                                        <div>
                                            {{ $dish->price_formatted }}
                                        </div>
                                    </div>
                                    <div>
                                        <button wire:click.prevent="$emitTo('order.modal.add-on', 'addOn', '{{ $dish->id }}', '{{ $dishes[$index]['quantity'] }}')"
                                            class="text-white p-2 rounded ml-3 w-10
                                            {{ !$dish->status ? 'bg-gray-300' : 'bg-green-500 hover:bg-green-700' }}">
                                            {{-- <span wire:loading.remove wire:target="addDish({{ $dish->id }}, {{ $dishes[$index]['quantity'] }}, {{ $dishes[$index]['side'] }})"> --}}
                                                <i class="fas fa-plus text-lg"></i>
                                            {{-- </span> --}}
                                            {{-- <span wire:loading wire:target="addDish({{ $dish->id }}, {{ $dishes[$index]['quantity'] }}, {{ $dishes[$index]['side'] }})">
                                                <i class="fas fa-circle-notch text-lg fa-spin"></i>
                                            </span> --}}
                                        </button>
                                    </div>
                                </div>
                            @empty
                                <div class="border p-5">
                                    No entries
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
                <div class="sm:w-2/5 sm:mt-0 mt-3">
                    <div class="mx-2 flex flex-col">
                        <div class="mb-2 flex-none">
                            <div class="my-3">
                                <button type="button" {{ $isReviewing ? 'disabled' : '' }}
                                    class="bg-green-500 hover:bg-green-700 py-3 w-full text-center rounded-lg text-white"
                                    wire:click.prevent="placeOrders">Proceed</button>
                            </div>
                            <div class="text-lg font-bold flex flex-row justify-between">
                                <span>
                                    Total:
                                </span>
                                <span>
                                    ₱ {{number_format( $totalPrice, 2, '.', ',') }}
                                </span>
                            </div>

                        </div>
                        <div class="overflow-y-auto border rounded-lg p-1.5 w-full flex-grow">
                            @if($order)
                                @foreach ($oldOrders as $i => $item)
                                    <div class="flex justify-around mb-5 xl:text-sm text-xs" wire:model.defer="oldOrders.{{ $i }}">
                                        <button type="button" class="w-5"
                                            {{-- wire:click.prevent="$emitTo('auth.passcode', 'voidPasscode', {{ $item->id }}, 0)" --}}
                                            wire:click.prevent="$emitTo('order.modal.cancel', 'cancelDish', {{ $item->id }} , 0)" >
                                            <i class="fa fa-minus-circle {{ Gate::check('manage') ? 'text-red-500' : 'text-gray-200' }}"></i>
                                        </button>
                                        <div class="flex flex-col w-28">
                                            <div class="flex flex-col">
                                                <span>
                                                    {{ $item->dish->name }}
                                                </span>
                                                <span class="text-xs">
                                                    <ul>
                                                        @foreach ($item->sideDishes as $side)
                                                            <li>with: {{ $side->dish->name }}</li>
                                                        @endforeach
                                                    </ul>
                                                </span>
                                                <span>
                                                    {{ $item->note ? "note: ".$item->note : '' }}
                                                </span>
                                            </div>
                                            <div>
                                                X{{ $item['pcs'] }}
                                            </div>
                                        </div>
                                        <div class="flex items-end">
                                            ₱ {{number_format( $item['price'], 2, '.', ',') }}
                                        </div>
                                    </div>
                                @endforeach
                                @foreach($oldCustomOrders as $i => $item)
                                    <div class="flex justify-around mb-5 xl:text-sm text-xs">
                                        <button type="button" class="w-5"
                                            wire:click.prevent="$emitTo('order.modal.cancel', 'cancelDish', {{ $item->id }} , 1)" >
                                            <i class="fa fa-minus-circle {{ Gate::check('manage') ? 'text-red-500' : 'text-gray-200' }}"></i>
                                        </button>
                                        <div class="flex flex-col w-28">
                                            <div class="flex flex-col">
                                                <span>

                                                    {{ $item->name }} ({{ _('Custom') }})
                                                </span>
                                                <span class="text-xs">
                                                    {{ "Desc: ".$item->description }}
                                                </span>
                                            </div>
                                            <div>
                                                X{{ $item['pcs'] }}
                                            </div>
                                        </div>
                                        <div class="flex items-end">
                                            ₱ {{number_format( $item['price'], 2, '.', ',') }}
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                            @forelse ($orderedDishes as $i => $item)
                                <div class="flex justify-around mb-5 xl:text-sm text-xs">
                                    <button type="button" class="w-5" wire:click.prevent="removeDish({{ $i }})">
                                        <i class="fa fa-minus-circle text-red-500"></i>
                                    </button>
                                    <div class="flex flex-col w-28">
                                        <div class="flex flex-col">
                                            <span>
                                                {{ $item['name'] }}
                                            </span>
                                            <span class="text-xs">
                                                @if (isset($item['sides']))
                                                    <ul>
                                                        @foreach ($item['sides'] as $side)
                                                            <li>
                                                                with: {{ $side['name'] }}
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                @endif
                                                {{ isset($item['desc']) ? "Desc: ".$item['desc'] : '' }}
                                            </span>
                                            <span>
                                                {{ $item['note'] ? "\" ". $item['note'] ." \"" : '' }}
                                            </span>
                                        </div>
                                        <div>
                                            X{{ $item['quantity'] }}
                                        </div>
                                    </div>
                                    <div class="flex items-end">
                                        ₱ {{number_format( $item['price'], 2, '.', ',') }}
                                    </div>
                                </div>
                            @empty
                                <div class="text-center text-sm">
                                    No order Yet
                                </div>
                            @endforelse
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    @livewire('order.review', ['table' => $table, 'action' => $action, 'order' => $order])
    @livewire('order.custom');
    @livewire('order.modal.cancel');
    @livewire('order.modal.add-on');

</div>
