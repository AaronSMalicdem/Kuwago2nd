<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Users') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <a type="button" href="{{ route('admin.menus.create') }}"
                class="bg-green-500 hover:bg-green-700 py-2 px-3 rounded shadow-sm mb-5 text-white">Add
                Menu</a>
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
                                                Name
                                            </th>
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Description
                                            </th>
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Type
                                            </th>
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Icon
                                            </th>
                                            <th scope="col" class="relative px-6 py-3">
                                                <span class="sr-only">Edit</span>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @forelse ($menus as $menu)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $menu->name }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $menu->description }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $menu->type }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                <div class="flex items-center">
                                                    <div class="flex-shrink-0 h-10 w-10">
                                                        <img class="h-10 w-10 rounded-full"
                                                            src="{{ asset($menu->icon) }}" alt="">
                                                    </div>

                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                <a href="{{ route('admin.menus.show', $menu) }}"
                                                    class="text-green-600 hover:text-green-900 ml-3">Show dishes</a>
                                                <a href="{{ route('admin.menus.edit', $menu) }}"
                                                    class="text-indigo-600 hover:text-indigo-900 ml-3">Edit</a>
                                                    @if($menu->status)
                                                    <a href="#" @click.prevent="selectDelete('form-delete{{$menu->id}}')"
                                                    class="text-red-600 hover:text-red-900 ml-3">Delete</a>
                                                    @else
                                                    <a href="#" @click.prevent="selectDelete('form-restore{{$menu->id}}')"
                                                    class="text-yellow-600 hover:text-yellow-900 ml-3">Restore</a>
                                                    @endif
                                            </td>
                                        </tr>
                                        <form action="{{ route('admin.menus.destroy', $menu) }}" method="post"
                                            id="form-delete{{$menu->id}}">
                                            @csrf
                                            @method('delete')
                                        </form>
                                        <form action="{{ route('admin.menu.restore', $menu) }}" method="post"
                                            id="form-restore{{$menu->id}}">
                                            @csrf
                                            @method('put')
                                        </form>
                                        @empty
                                        <tr>
                                            <td colspan=3 class="text-center font-medium py-4">No records yet!
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
            'modalTitle': 'Delete Menu',
            'modalDescription': 'Are you sure you want to delete this menu?',
            'modalButton': 'Delete',
            selectDelete(id)
            {
                this.modalTitle = 'Delete Menu';
                this.modalDescription = 'Are you sure you want to delete this menu?';
                this.modalButton = 'Delete'
                this.open = true;
                this.formId = id;
            },
            selectRestore(id)
            {
                this.modalTitle = 'Restore Menu';
                this.modalDescription = 'Are you sure you want to restore this menu?';
                this.modalButton = 'Restore'
                this.open = true;
                this.formId = id;
            }
        }

    }

</script>
