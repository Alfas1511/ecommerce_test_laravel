@extends('layouts.app')

@section('content')
    <div style="max-width: 800px; margin: auto; padding: 20px;">
        <h1>Welcome, {{ auth()->user()->name }}</h1>

        <div style="margin-top: 30px;">
            <div style="background: #f8f9fa; padding: 20px; border-radius: 8px; margin-bottom: 20px;">
                <h3>Total Orders</h3>
                <p style="font-size: 24px;">🧾 {{ $orderCount }}</p>
            </div>

            <div style="background: #f8f9fa; padding: 20px; border-radius: 8px;">
                <h3>Total Revenue</h3>
                <p style="font-size: 24px;">💰 ${{ number_format($totalRevenue, 2) }}</p>
            </div>
        </div>
    </div>
@endsection
