<html>

<head>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }

        th,
        td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
    </style>
</head>

<body>
    <h1>Food Orders</h1>

    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Order Number</th>
                <th>Order Items</th>
                <th>Total Amount</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($orders as $key => $order)
                @if ($key === 0 || $orders[$key - 1]->order_number !== $order->order_number)
                    <tr>
                        <td>{{ $order->date }}</td>
                        <td>{{ $order->order_number }}</td>
                        <td>
                            <ul>
                                @foreach ($orders->where('order_number', $order->order_number) as $item)
                                    <li>{{ $item->item_name }}</li>
                                @endforeach
                            </ul>
                        </td>
                        <td>{{ $order->total_amount }}</td>
                    </tr>
                @endif
            @endforeach
        </tbody>
    </table>
</body>

</html>
