<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Report') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-2 lg:px-4">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="py-6 bg-white border-b border-gray-200">
                    <div class="px-6" x-data="setup()">

                        <div class="text-right">
                            <x-button type="button" wire:click="save()">Save Report</x-button>
                        </div>

                        <div class="flex justify-end mx-6 py-2">

                            <div class="flex space-x-3 items-center">
                                <button wire:click="prevDate"><i class="fa fa-arrow-left"></i></button>
                                <x-input type="date" class="w-auto text-sm" wire:model="date" />
                                <button wire:click="nextDate"><i class="fa fa-arrow-right"></i></button>
                            </div>
                        </div>

                        @error('remit')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror

                        <div class="grid grid-flow-row grid-cols-2 gap-4">
                            @foreach ($overalls as $overall)
                                <div>
                                    <span class="uppercase">

                                        {{ $overall->name }}
                                    </span>
                                    <table class="min-w-full divide-y divide-gray-200">
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <th scope="col"
                                                    class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider text-center w-1/4">
                                                    Item</th>
                                                <th scope="col"
                                                    class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider text-center w-1/4">
                                                </th>
                                                <th scope="col"
                                                    class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider text-center">
                                                    Quantity</th>
                                                <th scope="col"
                                                    class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider text-center">
                                                    Discount</th>
                                                <th scope="col"
                                                    class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider text-center">
                                                    Total</th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-200">
                                            @foreach ($overall->dishes as $dish)
                                                <tr>
                                                    <td class="px-2 py-4 text-sm text-gray-900">
                                                        {{ $dish->name }}
                                                    </td>
                                                    <td class="px-2 py-4 text-sm text-gray-900 text-center">
                                                        {{ $dish->properties }}
                                                    </td>
                                                    <td
                                                        class="px-2 py-4 whitespace-nowrap text-sm text-gray-900 text-center">
                                                        {{ $dish->orderDetails->sum('pcs') }}
                                                    </td>
                                                    <td class="px-2 py-4 whitespace-nowrap text-sm text-right">
                                                        ({{ '₱ ' . number_format($dish->getTotalDiscount(), 2, '.', ',') }})
                                                    </td>
                                                    <td class="px-2 py-4 whitespace-nowrap text-sm text-right">
                                                        {{ '₱ ' . number_format($dish->getTotalSales(), 2, '.', ',') }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot class="bg-gray-50">
                                            <tr>
                                                <td class="px-2 py-4 whitespace-nowrap">Total</td>
                                                <td></td>
                                                <td></td>
                                                <td class="px-2 py-4 whitespace-nowrap text-red-500 text-sm text-right">
                                                    ({{ '₱ ' .number_format($overall->dishes->sum(function ($dish) {return $dish->getTotalDiscount();}),2,'.',',') }})
                                                </td>
                                                <td class="px-2 py-4 whitespace-nowrap font-bold text-lg text-right">
                                                    {{ '₱ ' .number_format($overall->dishes->sum(function ($dish) {return $dish->getTotalSales();}),2,'.',',') }}
                                                </td>
                                            </tr>
                                        </tfoot>
                                    </table>

                                </div>
                            @endforeach

                            <div>
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th scope="col"
                                                class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider text-center w-full">
                                                Spoilage</th>
                                            <th scope="col"
                                                class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider text-center w-20">
                                                Quantity</th>
                                            <th scope="col" class="relative px-6 py-3">
                                                <div>
                                                    <button type="button"
                                                        class="bg-green-500 hover:bg-green-300 text-white rounded shadow-sm h-10 w-10 items-center"
                                                        @click="addSpoilage">+</button>
                                                </div>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        <template x-for="(spoil, index) in spoilages" :key="index">
                                            <tr>
                                                <td class="whitespace-nowrap text-sm text-gray-900">
                                                    <x-select x-model="spoil.dish" class="w-full block">
                                                        <option value=" " hidden>Select</option>
                                                        <template x-for="(dish, i) in dishes" :key="i">
                                                            <option :value="dish.name + ` | ` + dish.properties"
                                                                x-text="dish.name + ` | ` + dish.properties"></option>
                                                        </template>
                                                    </x-select>
                                                </td>
                                                <td class="whitespace-nowrap text-sm text-gray-900 text-center">
                                                    <x-input type="text" x-model="spoil.quantity" class=" w-20">
                                                    </x-input>
                                                </td>
                                                <td class="whitespace-nowrap text-sm text-gray-900 text-center">
                                                    <div>
                                                        <button type="button"
                                                            class="bg-red-500 hover:bg-red-300 text-white rounded shadow-sm h-10 w-10 items-center"
                                                            @click="removeSpoilage(index)">-</button>
                                                    </div>
                                                </td>
                                            </tr>
                                        </template>
                                    </tbody>
                                </table>
                            </div>

                        </div>

                        <hr class="my-2 py-2 text-black h-5">


                        <div class="mb-1 flex justify-between px-3">
                            <div class="font-bold">
                                Total Discount
                            </div>
                            <div class='flex justify-between w-1/3'>
                                <div>
                                    ₱
                                </div>
                                <div class="text-red-500">
                                    ({{ number_format($totalDiscount, 2, '.', ',') }})
                                </div>
                            </div>

                        </div>

                        <hr>

                        <div>

                        </div>

                        <hr>

                        <div class="px-3 font-bold">
                            Sales
                        </div>

                        <hr>

                        <div>
                            @foreach ($overalls as $overall)
                                <div class="mb-1 flex justify-between px-3">
                                    <div>
                                        {{ $overall->name }}
                                    </div>
                                    <div class='flex justify-between w-1/3'>
                                        <div>
                                            ₱
                                        </div>
                                        <div>
                                            {{ number_format($overall->dishes->sum(function ($dish) {return $dish->getTotalSales();}),2,'.',',') }}
                                        </div>
                                    </div>

                                </div>
                            @endforeach

                            <hr>

                            <div class="flex items-center justify-between px-3 py-1">
                                <div class="ml-5">
                                    Cash
                                </div>
                                <div class="flex justify-between w-1/3">
                                    <div>
                                        ₱
                                    </div>
                                    <div>
                                        <span x-text="getCash()"></span>
                                    </div>
                                </div>
                            </div>

                            <div class="flex justify-between px-3 py-1">
                                <div class="ml-5">
                                    GCash
                                </div>
                                <div class="flex justify-between w-1/3">
                                    <div>
                                        ₱
                                    </div>
                                    <div>
                                        <span x-text="getGcash()"></span>
                                    </div>
                                </div>
                            </div>


                            <div class="flex justify-between px-3 py-1">
                                <div class="ml-5">
                                    Receivables
                                </div>
                                <div class="flex justify-between w-1/3">
                                    <div>
                                        ₱
                                    </div>
                                    <div>
                                        <span x-text="getTotalUnpaid()"></span>
                                    </div>
                                </div>
                            </div>


                            <hr>

                            <div class="flex justify-between font-bold px-3 py-1">
                                <div>
                                    Total Sales
                                </div>
                                <div class="flex justify-between w-1/3">
                                    <div>
                                        ₱
                                    </div>
                                    <div>
                                        <span x-text="getTotalSales()"></span>
                                    </div>
                                </div>
                            </div>

                            <hr>

                            @if ($latePayments->count() > 0)

                                <div class="px-3 font-bold mt-5">
                                    Paid Receivables
                                </div>

                                <hr>

                                @foreach ($latePayments as $late)
                                    <div class="flex items-center justify-between px-3 mb-1">
                                        <div>
                                            {{ $late->full_name }} {{ $late->by ? "care off {$late->by}" : '' }}
                                            ({{ $late->created_at->format('M d') }})
                                            - {{ $late->payment_type }}
                                        </div>
                                        <div class="flex justify-between w-1/3">
                                            <div>
                                                ₱
                                            </div>
                                            <div>
                                                {{ number_format($late->total, 2, '.', ',') }}
                                            </div>
                                        </div>
                                    </div>
                                @endforeach

                                <hr>

                                <div class="flex justify-between font-bold px-3 py-1">
                                    <div>
                                        Total Paid Receivables
                                    </div>
                                    <div class="flex justify-between w-1/3">
                                        <div>
                                            ₱
                                        </div>
                                        <div>
                                            <span x-text="getLate()"></span>
                                        </div>
                                    </div>
                                </div>

                            @endif

                            <hr>

                            <div class="flex justify-between font-bold px-3 py-1 mt-5">
                                <div>
                                    Gross Income
                                </div>
                                <div class="flex justify-between w-1/3">
                                    <div>
                                        ₱
                                    </div>
                                    <div>
                                        <span x-text="getGrossIncome()"></span>
                                    </div>
                                </div>
                            </div>

                            <div class="flex justify-between px-3 py-1 mt-5">
                                <div>
                                    Less: Purchases
                                </div>
                                <div>
                                    <button type="button"
                                        class="bg-green-500 hover:bg-green-300 text-white rounded shadow-sm h-5 w-5 flex justify-center items-center"
                                        @click="addPurchase">+</button>
                                </div>
                            </div>

                            <template x-for="(purchase, index) in purchases" :key="index">
                                <div class="flex justify-between px-3 py-1">
                                    <div class="w-1/2 flex items-center space-x-2">
                                        <button type="button"
                                            class="bg-red-500 hover:bg-red-300 text-white rounded shadow-sm h-5 w-5 flex justify-center items-center"
                                            @click="removePurchase(index)">-</button>
                                        <x-input type="text" x-model="purchase.name" class="block w-full">
                                        </x-input>
                                    </div>
                                    <div>
                                        <x-input type="number" x-model.number="purchase.price" class="block w-full"
                                            min=0></x-input>
                                    </div>
                                </div>
                            </template>

                            <hr class="mt-5">

                            <div class="flex justify-between px-3 font-bold py-1 bg-green-500 rounded">
                                <div>
                                    Net Income
                                </div>
                                <div class="flex justify-between w-1/3">
                                    <div>
                                        ₱
                                    </div>
                                    <div>
                                        <span x-text="getTotalRemittance()"></span>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    function setup() {
        return {
            date1: @entangle('date'),
            date2: @entangle('date2'),
            spoilages: @entangle('spoilages').defer,
            purchases: @entangle('purchases').defer,
            dishes: @entangle('dishes').defer,
            remit: @entangle('remit').defer,
            total: @entangle('total'),
            late: @entangle('lateTotal'),
            gcash: @entangle('gcash'),
            cash: @entangle('cash'),
            totalRemittance: @entangle('totalRemittance').defer,
            totalPurchases: @entangle('totalPurchases').defer,
            totalUnpaid: @entangle('totalUnpaid').defer,
            gross: 0,
            init() {
                this.totalRemittance = 0
            },
            addSpoilage() {
                this.spoilages.push({
                    'dish': '',
                    'quantity': 1,
                })
            },
            removeSpoilage(index) {
                this.spoilages.splice(index, 1)
            },
            addPurchase() {
                this.purchases.push({
                    'name': '',
                    'price': 0,
                })
            },
            removePurchase(index) {
                this.purchases.splice(index, 1)
            },
            getLate() {
                return numberWithCommas(this.late)
            },
            getTotalPurchase() {
                this.totalPurchases = 0
                this.purchases.forEach(element => {
                    this.totalPurchases += element.price
                });

                return numberWithCommas(this.totalPurchases)
            },
            getTotalUnpaid() {
                return numberWithCommas(this.totalUnpaid)
            },
            getTotalSales() {
                return numberWithCommas(this.total)
            },
            getCash() {
                return numberWithCommas(this.cash);
            },
            getGcash() {
                return numberWithCommas(this.gcash)
            },
            getGrossIncome() {
                this.gross = this.total + this.late
                return numberWithCommas(this.gross)
            },
            getTotalRemittance() {
                this.totalPurchases = 0
                this.purchases.forEach(element => {
                    this.totalPurchases += element.price
                });

                this.totalRemittance = this.gross - this.totalPurchases
                return numberWithCommas(this.totalRemittance)
            },
        }
    };

    function numberWithCommas(x) {
        return x.toFixed(2).toString().replace(/\B(?<!\.\d*)(?=(\d{3})+(?!\d))/g, ",");
    }
</script>
