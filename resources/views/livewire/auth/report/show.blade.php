<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Show Report') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-2 lg:px-4">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="py-6 bg-white border-b border-gray-200">
                    <div class="px-6" x-data="setup()">

                        <div class="flex justify-end mx-6 py-2">

                            <div class="flex space-x-3 items-center">

                                <x-input type="date" class="w-auto text-sm" wire:model="date" disabled />

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

                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach ($spoilages as $spoilage)
                                            <tr>
                                                <td class="whitespace-nowrap text-sm text-gray-900">
                                                    {{ $spoilage['dish'] }}
                                                </td>
                                                <td class="whitespace-nowrap text-sm text-gray-900 text-center">
                                                    {{ $spoilage['quantity'] }}
                                                </td>

                                            </tr>
                                        @endforeach
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
                                            {{ number_format($overall->dishes->sum(function ($dish) {return $dish->orderDetails->sum('price');}),2,'.',',') }}
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

                            @if (!empty($latePayments) || count($latePayments) > 0)

                                <div class="px-3 font-bold mt-5">
                                    Paid Receivables
                                </div>

                                <hr>

                                @foreach ($latePayments as $late)
                                    <div class="flex items-center justify-between px-3">
                                        <div>
                                            {{ $late['name'] }}
                                        </div>
                                        <div class="flex justify-between w-1/3">
                                            <div>
                                                ₱
                                            </div>
                                            <div>
                                                {{ $late['price'] }}
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
                            </div>

                            @foreach ($purchases as $purchase)
                                <div class="flex justify-between px-3 py-1">
                                    <div class="w-1/2 flex items-center space-x-2 ml-5">
                                        {{ $purchase['name'] }}
                                    </div>
                                    <div class="flex justify-between w-1/3">
                                        <div>
                                            ₱
                                        </div>
                                        <div>
                                            {{ number_format($purchase['price'], 2, '.', ',') }}
                                        </div>
                                    </div>

                                </div>
                            @endforeach

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
            getLate() {
                return numberWithCommas(this.late)
            },
            getTotalPurchase() {
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

                this.totalRemittance = this.gross - this.totalPurchases
                return numberWithCommas(this.totalRemittance)
            },
        }
    };

    function numberWithCommas(x) {
        return x.toFixed(2).toString().replace(/\B(?<!\.\d*)(?=(\d{3})+(?!\d))/g, ",");
    }
</script>
