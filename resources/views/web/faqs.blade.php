@extends('web.app')
@section('content')
<!-- FAQS START!!! -->
<div class="py-5 text-center">
    <div class="container">
        <div class="row">
        <div class="col-md-12">
            <h1>FAQS</h1>
        </div>
        </div>
    </div>
</div>
    
<div class="py-3">
    <div class="container">
        <div class="row">
        <div class="col-md-12">
            <h2 class="mb-3">Delivery</h2>
            <p>- Your parcel will be delivered within 10-15 working days. weekends and holidays are not included</p>
            <p>- Free Delivery for METRO MANILA</p>
        </div>
        </div>
    </div>
</div>

<div class="py-3">
    <div class="container">
        <div class="row">
        <div class="col-md-12">
            <h2 class="mb-3">Payment Method</h2>
            <p>- Acsan only accepts bank deposits and they will contact you upon receiving the validity of your payment by sending you an email or calling you.</p>
        </div>
        </div>
    </div>
</div>  

<div class="py-3">
    <div class="container">
        <div class="row">
        <div class="col-md-12">
            <h2 class="mb-3">Refunds</h2>
            <p>- Acsan only accept refunds when the materials needed for your parcel is still not delivered to them. You may also contact them for informations.</p>
        </div>
        </div>
    </div>
</div> 

<div class="py-3">
    <div class="container">
        <div class="row">
        <div class="col-md-12">
            <h2 class="mb-3">Payment</h2>
            <p>- 70% Downpayment and 30% COD.</p>
        </div>
        </div>
    </div>
</div>

<div class="py-3">
    <div class="container">
        <div class="row">
        <div class="col-md-12">
            <h2 class="mb-3">Type of Fabrics</h2>
            <p>- The cost of fabrics are all the same.</p>
        </div>
        </div>
    </div>
</div>

<div class="py-3">
    <div class="container">
        <div class="row">
        <div class="col-md-12">
            <h2 class="mb-3">Logo or artwork</h2>
            <p>- The costumers can send their own logo or artwork.</p>
            <p>- This option will also be available on mugs and eco bags and lanyards.</p>
        </div>
        </div>
    </div>
</div>

<div class="py-3">
    <div class="container">
        <div class="row">
        <div class="col-md-12">
            <h2 class="mb-3">Lead time</h2>
            <p>- The lead time is counted in working days. Weekends and Holidays are not included.</p>
        </div>
        </div>
    </div>
</div>

<div class="py-3">
    <div class="container">
        <div class="row">
        <div class="col-md-12">
            <h2 class="mb-3">Exchange policy</h2>
            <p>- Upon receiving the item. The item can be exchanged within 7 days of purchase. It is free of charge. It only covers factory defect.</p>
        </div>
        </div>
    </div>
</div>

<div class="py-5">
    <div class="container">
        <div class="row">
        <div class="col-md-12">
            <div class="row">
            <div class="p-3 col-md-8">
                <h3>HoneyComb Cotton</h3>
                <p class="mb-3">Honeycombed Cotton is commonly used for Polo Shirts as office uniforms. This fabric give clients a professional look and feel. Best printed with embroidery.</p> 
            </div>
            <div class="col-md-4 col-lg-3 offset-lg-1"> <img class="img-fluid d-block" src="{{ asset('img/fabrics/honeycomb.jpg') }}"> </div>
            </div>
        </div>
        </div>
    </div>
</div>

<div class="py-5">
    <div class="container">
        <div class="row">
        <div class="col-md-12">
            <div class="row">
            <div class="col-md-4 col-lg-3 order-2 order-md-1 p-0"> <img class="img-fluid d-block" src="{{ asset('img/fabrics/cvc.jpg') }}"> </div>
            <div class="d-flex flex-column justify-content-center p-3 col-md-8 offset-lg-1 align-items-start order-1 order-md-2">
                <h3>CVC Cotton</h3>
                <p class="mb-3">CVC Cotton is the most versatile among most of the fabrics we use. It handles all the links for silk screen printing very well.</p> 
            </div>
            </div>
        </div>
        </div>
    </div>
</div>

<div class="py-5">
    <div class="container">
        <div class="row">
        <div class="col-md-12">
            <div class="row">
            <div class="col-md-4 col-lg-3 order-2 order-md-1 p-0"> <img class="img-fluid d-block" src="{{ asset('img/fabrics/dry-fit.jpg') }}"> </div>
            <div class="d-flex flex-column justify-content-center p-3 col-md-8 offset-lg-1 align-items-start order-1 order-md-2">
                <h3>Dri Fit</h3>
                <p class="mb-3">Dri-Fit is a synthetic microfiber that is porous and allows for capillary action to transfer liquids from side of the weave to the other surface. This can be useful when considering fabrics for manufacturing sports underwear.</p> 
            </div>
            </div>
        </div>
        </div>
    </div>
</div>
<!-- FAQS END!!! -->   
@endsection