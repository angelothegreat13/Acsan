@extends('web.app')
@section('content')
<!-- Product Section Start-->

<div class="product-section section pt-110 pb-90">
    <div class="container">

    @if ($message = Session::get('success'))
        <div class="alertMsg alert alert-success mb-5" role="alert">
            <p>{{ $message }}</p>
        </div>
    @endif
        
        <!-- Product Wrapper Start-->
        <div class="row">
            
            <!-- Product Image Container -->
            <div class="col-lg-7 col-12 mb-30 prod-img-box">
                <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" class="img-fluid d-block">

                @if (count($productAttributes))
                    @foreach ($productAttributes as $key => $productAttribute)
                        @php 
                            $options = $productAttribute['option'];
                            $optionValues = $productAttribute['values'];
                        @endphp

                        @if ($options['type'] == 'colorpicker')
                            @foreach ($optionValues as $optionValue)
                                @php
                                    $prodImgURL = ($optionValue['color_img'] !== NULL) ? $optionValue['color_img'] : $product->image ;
                                @endphp
                                <img src="{{ asset($prodImgURL) }}" class="img-fluid color-img-{{ $optionValue['product_attribute_id'] }} d-none"> 
                            @endforeach
                        @endif
                    @endforeach
                @endif
            </div><!-- Product Image & Thumbnail End -->
            
            <!-- Product Content Start -->
            <div class="single-product-content col-lg-5 col-12 mb-30">
                <h1 class="title">{{ $product->name }}</h1>
                <span class="product-price mb-3">₱ {{ number_format((float)$product->price, 2, '.', '') }}</span>
                
                <form action="{{ route('cart.store') }}" method="POST" id="addToCartForm" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="product_id" id="product_id" value="{{ $product->id }}">
                <input type="hidden" name="productPrice" class="productPrice" value="{{ $product->price }}">

                @if (count($productAttributes))
                    <input type="hidden" name="prod_type" id="prod_type" value="1">
                    @foreach ($productAttributes as $key => $productAttribute)
                        @php 
                            $options = $productAttribute['option'];
                            $optionValues = $productAttribute['values'];
                        @endphp

                        @if ($options['type'] == 'colorpicker')
                            <div class="product-color fix" style="margin-bottom:13px;">
                                <label for="color" class="font-weight-bold" style="display:block;">{{ ucwords($options['label']) }}</label>
                                @foreach ($optionValues as $optionValue)
                                    <div class="color-box">
                                        <input 
                                            type="radio" 
                                            name="{{ $options['name'] }}" 
                                            id="{{ $optionValue['value'] }}"
                                            product_attribute_id="{{ $optionValue['product_attribute_id'] }}"
                                            prefix="{{ $optionValue['price_prefix'] }}"
                                            value_price="{{ $optionValue['price'] }}"
                                            value="{{ $optionValue['option_value_id'] }}" 
                                            required
                                            onchange="colorChange({{ json_encode($options['name']) }});"
                                        >
                                        <label for="{{ $optionValue['value'] }}" style="background-color: {{ $optionValue['value'] }};">{{ $optionValue['value'] }}</label>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="form-group">
                                <label class="font-weight-bold">{{ ucwords($options['label']) }}</label>
                                <select 
                                    name="{{ $options['name'] }}"
                                    id="{{ $options['name'] }}"
                                    option_id="{{ $options['option_id'] }}"
                                    class="form-control" 
                                    required 
                                >
                                    <option value="">Select {{ ucwords($options['name']) }}</option>
                                    @foreach ($optionValues as $optionValue)
                                        <option
                                            product_attribute_id="{{ $optionValue['product_attribute_id'] }}"
                                            prefix="{{ $optionValue['price_prefix'] }}"
                                            value_price="{{ $optionValue['price'] }}"
                                            value="{{ $optionValue['option_value_id'] }}" 
                                            @if ($optionValue['is_default']) selected @endif
                                        >
                                            {{ ucwords($optionValue['value']) }} 
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        @endif
                    @endforeach
                @endif
            
                <div class="form-group">
                    <label for="logo" class="font-weight-bold">Upload artwork or logo</label>
                    <input type="file" name="logo" id="logo" accept="image/x-png,image/gif,image/jpeg">
                </div>

                <!-- Quantity & Cart Button -->
                <div class="product-quantity-cart fix">
                    <div class="product-quantity">
                        <input type="text" value="1" name="qty" id="qty">
                    </div>
                    <button type="submit" id="addToCart" class="add-to-cart">add to cart</button>
                    {{-- <button type="button" id="test" class="add-to-cart">test</button> --}}
                </div>

                </form>
                
            </div><!-- Product Content End -->
            
        </div><!-- Product Wrapper End-->
        
        <!-- Product Additional Info Start-->
        <div class="row">
            <div class="col-12 mt-30">
                <ul class="pro-info-tab-list nav">
                    <li><a class="active" data-toggle="tab" href="#more-info">More info</a></li>
                </ul>
            </div>

            <div class="tab-content col-12">
                <div class="pro-info-tab tab-pane active" id="more-info">
                    <p>{!! $product->description !!}</p>
                </div>
            </div>
        </div>
        
    </div>
</div>
<!-- Product Section End-->
@endsection
@section('extra-scripts')
<script type="text/javascript">
$(".alertMsg").fadeIn("fast").delay(3000).fadeOut("slow");

function colorChange(radioName)
{
    let prodAttribID = $(`input[name="${radioName}"]:checked`).attr("product_attribute_id");

    $(".prod-img-box .d-block").removeClass("d-block").addClass("d-none");
    $(`.prod-img-box .color-img-${prodAttribID}`).removeClass("d-none").addClass("d-block");
}
</script>
@endsection