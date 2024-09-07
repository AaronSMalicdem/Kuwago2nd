<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Print</title>
</head>

<style>
    .container {
        display: flex;
        flex-direction: column;
    }

    .child {
        flex-grow: 1;
    }
</style>

<body>
    <div style="width: 200px; display:block; font-size:20px" class="container">
        <div>Order Number {{ $order->order_number }}</div>
        <div>{{ optional($order->table())->name }}</div>
        <div>{{ $order->action }}</div>
        <table style="width: 200px; font-size: 18px; margin-top: 10px;">
            @foreach ($order->orderDetails as $item)
            <tr>
                <td width="75%">{{ $item->dish->name }}</td>
                <td width="25%">{{ 'X '.$item->pcs }}</td>
            </tr>
            @endforeach
            @foreach ($order->customOrderDetails as $item)
            <tr>
                <td width="75%">{{ $item->name }}</td>
                <td width="25%">{{ 'X '.$item->pcs }}</td>
            </tr>
            @endforeach
        </table>
    </div>
</body>

</html>
