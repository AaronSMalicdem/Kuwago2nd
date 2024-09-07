<div>
    <div x-data="setup()" class="w-full">

        <div class="flex justify-end space-x-3 items-center m-3">

            <button wire:click="prevDate"><i class="fa fa-arrow-left"></i></button>
            <x-input type="date" class="w-auto text-sm" wire:model="date" />
            <button wire:click="nextDate"><i class="fa fa-arrow-right"></i></button>

        </div>

        <ul class="flex justify-start items-center my-4 mx-6">
            <template x-for="(tab, index) in tabs" :key="index">
                <li class="cursor-pointer py-2 px-4 text-gray-500 border-b-8"
                    :class="activeTab===index ? 'text-green-500 border-green-500' : ''" @click="activeTab = index"
                    x-text="tab"></li>
            </template>
        </ul>

        <div class="w-full bg-white">

            <div x-show="activeTab===0" class="overflow-x-auto">

                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Order #</th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Dishes</th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status</th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Total
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Payment
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Cash
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Change
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($orders as $order)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-xs text-gray-900">
                                    {{ $order->order_number }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-gray-900">
                                    <ul class="list-disc">
                                        @foreach ($order->orderDishes() as $item)
                                        <li class="text-xs">{{ $item['dish_name'] }} ({{ $item['qty'] }})</li>
                                        @endforeach
                                    </ul>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-xs text-gray-900">
                                    {{ $order->paid_on ? 'Paid' : 'Not Paid' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    {{ '₱ '. number_format($order->totalPriceWithoutDiscount(), 2, '.', ',') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $order->payment_type }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ '₱ '. number_format($order->cash, 2, '.', ',') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    ₱ {{ number_format($order->change, 2, '.', ',') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center text-sm text-red-500 py-4">No records</td>
                            </tr>
                        @endforelse
                    </tbody>
                    @if($orders->count() > 0)
                    <tfoot>
                        <tr>
                            <td></td>
                            <td class="text-center text-md text-gray-500 py-4">Total GCash</td>
                            <td class="text-right text-md text-gray-500 py-4 px-6">
                                <span>
                                    {{ "P ". number_format($orders->sum(function ($order) { if($order->paid_on && $order->payment_type == 'gcash') return $order->total; }), 2, '.',',') }}
                                </span>
                                <span class="font-bold">
                                    ({{ "P ". number_format($totalGCash, 2, '.',',') }})
                                </span>
                            </td>
                            <td class="text-center text-md text-gray-500 py-4">Total Cash</td>
                            <td class="text-right text-md text-gray-500 py-4 px-6">
                                <span>
                                    {{ "P ". number_format($orders->sum(function ($order) { if($order->paid_on && $order->payment_type == 'cash') return $order->total; }), 2, '.',',') }}
                                </span>
                                <span class="font-bold">
                                    ({{ "P ". number_format($totalCash, 2, '.',',') }})
                                </span>
                            </td>
                            <td class="text-center text-md text-gray-500 py-4">Total</td>
                            <td class="text-right text-md text-gray-500 py-4 px-6">
                                <span>
                                    {{ "P ". number_format($orders->sum('total'), 2, '.',',') }}
                                </span>
                                <span class="font-bold">

                                    ({{ "P ". number_format($total, 2, '.',',') }})
                                </span>
                            </td>
                            <td></td>
                        </tr>
                    </tfoot>
                    @endif
                </table>
                <div class="mx-3 pb-3">
                    {{ $orders->links() }}
                </div>
            </div>

            <div x-show="activeTab===1" class="overflow-x-auto">

                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Order #</th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Dishes</th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status</th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Total
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Payment
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Cash
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Change
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($lateOrders as $o)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-xs text-gray-900">
                                    {{ $o->order_number }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-gray-900">
                                    <ul class="list-disc">
                                        @foreach ($o->orderDishes() as $item)
                                        <li class="text-xs">{{ $item['dish_name'] }} ({{ $item['qty'] }})</li>
                                        @endforeach
                                    </ul>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-xs text-gray-900">
                                    {{ $o->paid_on ? 'Paid' : 'Not Paid' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    {{ '₱ '. number_format($o->totalPriceWithoutDiscount(), 2, '.', ',') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $o->payment_type }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ '₱ '. number_format($o->cash, 2, '.', ',') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    ₱ {{ number_format($o->change, 2, '.', ',') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center text-sm text-red-500 py-4">No records</td>
                            </tr>
                        @endforelse
                    </tbody>
                    @if($lateOrders->count() > 0)
                    <tfoot>
                        <tr>
                            <td></td>
                            <td class="text-center text-md text-gray-500 py-4">Total GCash</td>
                            <td class="text-right text-md text-gray-500 py-4 px-6">
                                <span>
                                    {{ "P ". number_format($lateOrders->sum(function ($order) { if($order->paid_on && $order->payment_type == 'gcash') return $order->total; }), 2, '.',',') }}
                                </span>
                                <span class="font-bold">
                                    ({{ "P ". number_format($lateTotalGCash, 2, '.',',') }})
                                </span>
                            </td>
                            <td class="text-center text-md text-gray-500 py-4">Total Cash</td>
                            <td class="text-right text-md text-gray-500 py-4 px-6">
                                <span>
                                    {{ "P ". number_format($lateOrders->sum(function ($order) { if($order->paid_on && $order->payment_type == 'cash') return $order->total; }), 2, '.',',') }}
                                </span>
                                <span class="font-bold">
                                    ({{ "P ". number_format($lateTotalCash, 2, '.',',') }})
                                </span>
                            </td>
                            <td class="text-center text-md text-gray-500 py-4">Total</td>
                            <td class="text-right text-md text-gray-500 py-4 px-6">
                                <span>
                                    {{ "P ". number_format($lateOrders->sum('total'), 2, '.',',') }}
                                </span>
                                <span class="font-bold">

                                    ({{ "P ". number_format($lateTotal, 2, '.',',') }})
                                </span>
                            </td>
                            <td></td>
                        </tr>
                    </tfoot>
                    @endif
                </table>
                <div class="mx-3 pb-3">
                    {{ $orders->links() }}
                </div>
            </div>

        </div>
    </div>
</div>

<script>
    function setup() {
    return {
      activeTab: 0,
      tabs: [
          "Orders",
          "Paid Receivables",
      ]
    };
  };

</script>
