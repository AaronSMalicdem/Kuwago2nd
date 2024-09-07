<div>

    <div class="absolute z-50 inset-0" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-start justify-center h-1/2 pt-4 px-4 text-center sm:block sm:p-0">

            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

            <!-- This element is to trick the browser into centering the modal contents. -->
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <div
                class="inline-block overflow-hidden bg-white rounded-lg text-left shadow-xl transform transition-all w-full max-w-lg">
                <div class="flex flex-col justify-between h-screen">
                    <div class="flex flex-col flex-shrink bg-white py-2 lg:py-4 text-center">
                        {{ $header }}
                    </div>
                    <div class="flex flex-grow overflow-y-auto border">
                        {{ $slot }}
                    </div>


                    <div class="flex flex-shrink items-end bg-gray-50">
                        <div class="flex flex-col px-4 py-3 sm:px-6 justify-center w-full">
                            {{ $footer }}
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>

</div>
