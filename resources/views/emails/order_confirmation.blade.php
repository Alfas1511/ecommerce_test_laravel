<h2>Thank you for your order, {{ $order->user->name }}!</h2>

<p>Your order has been placed successfully. Here are the details:</p>

<ul>
    @foreach ($order->items as $item)
    <li>
        {{ $item->product->name }} × {{ $item->quantity }} — ${{ number_format($item->price * $item->quantity, 2) }}
    </li>
    @endforeach
</ul>

<p><strong>Total:</strong> ${{ number_format($order->total_price, 2) }}</p>

<p>We appreciate your business!</p>
