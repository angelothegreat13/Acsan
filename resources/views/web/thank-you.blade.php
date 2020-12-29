@extends('web.app')
@section('content')
<div class="container">
    <div class="alert alert-success mt-40 mb-60 pt-20 pb-20" role="alert">
        <h4 class="alert-heading">Thank you for your purchase!</h4>
        <p class="mb-0">Your order number is {{ $orderID }}.</p>
        <hr>
        <a href="{{ route('home') }}" class="mb-0 font-weight-bold">Continue Shopping</a>
    </div>
</div>
@endsection