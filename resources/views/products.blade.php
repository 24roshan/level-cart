@extends('layout')

@section('content')
<h1>Products</h1>
<div class="row">
    @foreach($products as $product)
        <div class="col-md-4">
            <div class="card p-3 mb-3">
                <h4>{{ $product['name'] }}</h4>
                <p>₹{{ number_format($product['price'], 2) }}</p>
                <form method="POST" action="{{ route('cart.add', $product['id']) }}">
                    @csrf
                    <button class="btn btn-primary">Add to Cart</button>
                </form>
            </div>
        </div>
    @endforeach
</div>
<a href="{{ route('cart.index') }}" class="btn btn-success">View Cart</a>
@endsection
