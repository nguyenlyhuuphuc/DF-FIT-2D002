<html>
    <h1>Customer</h1>
    <table border="1">
        <tr>
            <th>STT</th>
            <th>Product</th>
            <th>Qty</th>
            <th>Total</th>
        </tr>
        @foreach ($order->orderItems as $orderItem)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $orderItem->name }}</td>
                <td>{{ $orderItem->qty }}</td>
                <td>{{ number_format($orderItem->price * $orderItem->qty, 2) }}</td>
            </tr>
        @endforeach
        <tr>
            <td>Total</td>
            <td colspan="3">{{ $order->total }}</td>
        </tr>
    </table>
</html>

