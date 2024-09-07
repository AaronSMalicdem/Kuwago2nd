<nav x-data="{ open: false }" class="bg-white border-b border-gray-100 shadow-md sticky top-0 z-40">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="flex-shrink-0 flex items-center">

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="flex-shrink-0 flex items-center focus:border-transparent"
                            onclick="event.preventDefault();
                            this.closest('form').submit();">
                            <x-application-logo class="block h-10 w-auto fill-current text-gray-600" />
                            <span class="ml-2 uppercase font-bold">
                                {{ __('Log Out') }}
                            </span>
                        </button>

                    </form>
                </div>

            </div>
            <div class="flex items-center">
                <div class="text-right">
                    <div class="font-extrabold uppercase">
                        {{ Auth::user()->full_name }} | {{ Auth::user()->employee_no }}
                    </div>
                    @can('manage')
                        <div class="text-xs underline text-purple-500">
                            <a href="{{ route('dashboard') }}">{{ __('Go to Dashboard') }}</a>
                        </div>
                    @endcan
                    @can('waiter')
                        <div class="text-xs underline text-purple-500">
                            <a href="{{ route('waiter.dashboard') }}">{{ __('Go to Dashboard') }}</a>
                        </div>
                    @endcan
                </div>
            </div>
        </div>
    </div>
</nav>
