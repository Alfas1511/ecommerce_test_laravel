@extends('layouts.app')

@section('content')
    <h1>My Cart</h1>

    <a href="{{ route('products.showcase') }}" type="button"
        style="padding: 10px 20px; background: blue; text-decoration: none; color: white; border: none; border-radius: 5px;">Add
        Products</a>

    <div style="text-align: right; margin-bottom: 20px;">
        <form id="place-order-form" action="{{ route('orders.place') }}" method="POST">
            @csrf
            <button type="submit"
                style="padding: 10px 20px; background: green; color: white; border: none; border-radius: 5px;">
                🧾 Place Order
            </button>
        </form>
    </div>

    @if (session('success'))
        <div style="background: #d4edda; padding: 10px; border: 1px solid #c3e6cb; margin: 10px 0;">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div style="background: #f8d7da; padding: 10px; border: 1px solid #f5c6cb; margin: 10px 0;">
            {{ session('error') }}
        </div>
    @endif


    <table id="cart-table" class="display responsive nowrap" style="width:100%">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Amount</th>
                <th>Action</th>
            </tr>
        </thead>
    </table>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            const table = $('#cart-table').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: '{{ route('cart.getData') }}',
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'name',
                        name: 'product.name'
                    },
                    {
                        data: 'price',
                        name: 'product.price'
                    },
                    {
                        data: 'quantity',
                        name: 'quantity'
                    },
                    {
                        data: 'amount',
                        name: 'amount',
                        searchable: false,
                        orderable: false
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ],
            });

            $('#cart-table').on('click', '.btn-delete', function(e) {
                e.preventDefault();
                const url = $(this).data('url');

                if (confirm('Are you sure you want to remove this item from your cart?')) {
                    $.ajax({
                        url: url,
                        type: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(res) {
                            table.ajax.reload();
                        },
                        error: function() {
                            alert('Failed to delete item.');
                        }
                    });
                }
            });

            $('#cart-table').on('change', '.cart-qty-input', function() {
                const input = $(this);
                const id = input.data('id');
                const quantity = input.val();

                $.ajax({
                    url: '/cart/update/' + id,
                    type: 'PATCH',
                    data: {
                        _token: '{{ csrf_token() }}',
                        quantity: quantity
                    },
                    success: function(res) {
                        $('#cart-table').DataTable().ajax.reload(null,
                        false);
                    },
                    error: function() {
                        alert('Failed to update quantity.');
                    }
                });
            });

        });
    </script>
@endsection
