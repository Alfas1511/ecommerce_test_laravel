@extends('layouts.app')

@section('content')
    <div style="max-width: 900px; margin: auto; padding: 20px;">
        <h2 style="text-align: center; margin-bottom: 30px;">📦 Order Details</h2>

        @if ($order_details->isEmpty())
            <p style="text-align: center;">No items found for this order.</p>
        @else
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="background-color: #f7f7f7; text-align: left;">
                        <th style="padding: 10px; border-bottom: 2px solid #ddd;">Order ID #</th>
                        <th style="padding: 10px; border-bottom: 2px solid #ddd;">Product Name</th>
                        <th style="padding: 10px; border-bottom: 2px solid #ddd; width: 100px;">Quantity</th>
                        <th style="padding: 10px; border-bottom: 2px solid #ddd; width: 120px;">Price per Item</th>
                        <th style="padding: 10px; border-bottom: 2px solid #ddd; width: 140px;">Total Price</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $orderTotal = 0;
                    @endphp

                    @foreach ($order_details as $item)
                        @php
                            $lineTotal = $item->quantity * $item->price;
                            $orderTotal += $lineTotal;
                        @endphp
                        <tr style="border-bottom: 1px solid #eee;">
                            <td style="padding: 10px;">
                                {{ "#". $item->id ?? "" }}
                            </td>
                            <td style="padding: 10px;">
                                {{ $item->product->name ?? '' }}
                            </td>
                            <td style="padding: 10px; text-align: center;">
                                {{ $item->quantity }}
                            </td>
                            <td style="padding: 10px;">
                                ${{ number_format($item->price, 2) }}
                            </td>
                            <td style="padding: 10px;">
                                ${{ number_format($lineTotal, 2) }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr style="background-color: #f7f7f7;">
                        <td colspan="4" style="padding: 10px; font-weight: bold; text-align: right;">Order Total:</td>
                        <td style="padding: 10px; font-weight: bold;">${{ number_format($orderTotal, 2) }}</td>
                    </tr>
                </tfoot>
            </table>
        @endif
    </div>
@endsection
