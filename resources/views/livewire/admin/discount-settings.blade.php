<div>
    <x-auth-validation-errors />
    <div class="font-medium text-gray-700">
        Discounts
    </div>
    <div>
        <form>
            <div class="flex space-x-2">
                <x-input type="text" class="text-sm" required placeholder="Discount Name" wire:model="name" />
                <x-input type="number" class="text-sm w-40" required placeholder="Discount Value" wire:model="value" />
                <x-select class="text-sm" wire:model="type" required>
                    <option value="" selected hidden disabled>Discount Type</option>
                    <option value="percent">Percent</option>
                    <option value="fixed">Fixed</option>
                </x-select>
                @if($isEditing)
                    <button type="button" class="w-full p-2 bg-green-500 hover:bg-green-300 text-white rounded shadow-sm text-sm" wire:click="updateDiscount">Update</button>
                    <button type="button" class="w-full p-2 bg-yellow-500 hover:bg-yellow-300 text-white rounded shadow-sm text-sm" wire:click="$toggle('isEditing', 0)">Cancel</button>
                @else
                    <button type="button" class="w-full p-2 bg-green-500 hover:bg-green-300 text-white rounded shadow-sm text-sm" wire:click="addDiscount">Add</button>
                @endif

            </div>
        </form>
    </div>
    <div>
        <table class="table w-full border mt-2">
            <thead class="border">
                <tr>
                    <th class="text-center px-3 py-2 text-sm tracking-tight uppercase">Discount Name</th>
                    <th class="text-center px-3 py-2 text-sm tracking-tight uppercase">Discount Value</th>
                    <th class="text-center px-3 py-2 text-sm tracking-tight uppercase">Discount Type</th>
                    <th class="text-center px-3 py-2 text-sm tracking-tight uppercase">Status</th>
                    <th class="text-center px-3 py-2 text-sm tracking-tight uppercase">
                        <span class="sr-only">Action</span>
                    </th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @foreach ($discounts as $d)
                    <tr>
                        <td class="px-3 text-center text-sm">{{ $d->name }}</td>
                        <td class="px-3 text-center text-sm">{{ $d->value }}</td>
                        <td class="px-3 text-center text-sm">{{ $d->type }}</td>
                        <td class="px-3 text-center text-sm">{{ $d->status ? "Active" : "Inactive" }}</td>
                        <td class="px-3 text-center text-sm">
                            @if($d->status)
                                <button class="text-red-500 hover:text-red-300" wire:click="deactiveDiscount({{ $d }})">
                                    <i class="fa fa-times"></i>
                                </button>
                            @else
                                <button class="text-green-500 hover:text-green-300" wire:click="activeDiscount({{ $d }})">
                                    <i class="fa fa-check"></i>
                                </button>
                            @endif
                            <button class="hover:text-gray-300 ml-3" wire:click="editDiscount({{ $d }})">
                                <i class="fa fa-edit"></i>
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
