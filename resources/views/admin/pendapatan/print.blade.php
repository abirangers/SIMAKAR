<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order {{ $order->order_code }}</title>
    <style>
        body { font-family: Arial, sans-serif; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h1>Order Details</h1>
    <p><strong>Order Code:</strong> {{ $order->order_code }}</p>
    <p><strong>Cashier:</strong> {{ $order->user->name }}</p>
    <p><strong>Customer:</strong> {{ $order->customer_name }}</p>

    <h2>Items:</h2>
    <table>
        <thead>
            <tr>
                <th>Item</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($order->orderItems as $item)
                <tr>
                    <td>{{ $item->menu->name }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>Rp {{ number_format($item->menu->price, 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($item->quantity * $item->menu->price, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <p><strong>Subtotal:</strong> Rp {{ number_format($order->subtotal, 0, ',', '.') }}</p>
    <p><strong>Tax:</strong> Rp {{ number_format($order->tax, 0, ',', '.') }}</p>
    <p><strong>Total:</strong> Rp {{ number_format($order->total, 0, ',', '.') }}</p>
    <p><strong>Tunai:</strong> Rp {{ number_format($order->cash, 0, ',', '.') }}</p>
    <p><strong>Kembalian:</strong> Rp {{ number_format($order->change, 0, ',', '.') }}</p>
</body>
</html>