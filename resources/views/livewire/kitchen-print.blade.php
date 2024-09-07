<div>
    <div wire:poll.1000ms>
        {{now()->format('l, F d, Y h:i:s a')}}
    </div>
    <div>
        Kitchen
    </div>
    <div>

        New Order: {{ $order->order_number ?? "No Order Yet" }}
    </div>
    <div>
        Server: {{ $order->waiter->name ?? "No Order Yet" }}
    </div>

    <button onclick="ajax_print()" class="bg-green-500 px-2 py-1 text-xs text-white">Print</button>


    <x-slot name="script">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script>

            Echo.channel('kitchenPrint')
                .listen('PrintKitchenEvent', (event) => {
                    // a = window.open('/print-kitchen/'+event.order.id, 'myWin', 'left=50, top=50, width=400, height=800');
                    // a.screenX = 0;
                    // a.screenY = 0;
                    // a.document.title = "Print";
                    // a.focus();
                    // setTimeout(() => {
                    //     a.close();
                    // }, 1000);
                    var url = "{{ url('/print-kitchen') }}/" + event.order.id;
                    $.get(url, function (data) {
                        window.location.href = data;
                    });
                })
            function ajax_print()
            {
                var url = "{{ url('/print-kitchen') }}/" + 3;
                window.open(url);
                return;

                $.get(url, function (data) {
                    window.location.href = data;
                }).fail(function (event) {
                    console.log(event);
                    alert(event.data);
                });
            }
        </script>



    </x-slot>
</div>

