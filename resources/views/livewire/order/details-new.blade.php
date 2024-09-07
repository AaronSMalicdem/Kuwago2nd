<div>
    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>

    <div class="pt-2" x-data="orders()" x-init="init">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-center flex-col sm:flex-row mt-3">
                <div class="flex flex-col w-full">
                    <div class="grid grid-cols-3 md:grid-cols-5">

                        @foreach ($categories as $category)
                            <x-menu-card :img="asset('storage/'.$category->icon)" :category="$category->name"
                                @click="selectCategory( {{ $category->id }} )"
                                ::class=" selectedCategory == {{ $category->id }} ? 'border-green-500' : '' " />
                        @endforeach

                        {{-- <x-menu-card :img=" asset('icons/Custom.png')" @click="addCustom" category="Custom" /> --}}
                    </div>
                    <div x-show="isLoading">
                        <div class="flex justify-center items-center mt-3 w-full">
                            <i class="fas fa-circle-notch text-red-700 text-3xl fa-spin"></i>
                        </div>
                    </div>
                    <div class="mt-3 h-96 w-full overflow-y-auto border" x-show="!isLoading">
                        <template x-for="(dish, index) in categoryDishes" :key="index">
                            <div class="flex border justify-between items-center py-3 pl-2 pr-3 text-xs lg:text-sm">
                                <div class="flex items-center">
                                    <button type="button" @click="decrement(index)" ><i class="fa fa-minus"></i></button>
                                    <x-input type="number" min="1" class="w-12 mx-2" x-model="dish.quantity" readonly/>
                                    <button type="button" @click="increment(index)"><i class="fa fa-plus"></i></button>
                                </div>
                                <div class="flex justify-between w-1/2">
                                    <div class="flex flex-col">
                                        <span x-text="dish.name">
                                        </span>
                                        <span x-text="dish.properties" class="text-sm"></span>
                                    </div>
                                    <div x-text="numberWithCommas(dish.price)">
                                    </div>
                                </div>
                                <div>
                                    <button
                                        @click="addDish(dish)"
                                        class="text-white p-2 rounded ml-3 w-10"
                                        :class="!dish.status ? 'bg-gray-300' : 'bg-green-500 hover:bg-green-700'">
                                            <i class="fas fa-plus text-lg"></i>
                                    </button>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>
                <div class="sm:w-2/5 sm:mt-0 mt-3">
                    <div class="mx-2 flex flex-col">
                        <div class="mb-2 flex-none">
                            <div class="my-3">
                                <button type="button" @click="reviewOrder"
                                    class="bg-green-500 hover:bg-green-700 py-3 w-full text-center rounded-lg text-white">
                                    Proceed</button>
                            </div>
                            <div class="text-lg font-bold flex flex-row justify-between">
                                <span>
                                    Total:
                                </span>
                                <div>
                                    ₱ <span x-text="numberWithCommas(totalPrice)"></span>
                                </div>
                            </div>

                        </div>
                        <div class="overflow-y-auto border rounded-lg p-1.5 w-full flex-grow">
                            @if($order)
                                @foreach ($oldOrders as $i => $item)
                                    <div class="flex justify-around mb-5 xl:text-sm text-xs" wire:model.defer="oldOrders.{{ $i }}">
                                        <button type="button" class="w-5"
                                            wire:click.prevent="$emitTo('order.modal.cancel', 'cancelDish', {{ $item->id }} , 0)" >
                                            <i class="fa fa-minus-circle {{ Gate::check('manage') ? 'text-red-500' : 'text-gray-200' }}"></i>
                                        </button>
                                        <div class="flex flex-col w-28">
                                            <div class="flex flex-col">
                                                <span>
                                                    {{ $item->dish->name }}
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

                            @endif
                            <template x-for="(orderedDish, index) in orderedDishes" :key="index">
                                <div class="flex justify-around mb-5 xl:text-sm text-xs">
                                    <button type="button" class="w-5" @click="removeDish(index)">
                                        <i class="fa fa-minus-circle text-red-500"></i>
                                    </button>
                                    <div class="flex flex-col w-28" >
                                        <div class="flex flex-col">
                                            <span x-text="orderedDish.name"></span>

                                            <div class="text-xs">
                                                <div>
                                                    <span x-text="orderedDish.properties"></span>
                                                </div>
                                                <div x-show="orderedDish.note != ''">
                                                    Note: "<span x-text="orderedDish.note"></span>"
                                                </div>
                                            </div>
                                        </div>
                                        <div>
                                            X <span x-text="orderedDish.quantity"></span>
                                        </div>
                                    </div>
                                    <div class="flex items-end">
                                        ₱ <span x-text="numberWithCommas((orderedDish.new_price ?? orderedDish.price) * orderedDish.quantity)"></span>
                                    </div>
                                </div>
                            </template>

                        </div>

                    </div>
                </div>
            </div>
        </div>

        <div x-show="addOnModal" x-cloak>
            <x-modal>
                <x-slot name="header">
                    <span x-text="selectedDish.name + ' x ' +selectedDish.quantity + ' = ₱ ' + numberWithCommas((selectedDish.new_price ?? selectedDish.price) * selectedDish.quantity)" />
                </x-slot>

                <div class="">
                    Apply discount? <input type="checkbox" x-model="selectedDish.enable_discount" value="1">
                    <div x-show="selectedDish.enable_discount" class="mt-2">
                        New Price of item
                        <x-input type="number" x-model.number="selectedDish.new_price"></x-input>
                    </div>
                </div>

                <div class="px-4 pb-4 sm:p-6 sm:pb-4 flex flex-col">
                    <span class="text-base font-medium">Add Note</span>
                    <x-textarea class="w-full" x-model="note"></x-textarea>
                </div>

                <x-slot name="buttons">
                    <button type="button" @click="confirmDish"
                        class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-green-500 text-base font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Add
                    </button>
                    <button type="button" @click="cancelAddOn"
                        class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Cancel
                    </button>
                </x-slot>
            </x-modal>
        </div>

        <div x-show="reviewModal" x-cloak>
            <x-large-modal>
                <x-slot name="header">
                    ORDER REVIEW
                </x-slot>

                <div class="w-full mt-2 px-5">
                    <template x-for="(orderedDish, index) in orderedDishes" :key="'review' + index">
                        <div class="flex justify-between text-sm w-full">
                            <div class="flex flex-col">
                                <div class="flex flex-col">
                                    <span x-text="orderedDish.name"></span>

                                </div>
                                <div class="ml-2">
                                    X <span x-text="orderedDish.quantity"></span>
                                </div>
                            </div>
                            <div class="flex items-end">
                                ₱ <span x-text="numberWithCommas((orderedDish.new_price ?? orderedDish.price) * orderedDish.quantity)"></span>
                            </div>
                        </div>
                    </template>

                    <div class="text-center text-sm" x-show="orderedDishes.length < 1">
                        No order Yet
                    </div>

                </div>

                <x-slot name="footer">
                    <span class="text-red-500 text-xs text-center" x-text="errors.order"></span>

                    <div class="text-sm font-bold flex flex-row justify-between mb-2 items-center">
                        <span>
                            Name:
                        </span>
                        <div class="flex flex-col">
                            <x-input class="h-8"
                                x-model="full_name"
                                id="full_name" type="text" />
                        </div>
                    </div>

                    <div class="text-sm font-bold flex flex-row justify-between mb-2 items-center">
                        <div class="flex space-x-2">
                            <x-input type="checkbox" value=1 name="care_off" id="care_off" x-model="care_off"  />
                            <x-label for="care_off" class="text-sm font-bold text-black" :value="__('Care Off')" />
                        </div>
                        <div class="flex flex-col">
                            <x-input class="h-8"
                                x-model="by"
                                id="by" type="text" x-bind:disabled="!care_off" x-bind:class="!care_off ? 'bg-gray-200' : ''" />
                        </div>
                    </div>

                    <div class="font-bold flex flex-row justify-between mb-2 text-sm">
                        <span>
                            Total:
                        </span>
                        <div>
                            ₱ <span x-text="numberWithCommas(totalPrice)"></span>
                        </div>
                    </div>

                    <div class="text-sm font-bold flex flex-row justify-between mb-2 items-center">
                        <span>
                            Payment Type:
                        </span>
                        <div class="flex space-x-3">
                            <div class="flex items-center space-x-2">
                                <x-input type="radio" name="paymentType" x-model="paymentType" id="pcash"
                                    value="cash" />
                                <x-label for="pcash" :value="__('Cash')" />
                            </div>
                            <div class="flex items-center space-x-2">
                                <x-input type="radio" name="paymentType" x-model="paymentType" id="gcash"
                                    value="gcash" />
                                <x-label for="gcash" :value="__('GCash')" />
                            </div>
                        </div>
                    </div>

                    <div class="text-sm font-bold flex flex-row justify-between mb-2 items-center">
                        <span>
                            Cash:
                        </span>
                        <div class="flex flex-col">
                            <x-input class="text-right h-8"
                                x-model="cash" x-on:keyUp="computeChange()"
                                id="cash" type="number" />
                        </div>
                    </div>

                    <div class="text-sm font-bold flex flex-row justify-between mb-2">
                        <span>
                            Change:
                        </span>

                        ₱ <span x-text="change"></span>
                    </div>

                    <button type="button" :disabled="confirmedOrder" @click="confirmOrder" :class="confirmedOrder ? 'bg-green-900 cursor-wait' : ' bg-green-500 hover:bg-green-700'"
                        class="mt-3 py-2 w-full text-center rounded-lg text-white text-sm">
                        <div class="mr-2" x-show="confirmedOrder">
                            <i class="fas fa-circle-notch fa-spin"></i>
                        </div>
                        <div x-show="!confirmedOrder">
                            Place Order
                        </div>
                    </button>
                    <button type="button" @click="cancelReview" :disabled="confirmedOrder" :class="confirmedOrder ? 'bg-red-900 cursor-wait' : 'bg-red-500 hover:bg-red-700'"
                        class="mt-3  py-2 w-full text-center rounded-lg text-white text-sm">
                        Close
                    </button>
                </x-slot>
            </x-large-modal>
        </div>

    </div>

    @livewire('order.modal.cancel');

