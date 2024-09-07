<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Users') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <a type="button" href="{{ route('admin.users.create') }}"
                class="bg-green-500 hover:bg-green-700 py-2 px-3 rounded shadow-sm mb-5 text-white">Add
                User</a>
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
                                                Employee No
                                            </th>
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Role
                                            </th>
                                            <th scope="col" class="relative px-6 py-3">
                                                <span class="sr-only">Edit</span>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @forelse ($users as $user)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <div class="flex-shrink-0 h-10 w-10">
                                                        <img class="h-10 w-10 rounded-full"
                                                            src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=4&w=256&h=256&q=60"
                                                            alt="">
                                                    </div>
                                                    <div class="ml-4">
                                                        <div class="text-sm font-medium text-gray-900">
                                                            {{ $user->full_name }}
                                                        </div>
                                                        <div class="text-sm text-gray-500">
                                                            {{ $user->email }}
                                                        </div>

                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $user->employee_no }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $user->role->name }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                <a href="{{ route('admin.users.show', $user) }}"
                                                    class="text-blue-600 hover:text-blue-900">Show</a>
                                                @can('is-admin')
                                                <a href="{{ route('admin.users.edit', $user) }}"
                                                    class="text-indigo-600 hover:text-indigo-900 ml-3">Edit</a>
                                                @if(!$user->trashed())
                                                <a href="#" @click.prevent="selectDelete('form-delete{{$user->id}}')"
                                                    class="text-red-600 hover:text-red-900 ml-3">Deactivate</a>
                                                @else
                                                <a href="{{ route('admin.users.restore', $user->id) }}"
                                                    class="text-green-600 hover:text-green-900 ml-3">Activate</a>
                                                @endif
                                                @endcan
                                            </td>
                                        </tr>
                                        <form action="{{ route('admin.users.destroy', $user) }}" method="post"
                                            id="form-delete{{$user->id}}">
                                            @csrf
                                            @method('delete')
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
            'modalTitle': 'Deactivate',
            'modalDescription': 'Are you sure you want to deactivate your account?',
            'modalButton': 'Deactivate',
            selectDelete(id)
            {
                this.open = true;
                this.formId = id;
            },
        }

    }

</script>
