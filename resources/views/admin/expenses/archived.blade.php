<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Archived Expense Reports') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <!-- Button to Return to Index -->
                    <div class="mb-4">
                        <a href="{{ route('admin.expenses.index') }}" class="bg-blue-500 text-white px-4 py-2 rounded-md">Back</a>
                    </div>
                    @if (session('status'))
    <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
        {{ session('status') }}
    </div>
@endif
                    <!-- Archived Expense Reports Table -->
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Expense Type</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Item Name</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Expenses</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date & Time</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($archivedExpenses as $expense)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $expense->expense_type }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $expense->item_name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $expense->total_expenses }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $expense->date->format('m-d-Y h:i A') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <form action="{{ route('admin.expenses.unarchive', $expense->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to unarchive this expense report?');">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="text-blue-600 hover:text-blue-900">Unarchive</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