</div>

<script>
    function orders() {

        return {
            selectedCategory : @entangle('selectedCategory').defer,
            categories : @entangle('categories').defer,
            dishes : @entangle('dishes').defer,
            totalPrice : @entangle('totalPrice').defer,
            orderedDishes: @entangle('orderedDishes').defer,
            cash : @entangle('cash').defer,
            change : @entangle('change').defer,
            full_name: @entangle('fullName').defer,
            paymentType: @entangle('paymentType').defer,
            care_off: @entangle('care_off').defer,
            by: @entangle('by').defer,
            addOnModal : false,
            reviewModal : false,
            confirmedOrder : false,
            isLoading : true,
            selectedAddOns : [],
            categoryDishes : [],
            selectedDish: [],
            note : '',
            errors : [],
            selectCategory(val) {
                this.selectedCategory = val
                this.categoryDishes = this.dishes.filter( (d) => d.category_id == this.selectedCategory  )
                this.categoryDishes.forEach(dish => {
                    dish['quantity'] = 1
                });
            },
            increment(id){
                this.categoryDishes[id].quantity++
            },
            decrement(id){
                if (this.categoryDishes[id].quantity > 1)
                    this.categoryDishes[id].quantity--
            },
            init(){
                this.categoryDishes = this.dishes.filter( (d) => d.category_id == this.selectedCategory  )
                this.isLoading = false
                this.addOnModal = false
                this.reviewModal = false
            },
            addDish(d){
                this.addOnModal = true
                dish = convertToJSON(d)
                this.selectedDish = dish
            },
            confirmDish(){
                var same = false
                this.selectedDish['note'] = this.note

                this.orderedDishes.forEach( (item, index, arr) => {
                    parsed = convertToJSON(item)

                    if( this.selectedDish['id'] == parsed['id'] && this.selectedDish['note'] == parsed['note'] && this.selectedDish['new_price'] == parsed['new_price'] ) {

                        arr[index]['quantity'] += dish['quantity']
                        same = true
                    }

                })
                if(!same)
                    this.orderedDishes.push(convertToJSON(this.selectedDish))

                this.totalPrice += (this.selectedDish['new_price'] ?? this.selectedDish['price']) * this.selectedDish['quantity']
                this.selectedDish = false
                this.addOnModal = false
                this.note = ''
                this.errors = []

            },
            cancelAddOn(){
                this.addOnModal = false
                this.selectedAddOns = []
            },
            removeDish(index){
                dish = convertToJSON(this.orderedDishes[index])
                this.totalPrice -= dish['price'] * dish['quantity']
                this.orderedDishes.splice(index, 1)
            },
            reviewOrder() {
                this.reviewModal = true
            },
            cancelReview() {
                this.errors = []
                this.reviewModal = false
                this.cash = 0
            },
            computeChange() {
                this.change = numberWithCommas(this.cash - this.totalPrice)
            },
            confirmOrder() {

                if(this.full_name === '') {
                    this.errors['order'] = "Enter Name"
                    return
                }

                if(this.orderedDishes.length < 1) {
                    this.errors['order'] = "Please add order"
                    return
                }

                this.confirmedOrder = true
                Livewire.emit('createOrder')
            },

        }
    }

    function numberWithCommas(x) {
        return x.toFixed(2).toString().replace(/\B(?<!\.\d*)(?=(\d{3})+(?!\d))/g, ",");
    }

    function convertToJSON(x) {
        return JSON.parse(JSON.stringify(x))
    }

    window.addEventListener('printOrder', event => {

        Livewire.emit('close');
        var id = event.detail.orderId;
        a = window.open('/print-po/'+id, 'myWin', 'left=50, top=50, width=400, height=800');
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
