<div>
    <div>
        @can('manage')
            <x-session-message />
        @endcan

        <div class="my-5">
            <div class="w-full shadow-lg rounded-lg">
                <div class="py-2 px-4 bg-blue-400 rounded-t-lg flex justify-between items-center">
                    <strong class="text-white"> {{ __('ORDERS') }} </strong>

                    <div>
                        <x-input type="text" wire:model="search" class="text-sm" placeholder="Search Name..." />
                        <a href="{{ route('orders.create') }}" class="text-white">
                            <i class="fa fa-plus"></i>
                        </a>
                    </div>

                </div>
                <div class="p-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-4 sm:gap-5">
                        @foreach ($orders as $order)
                            <livewire:order.other-table :order="$order" key="takeOut-{{ $order->id }}" />
                        @endforeach
                    </div>
                </div>
                <div class="px-4 pb-2">
                    {{ $orders->links() }}
                </div>

            </div>

            <div class="w-full shadow-lg rounded-lg mt-5">
                <div class="py-2 px-4 bg-blue-400 rounded-t-lg flex justify-between items-center">
                    <strong class="text-white"> {{ __('UNPAID ORDERS') }} </strong>
                    <x-input type="text" wire:model="unpaidSearch" class="text-sm" placeholder="Search Name..." />
                </div>

                <div class="p-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-4 sm:gap-5">
                        @foreach ($unpaidOrders as $unpaid)
                            <livewire:order.other-table :order="$unpaid" key="takeOut-{{ $unpaid->id }}" />
                        @endforeach
                    </div>
                </div>
                <div class="px-4 pb-2">
                    {{ $unpaidOrders->links() }}
                </div>
            </div>
        </div>

    </div>
</div>
