<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Expense Reports') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <!-- Date Range Filter Form -->
                    <div class="mb-4 flex justify-end items-center space-x-4">
                        <form action="{{ route('admin.expenses.index') }}" method="GET" class="flex items-center space-x-2">
                            <label for="start_date" class="text-gray-700 text-sm font-medium">Start Date:</label>
                            <input type="date" id="start_date" name="start_date" value="{{ request('start_date') }}" class="form-input border border-gray-300 rounded-md p-2">
                            
                            <label for="end_date" class="text-gray-700 text-sm font-medium">End Date:</label>
                            <input type="date" id="end_date" name="end_date" value="{{ request('end_date') }}" class="form-input border border-gray-300 rounded-md p-2">
                            
                            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md">Filter</button>
                        </form>
                    </div>

                    <!-- Buttons for Creating New Report and Viewing Archives -->
                    <div class="mb-4 flex justify-between items-center">
                        <!-- Button to Create New Expense Report on the left -->
                        <a href="{{ route('admin.expenses.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded-md">Create Expense Report</a>

                        <!-- Archives Button on the right -->
                        <a href="{{ route('admin.expenses.archived') }}" class="bg-gray-500 text-white px-4 py-2 rounded-md">Archives</a>
                    </div>

                    <!-- Expense Reports Table -->
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Expense Type</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Item Name</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Expenses</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date & Time</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($expenses as $expense)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $expense->expense_type }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $expense->item_name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $expense->total_expenses }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $expense->date->format('m-d-Y h:i A') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <a href="{{ route('admin.expenses.edit', $expense->id) }}" class="text-blue-500 hover:underline">Edit</a>
                                        <form action="{{ route('admin.expenses.archive', $expense->id) }}" method="POST" style="display:inline-block;">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="text-red-500 hover:underline ml-2">Archive</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <!-- Total Expenses -->
                    <div class="mt-4 flex justify-end items-center">
                        <span class="text-lg font-semibold">Total Expenses: ₱&nbsp;{{ $totalExpenses }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
