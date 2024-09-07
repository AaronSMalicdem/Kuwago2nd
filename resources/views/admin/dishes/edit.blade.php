<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Dish') }}
        </h2>
    </x-slot>


    <div class='flex flex-col sm:justify-center items-center mt-6 pt-6 sm:pt-0 bg-gray-100'>
        <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
            <!-- Validation Errors -->
            <x-auth-validation-errors class="mb-4" :errors="$errors" />

            <form method="POST" action="{{ route('admin.dishes.update', $dish) }}" enctype="multipart/form-data">
                @csrf
                @method('put')
                <div>
                    <x-label for="category_id" :value="__('Menu Category')"></x-label>
                    <x-select name="category_id" id="category_id" class="block mt-1 w-full font-medium text-sm">
                        <option selected disabled>Select Category</option>
                        @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ $category->id == $dish->category_id ? 'selected' : '' }}>
                            {{ $category->name }}</option>
                        @endforeach
                    </x-select>
                </div>

                <!-- Name -->
                <div class="mt-4">
                    <x-label for="name" :value="__('Dish Name')" />

                    <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="$dish->name" required
                        autofocus />
                </div>

                <div class="mt-4">
                    <x-label for="properties" :value="__('Properties')" />

                    <x-textarea class="block mt-1 w-full" id="properties" name="properties" rows="5">
                        {{ $dish->properties }}
                    </x-textarea>
                </div>

                <div class="mt-4">
                    <x-label for="price" :value="__('Dish Price')" />

                    <x-input id="price" class="block mt-1 w-full" type="number" name="price" min=1 step=0.01
                        :value="$dish->price" required autofocus />
                </div>

                <div class="flex items-center justify-end mt-4">

                    <x-button class="ml-4">
                        {{ __('Edit') }}
                    </x-button>
                </div>
            </form>
        </div>

    </div>


</x-app-layout>
