@extends('web.app')
@section('content')
<!-- Banner Section Start-->
<div class="banner-section section pt-120">
    <div class="container">
        <div class="row">
            
            <div class="col-lg-6 col-12 mb-30">
                <div class="embed-responsive embed-responsive-16by9">
                    <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/N1jKlda6SEs" allowfullscreen></iframe>
                </div>
            </div>
            
            <div class="col-lg-6 col-12 mb-30">
                <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img src="{{ asset('img/sliders/slider1.png') }}" class="d-block w-100" alt="..." height="250">
                        </div>
                        <div class="carousel-item">
                            <img src="{{ asset('img/sliders/slider2.png') }}" class="d-block w-100" alt="..." height="250">
                        </div>
                        <div class="carousel-item">
                            <img src="{{ asset('img/sliders/slider3.png') }}" class="d-block w-100" alt="..." height="250">
                        </div>
                    </div>
                    <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
            </div>
            
        </div>
    </div>
</div><!-- Banner Section End-->
       
<!-- Product Section Start-->
<div class="product-section section pt-70 pb-60">
    <div class="container">
        
        <!-- Section Title Start-->
        <div class="row">
            <div class=" text-center col mb-60">
                <h1>Products</h1>
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
                                    <a href="{{ URL::to($product->category->slug) }}" class="category">{{ $product->category->name }}</a>
                                </div>
                                <div class="price float-right">
                                    <span class="new" style="font-size:18px;">₱ {{ number_format((float)$product->price, 2, '.', '') }}</span>
                                </div>
                            </div>
                            
                            {{-- <div class="action-button fix">
                                <button class="btn btn-success" type="button" onclick="addToCart(this);" data-id="{{ $product->id }}">Add to Cart</a>
                            </div> --}}
                        </div>
                    </div>
                </div>
            @endforeach
        </div><!-- Product Wrapper End-->
    </div>
</div>
<!-- Product Section End-->
@endsection
@section('extra-scripts')
<script type="text/javascript">
function addToCart(product)
{
    const productID = product.getAttribute("data-id");

    $.ajax({
        type: "POST",
        url: "/cart/store",
        data: {
            product_id: productID,
            qty: 1
        },
        dataType: "JSON",
        success: function (res) {
            if (res === 'success') {
                alert("Product successfully added");
            }
        }
    });
}
</script>
@endsection