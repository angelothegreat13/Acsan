@extends('web.app')
@section('content')
<!-- Product Section Start-->
<div class="product-section section pt-70 pb-60">
    <div class="container">

        <!-- Section Title Start-->
        <div class="row">
            <div class=" text-center col mb-60">
                <h1>{{ $categoryName }}</h1>
            </div>
        </div><!-- Section Title End-->
        
        <!-- Product Wrapper Start-->
        <div class="row">
            @foreach ($products as $product)
                <div class="col-lg-4 col-md-6 col-12 mb-60">
                    <div class="product">
                        <div class="image">
                            <a href="{{ route('products.show',$product->slug) }}" class="img">
                                <img src="{{ asset($product->image) }}" alt="{{ $product->name }}">
                            </a>
                        </div>
                        
                        <div class="content">
                            <div class="head fix">
                                <div class="title-category float-left">
                                    <h5 class="title"><a href="{{ route('products.show',$product->slug) }}">{{ $product->name }}</a></h5>
                                    <a href="shop.html" class="category">{{ $product->category->name }}</a>
                                </div>
                                <div class="price float-right">
                                    <span class="new" style="font-size:18px;">₱ {{ number_format((float)$product->price, 2, '.', '') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div><!-- Product Wrapper End-->
    </div>
</div>
<!-- Product Section End-->
@endsection