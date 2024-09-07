<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Expense Report') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form method="POST" action="{{ route('admin.expenses.update', $expense->id) }}">
                        @csrf
                        @method('PATCH')

                        <!-- Expense Type -->
                        <div class="mb-4">
                            <label for="expense_type" class="block text-gray-700 text-sm font-medium mb-2">
                                Expense Type
                            </label>
                            <select name="expense_type" id="expense_type" class="form-select w-full border border-gray-300 rounded-md p-2">
                                <option value="Supply" {{ $expense->expense_type == 'Supply' ? 'selected' : '' }}>Supply</option>
                                <option value="Advertisement" {{ $expense->expense_type == 'Advertisement' ? 'selected' : '' }}>Advertisement</option>
                                <option value="Spills" {{ $expense->expense_type == 'Spills' ? 'selected' : '' }}>Spills</option>
                                <option value="Others" {{ $expense->expense_type == 'Others' ? 'selected' : '' }}>Others</option>
                            </select>
                        </div>

                        <!-- Item Name -->
                        <div class="mb-4">
                            <label for="item_name" class="block text-gray-700 text-sm font-medium mb-2">
                                Item Name
                            </label>
                            <input type="text" name="item_name" id="item_name" value="{{ old('item_name', $expense->item_name) }}" class="form-input w-full border border-gray-300 rounded-md p-2" placeholder="Enter item name">
                        </div>

                        <!-- Total Expenses -->
                        <div class="mb-4">
                            <label for="total_expenses" class="block text-gray-700 text-sm font-medium mb-2">
                                Total Expenses
                            </label>
                            <input type="number" name="total_expenses" id="total_expenses" value="{{ old('total_expenses', $expense->total_expenses) }}" class="form-input w-full border border-gray-300 rounded-md p-2" placeholder="Enter total expenses">
                        </div>

                        <!-- Date & Time -->
                        <div class="mb-4">
                            <label for="date" class="block text-gray-700 text-sm font-medium mb-2">
                                Date & Time
                            </label>
                            <input type="datetime-local" name="date" id="date" value="{{ old('date', $expense->date->format('Y-m-d\TH:i')) }}" class="form-input w-full border border-gray-300 rounded-md p-2">
                        </div>

                        <div class="flex justify-end">
                            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md">Update Expense Report</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
