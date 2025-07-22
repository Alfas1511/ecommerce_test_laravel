<div class="sidebar">

    @if (auth()->user()->role === 'admin')
        <a href="{{ route('dashboard') }}">Dashboard</a>
        <a href="{{ route('products.index') }}">Products</a>
    @elseif(auth()->user()->role === 'user')
        <a href="{{ route('products.showcase') }}">Products</a>
        <a href="{{ route('cart.index') }}">My Cart
            <span class="background-color:white;color:black;">
                {{ auth()->user()->role == 'user' ? auth()->user()->cart()->sum('quantity') : 0 }}
            </span>
        </a>
        <a href="{{ route('orders.index') }}">Orders</a>
    @endif

</div>
