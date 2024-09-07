<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add Users') }}
        </h2>
    </x-slot>


    <div class='flex flex-col sm:justify-center items-center mt-6 pt-6 sm:pt-0 bg-gray-100'>
        <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
            <!-- Validation Errors -->
            <x-auth-validation-errors class="mb-4" :errors="$errors" />

            <form method="POST" action="{{ route('admin.users.store') }}">
                @csrf

                <div>
                    <x-label for="employee_no" :value="__('Employee No')" />

                    <x-input id="employee_no" class="block mt-1 w-full" type="text" name="employee_no"
                        :value="old('employee_no')" autofocus />
                </div>

                <!-- Name -->
                <div class="mt-4">
                    <x-label for="first_name" :value="__('First Name')" />

                    <x-input id="first_name" class="block mt-1 w-full" type="text" name="first_name"
                        :value="old('first_name')" required autofocus />
                </div>

                <div class="mt-4">
                    <x-label for="middle_name" :value="__('Middle Name')" />

                    <x-input id="middle_name" class="block mt-1 w-full" type="text" name="middle_name"
                        :value="old('middle_name')" autofocus />
                </div>

                <div class="mt-4">
                    <x-label for="last_name" :value="__('Last Name')" />

                    <x-input id="last_name" class="block mt-1 w-full" type="text" name="last_name"
                        :value="old('last_name')" required autofocus />
                </div>

                <!-- Email Address -->
                <div class="mt-4">
                    <x-label for="email" :value="__('Email')" />

                    <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')"
                        required />
                </div>

                <!-- Role -->

                <div class="mt-4">
                    <x-label for="role_id" :value="__('Role')" />

                    <x-select-multiple name="role_id" id="role_id">
                        @foreach ($roles as $role)
                            <option value="{{ $role->id }}" class="text-sm">{{ $role->name }}</option>
                        @endforeach

                    </x-select-multiple>
                </div>

                <!-- Password -->
                <div class="mt-4">
                    <x-label for="password" :value="__('Password')" />

                    <x-input id="password" class="block mt-1 w-full" type="password" name="password" required
                        autocomplete="new-password" />
                </div>

                <!-- Confirm Password -->
                <div class="mt-4">
                    <x-label for="password_confirmation" :value="__('Confirm Password')" />

                    <x-input id="password_confirmation" class="block mt-1 w-full" type="password"
                        name="password_confirmation" required />
                </div>

                <div class="flex items-center justify-end mt-4">

                    <x-button class="ml-4">
                        {{ __('Add') }}
                    </x-button>
                </div>
            </form>
        </div>

    </div>


</x-app-layout>
