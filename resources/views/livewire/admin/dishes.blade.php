<div x-data="modal()">

    <div class="px-4 py-2 w-auto">
        <div class="flex items-center space-x-2">
            <span class="text-xs w-32">
                {{ __('Select Category') }}
            </span>
            <x-select name="category_id" wire:model="category" id="category_id" class="block mt-1 font-medium text-sm">
                <option value="0" selected>Select All</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </x-select>
        </div>

        <div class="flex items-center space-x-2">
            <span class="text-xs w-32">
                {{ __('Show Pages') }}
            </span>
            <x-select name="pages" wire:model="pages" id="pages" class="block mt-1 font-medium text-sm">
                @foreach ([10, 25, 50, 100, 'All'] as $page)
                    <option value="{{ $page }}">{{ $page }}</option>
                @endforeach
            </x-select>
        </div>

    </div>

    <div class="flex justify-end items-center px-4 py-2">
        <x-input type="text" wire:model="search" placeholder="Search...."></x-input>
    </div>

    <div class="px-4 py-2 w-full">
        {{ $dishes->links() }}
    </div>

    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th scope="col"
                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Category
                </th>
                <th scope="col"
                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Name
                </th>
                <th scope="col"
                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Properties
                </th>
                <th scope="col"
                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Price
                </th>
                <th scope="col"
                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Status
                </th>
                <th scope="col" class="relative px-6 py-3">
                    <span class="sr-only">Edit</span>
                </th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @forelse ($dishes as $dish)
                <tr class="{{ !$dish->status ? 'bg-red-200' : '' }}">
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{ $dish->category->name }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{ $dish->name }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{ $dish->properties }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{ $dish->price_formatted }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{ $dish->status == 0 ? 'Unavailable' : 'Available' }}
                    </td>

                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <a href="{{ route('admin.dishes.edit', $dish) }}"
                            class="text-indigo-600 hover:text-indigo-900 ml-3">Edit</a>

                        @if ($dish->status == 1)
                            <a href="#" wire:click.prevent="deactivate({{ $dish }})"
                                class="text-red-600 hover:text-red-900 ml-3">Deactivate</a>
                        @else
                            <a href="#" wire:click.prevent="restore({{ $dish }})"
                                class="text-green-600 hover:text-green-900 ml-3">Restore</a>
                        @endif
                    </td>
                </tr>
                <form action="{{ route('admin.dishes.deactivate', $dish) }}" method="post"
                    id="form-delete{{ $dish->id }}">
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
    <div class="px-4 py-2">
        {{ $dishes->links() }}
    </div>
    <x-dialog />
</div>
{{-- x-on:click="selectDelete('form-delete{{$dish->id}}')" --}}
<script>
    function modal() {
        return {
            'open': false,
            'formId': '',
            'modalTitle': 'Remove Dish',
            'modalDescription': 'Are you sure you want to remove this dish?',
            'modalButton': 'Remove',
            selectDelete(id) {
                this.open = true;
                this.formId = id;
            },
        }
    }
</script>
