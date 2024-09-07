<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add Menu') }}
        </h2>
    </x-slot>


    <div class='flex flex-col sm:justify-center items-center mt-6 pt-6 sm:pt-0 bg-gray-100'>
        <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
            <!-- Validation Errors -->
            <x-auth-validation-errors class="mb-4" :errors="$errors" />

            <form method="POST" action="{{ route('admin.menus.store') }}" enctype="multipart/form-data">
                @csrf

                <!-- Name -->
                <div>
                    <x-label for="name" :value="__('Menu Name')" />

                    <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required
                        autofocus />
                </div>

                <div class="mt-4">
                    <x-label for="description" :value="__('Description')" />

                    <x-textarea class="block mt-1 w-full" id="description" name="description" rows="5">
                        {{ old('description') }}
                    </x-textarea>
                </div>

                <div class="mt-4">
                    <x-label for="type" :value="__('Type')"></x-label>
                    <x-select name="type" id="type" class="block mt-1 w-full font-medium text-sm">
                        <option selected disabled>Select Type</option>
                        <option value="foods">Foods</option>
                        <option value="drinks">Drinks</option>
                        <option value="alcoholic">Alcoholic Drinks</option>
                    </x-select>
                </div>

                <div class="mt-4">
                    <x-label for="icon" :value="__('Icon')" />

                    <x-input id="icon" class="block mt-1 w-full p-3" type="file" name="icon" :value="old('icon')"
                        autofocus />
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
