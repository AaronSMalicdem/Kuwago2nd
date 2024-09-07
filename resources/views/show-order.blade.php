<x-waiter-layout>
    <x-slot name="navbar">
        @include('layouts.order-nav')
    </x-slot>
    @livewire('order.details-new', [ 'order' => $order])

</x-waiter-layout>
