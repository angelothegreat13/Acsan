@extends('web.app')
@section('content')
 <!-- Checkout Section Start-->
<div class="cart-section section pt-80 pb-90">
    <div class="container">
        <div class="row">
            
            <div class="col-lg-6 col-12 mb-30">
                
                <!-- Checkout Accordion Start -->
                <div id="checkout-accordion" class="panel-group">
                    
                    <!-- Shipping Method -->
                    <div class="panel single-accordion">
                        <a class="accordion-head" data-toggle="collapse" data-parent="#checkout-accordion" href="#shipping-method">3. shipping information</a>
                        <div id="shipping-method" class="collapse show">
                            <div class="accordion-body shipping-method fix">
                                <h5>shipping address</h5>
                                <p><span>address&nbsp;</span>{{ currentCustomer()->address }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Payment Method -->
                    <div class="panel single-accordion">
                        <a class="accordion-head" data-toggle="collapse" data-parent="#checkout-accordion" href="#payment-method">4. Payment method</a>
                        <div id="payment-method" class="collapse show">
                            <div class="accordion-body payment-method fix">
                                <ul class="payment-method-list">
                                    <li class="payment-form-toggle active">Bank Deposit</li>
                                </ul>
                                <p>Once the order is completed, you can settle the amount into our BPI account</p>
                                <div class="payment-form" style="display: block;">
                                    <div class="row">
                                        <div class="input-box col-12">
                                            <div class="row">
                                                <div class="input-box col-md-6 col-12 mb-20">
                                                    <label>Bank</label>
                                                    <input type="text" value="BDO" readonly>
                                                </div>
                                                <div class="input-box col-md-6 col-12 mb-20">
                                                    <label>Type of Account</label>
                                                    <input type="text" value="Checking" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="input-box col-12 mb-20">
                                            <label>Account Name</label>
                                            <input type="text" value="Acsan Enterprise" readonly>
                                        </div>
                                        <div class="input-box col-12 mb-20">
                                            <label>Account Number</label>
                                            <input type="text" value="00123456678" readonly>
                                        </div>
                                    </div>
                                </div>
                                <p class="text-danger" style="font-size:12px;">NOTE: Please send the proof of payment within 24 hours to confirm or it will automatically be cancelled. Once payment is verified, we will proceed with your order confirmation and your product will be delivered in the next 10-15 days.</p>
                            </div>
                        </div>
                    </div>
                    
                </div><!-- Checkout Accordion Start -->
                
            </div>
            
            <!-- Order Details -->
            <div class="col-lg-6 col-12 mb-30">
                
                <div class="order-details-wrapper">
                    <h2>your order</h2>
                    <div class="order-details">
                        <form action="{{ route('orders.process-checkout') }}" method="POST">
                            @csrf
                            <ul>
                                <li><p class="strong">product</p><p class="strong">total</p></li>
                                @foreach ($data as $dt)
                                   @php
                                        $cart = $dt['cart'];
                                        $cartAttributes = $dt['cart_attributes'];
                                    @endphp
                                    <li>
                                        <p>{{ $cart->product }} 
                                            @if (count($cartAttributes))
                                                @foreach ($cartAttributes as $cartAttribute)
                                                    <span style="font-size:11px;">{{ ucwords($cartAttribute->product_option_value_name) }}, </span>
                                                @endforeach
                                            @endif         
                                        </p>
                                        <p>₱ {{ number_format((float)$cart->final_price, 2, '.', '') }}</p>
                                    </li>
                                @endforeach
                                    <li><p class="strong">cart subtotal</p><p class="strong">₱ {{ number_format((float)$cartSubTotal, 2, '.', '') }}</p></li>
                                    {{-- <li><p class="strong">shipping</p><p>
                                        <input type="radio" name="order-shipping" id="flat" /><label for="flat">Flat Rate $ 7.00</label><br />
                                        <input type="radio" name="order-shipping" id="free" /><label for="free">Free Shipping</label>
                                    </p></li> --}}
                                    <li><p class="strong">order total</p><p class="strong">₱ {{ number_format((float)$cartTotal, 2, '.', '') }}</p></li>
                                    <li><button type="submit" class="button">place order</button></li>
                            </ul>
                        </form>
                    </div>
                </div>
                
            </div>
            
        </div>
    </div>
</div>
<!-- Checkout Section End-->
@endsection