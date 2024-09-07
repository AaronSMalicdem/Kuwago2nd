<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dishes') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-5">
                <a type="button" href="{{ route('admin.dishes.create') }}"
                    class="bg-green-500 hover:bg-green-700 py-2 px-3 rounded shadow-sm text-white">Add
                    Dish</a>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="flex flex-col">
                    <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                        <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                            <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                                <livewire:admin.dishes />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
