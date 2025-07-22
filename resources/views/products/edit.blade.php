@extends('layouts.app')

@section('styles')
    <style>
        .text-danger {
            color: red
        }
    </style>
@endsection

@section('content')
    <div
        style="
        background: #fff;
        padding: 40px;
        max-width: 700px;
        margin: 30px auto;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    ">
        <h2 style="margin-bottom: 30px; text-align: center; color: #333;">🛒 Edit Product</h2>

        <form action="{{ route('products.update', $product->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div style="margin-bottom: 20px;">
                <label for="name" style="font-weight: 600;">Product Name <span style="color: red;">*</span></label><br>
                <input type="text" name="name" id="name" value="{{ old('name', $product->name) }}"
                    style="width: 100%; padding: 12px; border: 1px solid #ccc; border-radius: 6px;">
                @error('name')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div style="margin-bottom: 20px;">
                <label for="description" style="font-weight: 600;">Description <span
                        style="color: red;">*</span></label><br>
                <textarea name="description" id="description" rows="4"
                    style="width: 100%; padding: 12px; border: 1px solid #ccc; border-radius: 6px;">{{ old('description', $product->description) }}</textarea>
                @error('description')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div style="margin-bottom: 20px;">
                <label for="price" style="font-weight: 600;">Price ($) <span style="color: red;">*</span></label><br>
                <input type="number" name="price" id="price" step="0.01"
                    value="{{ old('price', $product->price) }}"
                    style="width: 100%; padding: 12px; border: 1px solid #ccc; border-radius: 6px;">
                @error('price')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div style="margin-bottom: 20px;">
                <label for="stock" style="font-weight: 600;">Stock Quantity <span
                        style="color: red;">*</span></label><br>
                <input type="number" name="stock" id="stock" value="{{ old('stock', $product->stock_quantity) }}"
                    style="width: 100%; padding: 12px; border: 1px solid #ccc; border-radius: 6px;">
                @error('stock')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div style="text-align: right;">
                <button type="submit"
                    style="padding: 12px 25px; background: #28a745; color: white; border: none; border-radius: 6px; font-size: 16px;">
                    Update Product
                </button>
            </div>
        </form>
    </div>
@endsection
