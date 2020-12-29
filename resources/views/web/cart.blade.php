@extends('web.app')
@section('content')
<!-- Cart Section Start-->
<div class="cart-section section pt-50 pb-90">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h2 class="mb-20">SHOPPING CART</h2>
                @if ($message = Session::get('success'))
                    <div class="alertMsg alert alert-success mb-5" role="alert">
                        <p>{{ $message }}</p>
                    </div>
                @endif
                @if (count($data) <= 0)
                    <div class="alert alert-warning mb-5" role="alert">
                        <p>Your shopping cart is empty</p>
                    </div>
                @else 
                    <div class="table-responsive mb-30 bg-white">
                        <table class="table cart-table text-center table-condensed table-striped">
                            
                            <!-- Table Head -->
                            <thead>
                                <tr>
                                    <th class="image">image</th>
                                    <th class="name">product name</th>
                                    <th class="qty">quantity</th>
                                    <th class="price">price</th>
                                    <th class="total">sub total</th>
                                    <th class="remove">remove</th>
                                </tr>
                            </thead>
                            <!-- Table Body -->
                            <tbody>
                                @foreach ($data as $dt)
                                @php
                                    $cart = $dt['cart'];
                                    $cartAttributes = $dt['cart_attributes'];
                                @endphp
                                    <tr>
                                        <td>
                                            <a href="{{ route('products.show',$cart->product_slug) }}" class="cart-pro-image">
                                                <img src="{{ asset($cart->product_img) }}">
                                            </a>
                                        </td>
                                        <td style="text-align:justify;" class="pl-4 pr-4">
                                            <a href="{{ route('products.show',$cart->product_slug) }}" class="cart-pro-title font-weight-bold">{{ $cart->product }}</a>
                                            @if (count($cartAttributes))
                                                <ul style="font-size:12px;text-align:justify;">
                                                    @foreach ($cartAttributes as $cartAttribute)
                                                        <li>{{ ucwords($cartAttribute->product_option_name) }}:{{ ucwords($cartAttribute->product_option_value_name) }} =  ₱ {{ number_format((float)$cartAttribute->product_option_value_price, 2, '.', '')  }}</li>
                                                    @endforeach
                                                </ul>
                                            @endif                                            
                                        </td>
                                        <td>{{ $cart->quantity }}</td>
                                        <td><p class="cart-pro-price">₱ {{ number_format((float)$cart->price, 2, '.', '') }}</p></td>
                                        <td><p class="cart-price-total">₱ {{ number_format((float)$cart->final_price, 2, '.', '') }}</p></td>
                                        <td>
                                             <form action="{{ route('cart.destroy', $cart->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" onclick="return confirm('Are you sure to delete?')" class="cart-pro-remove" title="Remove Cart"><i class="fa fa-trash-o"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                
                    <div class="row">
                        <!-- Cart Action -->
                        <div class="cart-action col-lg-4 col-md-6 col-12 mb-30">
                            <a href="{{ route('home') }}" class="button">Continue Shopping</a>
                        </div>
                        
                        <!-- Cart Checkout Progress -->
                        <div class="cart-checkout-process col-lg-4 col-md-6 col-12 mb-30">
                            <h4 class="title">Process Checkout</h4>
                            <p><span>Subtotal</span><span>₱ {{ number_format((float)$cartTotal, 2, '.', '') }}</span></p>
                            <h5><span>Grand total</span><span>₱ {{ number_format((float)$cartTotal, 2, '.', '') }}</span></h5>
                            <a href="{{ route('orders.checkout') }}" class="button">proceed to checkout</a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
<!-- Cart Section End-->    
@endsection
@section('extra-scripts')
<script type="text/javascript">
$(function () {
    $(".alertMsg").fadeIn("fast").delay(3000).fadeOut("slow");
});
</script>
@endsection