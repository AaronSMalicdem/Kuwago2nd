<div>
    <x-label for="passcode" :value="__('Passcode')" />
    <div class="flex items-center">

        <x-input id="passcode" class="block mt-1 w-64" type="text" name="passcode" readonly :value="$user->passcode" />
        <x-button class="flex-shrink-0 ml-4" wire:click.prevent="generate">Generate Passcode</x-button>
    </div>
</div>
