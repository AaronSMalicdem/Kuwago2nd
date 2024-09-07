<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tables') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <a type="button" href="{{ route('admin.tables.create') }}"
                class="bg-green-500 hover:bg-green-700 py-2 px-3 rounded shadow-sm mb-5 text-white">Add
                Table</a>
            <x-session-message />
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="flex flex-col">
                    <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                        <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                            <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg" x-data="modal()">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Table
                                            </th>
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Number of Pax
                                            </th>
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Description
                                            </th>
                                            <th scope="col" class="relative px-6 py-3">
                                                <span class="sr-only">Edit</span>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @forelse ($tables as $table)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $table->name }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $table->pax }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {!! $table->description !!}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                <a href="{{ route('admin.tables.edit', $table) }}"
                                                    class="text-indigo-600 hover:text-indigo-900 ml-3">Edit</a>
                                                <a href="#" @click.prevent="selectDelete('form-delete{{$table->id}}')"
                                                    class="text-red-600 hover:text-red-900 ml-3">Delete</a>
                                            </td>
                                        </tr>
                                        <form action="{{ route('admin.tables.destroy', $table) }}" method="post"
                                            id="form-delete{{$table->id}}">
                                            @csrf
                                            @method('delete')
                                        </form>
                                        @empty
                                        <tr>
                                            <td colspan=4 class="text-center font-medium py-4">No records yet!
                                            </td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                                <x-dialog />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
    function modal()
    {
        return {
            'open': false,
            'formId': '',
            'modalTitle': 'Delete Table',
            'modalDescription': 'Are you sure you want to delete this table?',
            'modalButton': 'Delete',
            selectDelete(id)
            {
                this.open = true;
                this.formId = id;
            },
        }

    }

</script>
