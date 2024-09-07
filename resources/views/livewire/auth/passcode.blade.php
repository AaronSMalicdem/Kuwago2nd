<div>
    @if($isModalOpen)
    <!-- This example requires Tailwind CSS v2.0+ -->
    <div class="fixed z-50 inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0"
            x-data="{ 'passcode' : @entangle('passcode').defer }">
            <!--
        Background overlay, show/hide based on modal state.

        Entering: "ease-out duration-300"
          From: "opacity-0"
          To: "opacity-100"
        Leaving: "ease-in duration-200"
          From: "opacity-100"
          To: "opacity-0"
      -->
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

            <!-- This element is to trick the browser into centering the modal contents. -->
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <!--
        Modal panel, show/hide based on modal state.

        Entering: "ease-out duration-300"
          From: "opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
          To: "opacity-100 translate-y-0 sm:scale-100"
        Leaving: "ease-in duration-200"
          From: "opacity-100 translate-y-0 sm:scale-100"
          To: "opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
      -->
            <div
                class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div>
                        <div
                            class="flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 mx-auto sm:h-10 sm:w-10">
                            <!-- Heroicon name: outline/exclamation -->
                            <x-application-logo class="fill-current text-gray-500" />
                        </div>
                        <div class="mt-3 text-center sm:text-left">
                            <form method="post" wire:submit.prevent="enterPasscode">
                                @csrf
                                <x-input type="password" class="w-full text-center" x-model="passcode" name="passcode"
                                    wire:model="passcode" readonly />
                                @error('passcode') <span
                                    class="text-xs text-red-500 flex justify-center">{{ $message }}</span>
                                @enderror
                                <div class="mt-3">
                                    <div class="grid grid-cols-3 gap-4">
                                        <template x-for="i in 9">
                                            <x-passcode-button
                                                @click.prevent="passcode.length > 5 ? passcode : passcode += i"
                                                x-text="i">
                                            </x-passcode-button>
                                        </template>

                                        <x-passcode-button @click.prevent="passcode = passcode.slice(0,-1)">Del
                                        </x-passcode-button>
                                        <x-passcode-button
                                            @click.prevent="passcode.length > 5 ? passcode : passcode += 0">0
                                        </x-passcode-button>
                                        <x-passcode-button type="submit">OK
                                        </x-passcode-button>
                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="button" wire:click="close"
                        class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
