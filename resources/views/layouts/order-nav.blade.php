<nav x-data="{ open: false }" class="bg-white border-b border-gray-100 shadow-md top-0 z-50">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="flex-shrink-0 flex items-center">

                    <div class="text-left">
                        <div class="font-extrabold">
                            Order # {{ $order->order_number ?? $config->order_no }}
                        </div>
                        <div class="text-sm text-gray-500">
                            Order
                        </div>
                    </div>
                </div>

            </div>
            <div class="flex items-center">
                <a href="/waiter-order">
                    <i class="fa fa-times"></i>
                </a>
            </div>
        </div>
    </div>
</nav>
