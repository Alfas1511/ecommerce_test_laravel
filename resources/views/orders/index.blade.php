@extends('layouts.app')
@section('styles')
@endsection
@section('content')
    <h1>Orders</h1>

    <table id="orders-table" class="display responsive nowrap" style="width:100%">
        <thead>
            <tr>
                <th>Order ID</th>
                <th>Date</th>
                <th>Amount</th>
                <th>View Details</th>
            </tr>
        </thead>
    </table>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $('#orders-table').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: '{{ route('orders.getData') }}',
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'date',
                        name: 'date'
                    },
                    {
                        data: 'total_price',
                        name: 'total_price'
                    },
                    {
                        data: 'view_order_details',
                        name: 'view_order_details'
                    },
                ]
            });
        });
    </script>
@endsection
