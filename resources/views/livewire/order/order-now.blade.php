<div>
    <div class="max-w-screen mx-auto p-12 overflow-y-hidden" x-data="orders()">

        <ol class="flex items-center w-full font-medium text-center justify-between">
            <template x-for="(step, index) in stepper" :key="index">
                <li class="flex w-full items-center space-x-2.5">
                    <span x-text="(index + 1)"
                        class="flex items-center justify-center w-8 h-8 border rounded-full shrink-0 text-lg"
                        :class="activeStepper == index && 'border-2 border-blue-500 text-blue-500 font-bold'"></span>
                    <span x-text="step" class="uppercase text-lg font-semibold"
                        :class="activeStepper == index && 'text-blue-500 font-bold'"></span>
                </li>
            </template>
        </ol>

        <hr class="mt-5">
        <div>

        </div>

        <div class="grid grid-cols-2 gap-4 mt-5" x-show="activeStepper === 0"
            x-transition:enter="transition ease-in-out duration-75 delay-300"
            x-transition:enter-start="-translate-x-10 opacity-0" x-transition:enter-end="translate-x-0 opacity-100"
            x-transition:leave="transition ease-out duration-75" x-transition:leave-start="translate-x-0 opacity-100"
            x-transition:leave-end="-translate-x-10 opacity-0">
            <div class="block xl:flex">
                <div
                    class="grow-0 flex xl:block overflow-y-auto scrollbar-thin scrollbar-thumb-blue-500 scrollbar-track-white snap-y max-h-[60vh]">
                    <template x-for="(category, cIndex) in categories" :key="`cat` + cIndex">
                        <div :class="activeCategory == category.id ? 'bg-green-400' : 'bg-white'"
                            @click="setActiveCategory(category.id)"
                            class="shrink-0 snap-end border-2 rounded-lg p-1 lg:p-2 mx-1 cursor-pointer flex flex-col items-center justify-center hover:bg-green-500">
                            <img :src="`{{ asset('storage/') }}/` + category.icon" :alt="category.icon"
                                class="w-10 h-10 mx-10">
                            <span x-text="category.name" class="mt-2 uppercase font-semibold text-xs"></span>
                        </div>
                    </template>
                </div>

                <div
                    class="border overflow-y-auto scrollbar-thin scrollbar-thumb-blue-500 scrollbar-track-white w-full max-h-[60vh]">
                    <template x-for="(dish, dIndex) in dishes" :key="`dish` + dIndex">
                        <div class="flex justify-between items-center border px-3 py-2"
                            x-show="activeCategory == dish.category_id || activeCategory === null ">
                            <div class="grow">
                                <span class="uppercase text-base font-semibold" x-text="dish.name"></span>
                                <span class="text-xs before:content-['-'] before:mr-1" x-text="dish.properties"></span>
                                <div class="text-xs italic" x-text="dish.category.name"></div>
                            </div>
                            <div x-text="dish.price_formatted" class="text-right text-sm shrink mx-5 whitespace-nowrap">
                            </div>
                            <div class="text-right shrink">
                                <button type="button" class="text-green-500 hover:text-green-300"
                                    @click="selectDish(dish)">
                                    <i class="fa fa-plus-circle"></i>
                                </button>
                            </div>
                        </div>
                    </template>
                </div>
            </div>
            <div class="grid grid-cols-1 xl:grid-cols-2 xl:gap-4">
                <div class="order-last xl:order-first">
                    <div class="p-6 w-full overflow-y-auto scrollbar-thin scrollbar-thumb-blue-500 scrollbar-track-white max-h-[60vh]"
                        :class="hasSelectedDish ? 'border-2 border-green-500' : 'bg-gray-200'">

                        <div>
                            <label for="dish-name"
                                class="block mb-2 text-xs font-medium text-gray-900 dark:text-white">Dish</label>
                            <input type="text" id="dish-name" x-model="selectedDish.name"
                                :disabled="!hasSelectedDish"
                                class="disabled:bg-gray-200 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                readonly>
                        </div>

                        <div>
                            <label for="dish-price"
                                class="block mb-2 text-xs font-medium text-gray-900 dark:text-white">Price</label>
                            <input type="text" id="dish-price" x-model="selectedDish.price"
                                :disabled="!hasSelectedDish"
                                class="disabled:bg-gray-200 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                readonly>
                        </div>

                        <div class="flex space-x-2 items-end">
                            <div class="w-full">
                                <label for="dish-quantity"
                                    class="block mb-2 text-xs font-medium text-gray-900 dark:text-white">Quantity</label>
                                <input type="number" id="dish-quantity" x-model="selectedDish.quantity"
                                    :disabled="!hasSelectedDish"
                                    class="disabled:bg-gray-200 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    readonly>
                            </div>
                            <div class="shrink-0">
                                <button type="button" :disabled="!hasSelectedDish" class="text-xl"
                                    @click="if (hasSelectedDish && selectedDish.quantity > 1) selectedDish.quantity--">
                                    <i class="fas fa-minus-square"></i>
                                </button>
                                <button type="button" :disabled="!hasSelectedDish" class="text-xl"
                                    @click="if(hasSelectedDish) selectedDish.quantity++">
                                    <i class="fas fa-plus-square"></i>
                                </button>
                            </div>
                        </div>

                        <div>
                            <input id="checkbox-3" type="checkbox" value="1" x-model="selectedDish.enableDiscount"
                                :disabled="!hasSelectedDish"
                                class="disabled:bg-gray-200 w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                            <label for="checkbox-3"
                                class="ml-2 text-xs font-medium text-gray-900 dark:text-gray-300 select-none">Enable
                                Discount</label>
                        </div>

                        <div x-show="selectedDish.enableDiscount" class="mt-2"
                            x-transition:enter="transition ease-out duration-75"
                            x-transition:enter-start="opacity-0 scale-90" x-transition:enter-end="opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-75"
                            x-transition:leave-start="opacity-100 scale-100"
                            x-transition:leave-end="opacity-0 scale-90">
                            <div>
                                <label for="discount-type"
                                    class="block mb-2 text-xs font-medium text-gray-900 dark:text-white select-none">Discount
                                    Type</label>
                                <select id="discount-type" x-model="selectedDish.discountType"
                                    :disabled="!hasSelectedDish"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    <option value="">Select Discount Type</option>
                                    <template x-for="(type, i) in discountTypes" :key="`discount` + i">
                                        <option :value="type" x-text="type"></option>
                                    </template>
                                </select>
                            </div>

                            <div>
                                <label for="dish-discount"
                                    class="block mb-2 text-xs font-medium text-gray-900 dark:text-white">Discount</label>
                                <input type="number" id="dish-discount" x-model.number="selectedDish.discount"
                                    :disabled="!hasSelectedDish"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <p x-show="errors.discount" class="text-red-500 italic text-xs"
                                    x-text="errors.discount">
                                </p>
                            </div>
                        </div>


                        <div class="flex justify-end space-x-2 mt-2">
                            <button type="button" class="text-red-500 hover:text-red-700" class="text-xl"
                                :disabled="!hasSelectedDish" @click="removeSelectedDish()">
                                <i class="far fa-trash-alt"></i>
                            </button>
                            <button type="button" class="text-green-500 hover:text-green-700" class="text-xl"
                                :disabled="!hasSelectedDish" @click="addOrderedDish(selectedDish)">
                                <i class="fas fa-check"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <div class=" p-6 w-full">

                    <button type="button" @click="activeStepper++"
                        class="block w-full px-2 py-3 text-white bg-blue-500 hover:bg-blue-700 shadow-sm">Next</button>

                    <div class="flex justify-end">
                        <span class="font-bold text-lg uppercase mr-2">Total</span>
                        <span x-text="formatCurrency(total)"></span>
                    </div>

                    <div
                        class="w-full p-2 border max-h-[60vh] overflow-y-auto scrollbar-thin scrollbar-thumb-blue-500 scrollbar-track-white divide-y">

                        <template x-for="(orderedDish, i) in orderedDishes" :key="`od` + i">
                            <div class="grid grid-cols-3 py-1">
                                <div class="grow">
                                    <div x-text="orderedDish.name" class="text-sm font-medium"></div>
                                    <div x-text="orderedDish.properties" class="text-xs"></div>
                                    <div x-text="orderedDish.quantity" class="text-xs before:content-['X']"></div>
                                </div>
                                <div class="text-right text-sm">
                                    <span x-text="formatCurrency(orderedDish.price * orderedDish.quantity)"></span>
                                    <span x-show="orderedDish.enableDiscount" class="text-red-500"
                                        x-text="`(-`+ formatCurrency((orderedDish.origPrice - orderedDish.price) * orderedDish.quantity) +`)`"></span>
                                </div>
                                <div class="text-center">
                                    <button type="button" class="text-red-500 hover:text-red-700"
                                        @click="removeOrderedDish(i)">
                                        <i class="far fa-trash-alt"></i>
                                    </button>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>
            </div>

        </div>

        <div class="mt-5" x-show="activeStepper === 1"
            x-transition:enter="transition ease-in-out duration-75 delay-300"
            x-transition:enter-start="translate-x-10 opacity-0" x-transition:enter-end="translate-x-0 opacity-100"
            x-transition:leave="transition ease-out duration-75" x-transition:leave-start="translate-x-0 opacity-100"
            x-transition:leave-end="translate-x-10 opacity-0">

            <div class="grid grid-cols-3 gap-12">
                <div></div>
                <div
                    class="overflow-y-auto max-h-[60vh] scrollbar-thin scrollbar-thumb-blue-500 scrollbar-track-white border p-2">
                    <div class="mb-2">
                        <label for="name"
                            class="block mb-2 text-xs font-medium text-gray-900 dark:text-white">Full Name</label>
                        <input type="text" id="name" x-model="fullName"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <p x-show="errors.fullName" class="text-red-500 italic text-xs" x-text="errors.fullName">
                    </div>

                    <div class="flex items-center mb-2">
                        <input id="care-off" type="checkbox" value="1" x-model="careOff"
                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                        <label for="care-off" class="ml-2 text-xs font-medium text-gray-900 dark:text-gray-300">Care
                            Off</label>
                    </div>
                    <div class="mb-2">
                        <input type="text" id="name" x-model="by" :disabled="!careOff"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 disabled:bg-gray-100 disabled:cursor-not-allowed">
                        <p x-show="errors.by" class="text-red-500 italic text-xs" x-text="errors.by">
                    </div>

                    <div class="mb-2">
                        <label for="total-payment"
                            class="block mb-2 text-xs font-medium text-gray-900 dark:text-white">Total</label>
                        <input type="text" id="total-payment" x-model="formatCurrency(total)" readonly
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    </div>
                    <div class="mb-2 flex space-x-2 w-full">
                        <div class="w-full flex items-center pl-4 border border-gray-200 rounded dark:border-gray-700">
                            <input id="pcash" type="radio" value="cash" x-model="paymentType"
                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                            <label for="pcash"
                                class="w-full py-4 ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">Cash</label>
                        </div>
                        <div class="w-full flex items-center pl-4 border border-gray-200 rounded dark:border-gray-700">
                            <input id="gcash" type="radio" value="gcash" x-model="paymentType"
                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                            <label for="gcash"
                                class="w-full py-4 ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">GCash</label>
                        </div>
                    </div>
                    <p x-show="errors.payment" class="text-red-500 italic text-xs" x-text="errors.payment">

                    <div class="mb-2">
                        <label for="payment"
                            class="block mb-2 text-xs font-medium text-gray-900 dark:text-white">Payment</label>
                        <input type="text" id="payment" x-model.number="cash" @keyUp="computeChange()"
                            @change="cash == 0 ? null : cash"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    </div>

                    <div class="mb-2">
                        <label for="change"
                            class="block mb-2 text-xs font-medium text-gray-900 dark:text-white">Change</label>
                        <input type="text" id="change" x-model="formatCurrency(change)" readonly
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    </div>
                    <button
                        class="flex justify-center items-center w-full px-2 py-3 text-white bg-green-500 hover:bg-green-700"
                        @click="placeOrder()" :disabled="processing">
                        <span x-show="processing">
                            <i class="fas fa-circle-notch animate-spin"></i>
                        </span>
                        <span>Place Order</span>
                    </button>
                </div>

                <div class="p-2">
                    <button type="button" @click="activeStepper--"
                        class="block w-full px-2 py-3 text-white bg-red-500 hover:bg-red-700 shadow-sm">Back</button>
                    <div
                        class="mt-2 max-h-[60vh] overflow-y-auto scrollbar-thin scrollbar-thumb-blue-500 scrollbar-track-white divide-y">
                        <template x-for="(orderedDish, i) in orderedDishes" :key="`od` + i">
                            <div class="grid grid-cols-3 py-1">
                                <div>
                                    <div x-text="orderedDish.name" class="text-sm font-medium"></div>
                                    <div x-text="orderedDish.properties" class="text-xs"></div>
                                    <div x-text="orderedDish.quantity" class="text-xs before:content-['X']"></div>
                                </div>
                                <div class="text-right text-sm">
                                    <span x-text="formatCurrency(orderedDish.price * orderedDish.quantity)"></span>
                                    <span x-show="orderedDish.enableDiscount" class="text-red-500"
                                        x-text="`(-`+ formatCurrency(orderedDish.origPrice - orderedDish.price) +`)`"></span>
                                </div>
                                <div class="text-center">
                                    <button type="button" class="text-red-500 hover:text-red-700"
                                        @click="removeOrderedDish(i)">
                                        <i class="far fa-trash-alt"></i>
                                    </button>
                                </div>
                            </div>
                        </template>
                        <p x-show="errors.orders" class="text-red-500 italic text-xs" x-text="errors.orders">
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>

