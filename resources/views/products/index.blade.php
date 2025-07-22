@extends('layouts.app')
@section('styles')
@endsection
@section('content')
    <h1>Products</h1>

    <h6><a href="{{ route('products.create') }}"
            style="padding: 10px 20px; background: blue; text-decoration:none; color: white; border: none; border-radius: 5px;">Add
            Product</a></h6>

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

    <table id="products-table" class="display responsive nowrap" style="width:100%">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Price</th>
                <th>Stock</th>
                <th>Action</th>
            </tr>
        </thead>
    </table>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $('#products-table').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: '{{ route('products.getData') }}',
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'price',
                        name: 'price'
                    },
                    {
                        data: 'stock_quantity',
                        name: 'stock_quantity'
                    },
                    {
                        data: 'actions',
                        name: 'actions',
                        orderable: false,
                        searchable: false
                    }
                ]
            });
        });
    </script>
@endsection
