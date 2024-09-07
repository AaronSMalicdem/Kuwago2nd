<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Users') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-session-message />
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="flex flex-col">
                    <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                        <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                            <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                                <div class="p-6">
                                    @livewire('generate-passcode', ['user' => $user])
                                    <div class="mt-3">
                                        <span>
                                            {{ __('Assign Table for: ') }}{{ $user->full_name }}
                                        </span>
                                        <form action="{{ route('admin.users.assign.table', $user) }}" method="post">
                                            @csrf
                                            <div class="flex flex-col mt-2">
                                                @foreach ($tables as $i => $table)
                                                <div class="flex items-center mb-2 space-x-4">
                                                    <x-input type="checkbox" value="{{ $table->id }}" name="tables[]"
                                                        :checked="$user->assignTables->find($table->id)"
                                                        id="table{{ $i }}" />
                                                    <label for="table{{ $i }}">{{ $table->name }}</label>
                                                </div>
                                                @endforeach
                                                <x-button class="w-32">Assign</x-button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