<script>
    function orders() {
        return {
            stepper: ['Order', 'Review'],
            activeStepper: 0,
            categories: @entangle('categories'),
            dishes: @entangle('dishes'),
            orderedDishes: @entangle('orderedDishes').defer,
            fullName: @entangle('fullName').defer,
            by: @entangle('by').defer,
            careOff: @entangle('careOff').defer,
            paymentType: @entangle('paymentType').defer,
            cash: @entangle('payment').defer,
            change: @entangle('change').defer,
            discountTypes: ['Percent', 'Fixed'],
            activeCategory: null,
            selectedDish: {},
            errors: {},
            hasSelectedDish: false,
            enableDiscount: false,
            total: @entangle('total').defer,
            processing: false,
            setActiveCategory(id) {
                this.activeCategory = this.activeCategory == id ? null : id
            },
            selectDish(dish) {
                this.selectedDish = JSON.parse(JSON.stringify(dish))
                this.hasSelectedDish = true
            },
            removeSelectedDish() {
                this.selectedDish = {}
                this.hasSelectedDish = false
                this.errors = {}
            },
            addOrderedDish(dish) {
                if (dish.enableDiscount) {
                    if (dish.discount === 0 || !('discount' in dish) || !('discountType' in dish))
                        return this.errors.discount = "No discount specified!"
                    dish.origPrice = dish.price
                    if (dish.discountType == "Percent") {

                        dish.price -= (dish.price * (dish.discount / 100))
                    }
                    if (dish.discountType == "Fixed") {

                        dish.price -= dish.discount
                    }
                }
                var newDish = this.orderedDishes.filter(d => (d.id == dish.id && (d.discount === dish
                    .discount &&
                    d.discountType === dish.discountType)))[0]

                if (newDish) {
                    console.log(newDish)
                    newDish.quantity += dish.quantity
                } else {
                    this.orderedDishes.push(dish)
                }

                this.computeTotal()
                this.removeSelectedDish()
            },
            removeOrderedDish(index) {
                this.orderedDishes.splice(index, 1)
                this.computeTotal()
            },
            computeTotal() {
                this.total = this.orderedDishes.reduce((total, current) => {
                    return total + (current.price * current.quantity)
                }, 0)
            },
            computeChange() {
                this.change = this.cash - this.total
            },
            placeOrder() {
                this.errors = {}

                if (this.fullName === "" || this.fullName === undefined || this.fullName === null) {
                    this.errors['fullName'] = "Please enter a full name"
                }

                if (this.careOff) {
                    if (this.by === "" || this.by === undefined || this.by === null)
                        this.errors['by'] = "Please input name"
                }

                if (this.cash) {

                    if (this.paymentType === "" || this.paymentType === undefined || this.paymentType === null) {
                        this.errors['payment'] = "Please choose payment type"
                    }
                }

                if (this.orderedDishes.length < 1)
                    this.errors['orders'] = "Please add order"


                if (Object.keys(this.errors).length > 0)
                    return

                this.processing = true
                Livewire.emit('createOrder')
            },
        }
    }

    function formatCurrency(amount) {
        return new Intl.NumberFormat('en-PH', {
            style: 'currency',
            currency: 'PHP'
        }).format(amount);
    }


    window.addEventListener('printOrder', event => {

        Livewire.emit('close');
        var id = event.detail.orderId;
        a = window.open('/print-po/' + id, 'myWin', 'left=50, top=50, width=400, height=800');
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
