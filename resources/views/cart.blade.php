@extends('layout')

@section('content')
<h1>Your Cart</h1>

@if($cart && count($cart) > 0)
<table class="table table-bordered">
    <thead>
        <tr>
            <th>Name</th>
            <th style="width:140px;">Quantity</th>
            <th>Price</th>
            <th>Subtotal</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach($cart as $id => $item)
        <tr>
            <td>{{ $item['name'] }}</td>
            <td>
                <form method="POST" action="{{ route('cart.update', $id) }}">
                    @csrf
                    <div class="d-flex align-items-center">
                        <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1" class="form-control me-2" style="width:70px;">
                        <button class="btn btn-sm btn-warning">Update</button>
                    </div>
                </form>
            </td>
            <td>₹{{ number_format($item['price'],2) }}</td>
            <td>₹{{ number_format($item['price'] * $item['quantity'],2) }}</td>
            <td>
                <form method="POST" action="{{ route('cart.remove', $id) }}">
                    @csrf
                    <button class="btn btn-sm btn-danger">Remove</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<h3>Total: ₹{{ number_format($total,2) }}</h3>

<form method="POST" action="{{ route('cart.clear') }}" style="display:inline-block;">
    @csrf
    <button class="btn btn-secondary">Clear Cart</button>
</form>

<form method="POST" action="{{ route('cart.checkout') }}" style="display:inline-block;">
    @csrf
    <button class="btn btn-success">Checkout</button>
</form>

@else
<p>Your cart is empty.</p>
@endif

<a href="{{ route('products.list') }}" class="btn btn-primary mt-3">Continue Shopping</a>
@endsection
