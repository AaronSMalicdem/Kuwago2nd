<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Reports') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-2 lg:px-4">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="py-6 bg-white border-b border-gray-200">
                    <div class="px-6">
                        Reports
                    </div>
                    @livewire('auth.report')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
