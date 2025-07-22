@extends('layouts.app')

@section('content')
    <div style="max-width: 1200px; margin: auto; padding: 20px;">
        <h2 style="text-align: center; margin-bottom: 30px;">🛍️ Our Products</h2>

        <div
            style="
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 20px;
        ">
            @forelse ($products as $product)
                <div
                    style="
                    background: #fff;
                    border: 1px solid #ddd;
                    border-radius: 10px;
                    padding: 20px;
                    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
                ">
                    <h3 style="margin-top: 0;">{{ $product->name }}</h3>
                    <p style="color: #555;">{{ Str::limit($product->description, 100) }}</p>

                    <p style="margin: 10px 0;">
                        <strong>Price:</strong> ${{ number_format($product->price, 2) }}<br>
                        <strong>Stock:</strong>
                        {{ $product->stock_quantity > 0 ? $product->stock_quantity : 'Out of Stock' }}
                    </p>

                    @if ($product->stock_quantity > 0)
                        <form action="{{ route('cart.add', $product->id) }}" method="POST" class="add-to-cart-form">
                            @csrf
                            <div style="display: flex; align-items: center; margin-bottom: 10px;">

                                <input type="hidden" name="product_id" value="{{ $product->id }}">

                                <button type="button" class="qty-decrease" style="padding: 5px 10px;">−</button>
                                <input type="number" name="quantity" value="1" min="1"
                                    max="{{ $product->stock_quantity }}" data-max="{{ $product->stock_quantity }}"
                                    class="qty-input" style="width: 60px; text-align: center; margin: 0 5px; padding: 5px;">

                                <button type="button" class="qty-increase" style="padding: 5px 10px;">+</button>
                            </div>

                            <button type="submit"
                                style="background: #007bff; color: white; border: none; padding: 10px 20px; border-radius: 5px; cursor: pointer;">
                                Add to Cart
                            </button>
                        </form>
                    @else
                        <button disabled
                            style="background: #ccc; color: white; border: none; padding: 10px 20px; border-radius: 5px;">
                            Out of Stock
                        </button>
                    @endif
                </div>
            @empty
                <p>No products available at the moment.</p>
            @endforelse
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.add-to-cart-form').each(function() {
                const form = $(this);
                const input = form.find('.qty-input');
                const incBtn = form.find('.qty-increase');
                const decBtn = form.find('.qty-decrease');
                const max = parseInt(input.attr('data-max'));

                // Increase button
                incBtn.on('click', function() {
                    let value = parseInt(input.val()) || 1;
                    if (value < max) {
                        input.val(value + 1);
                    } else {
                        alert(`Maximum available stock is ${max}.`);
                    }
                });

                // Decrease button
                decBtn.on('click', function() {
                    let value = parseInt(input.val()) || 1;
                    if (value > 1) {
                        input.val(value - 1);
                    }
                });

                // Manual input validation
                input.on('input', function() {
                    let value = parseInt($(this).val()) || 1;
                    if (value > max) {
                        alert(`Only ${max} units in stock.`);
                        $(this).val(max);
                    } else if (value < 1) {
                        $(this).val(1);
                    }
                });

                // Final validation on submit
                form.on('submit', function(e) {
                    let qty = parseInt(input.val());
                    if (qty > max) {
                        e.preventDefault();
                        alert(`Cannot add more than ${max} units.`);
                    }
                });
            });
        });
    </script>
@endsection
