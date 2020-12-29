<!-- Header Bottom Start -->
<div class="header-bottom section">
    <div class="container">
        <div class="row">
            
            <!-- Header Bottom Wrapper Start -->
            <div class="header-bottom-wrapper text-center col">

                <!-- Header Bottom Logo -->
                <div class="header-bottom-logo">
                    <a href="/" class="logo"><img src="{{ asset('img/test.png') }}" alt="logo"></a>
                </div>

                <!-- Main Menu -->
                <nav id="main-menu" class="main-menu">
                    <ul>
                        <li class="{{ Route::current()->getName() == 'home' ? 'active' : '' }}"><a href="/">Home</a></li>
                        <li>
                            <a href="#" onclick="return false;">Products</a>
                            <ul class="sub-menu">
                                @foreach ($categories as $category)
                                    <li><a href="{{ URL::to($category->slug) }}">{{ $category->name }}</a></li>
                                @endforeach
                            </ul>
                        </li>
                        <li class="{{ Route::current()->getName() == 'faqs' ? 'active' : '' }}"><a href="{{ route('faqs') }}">Faqs</a></li>
                        <li class="{{ Route::current()->getName() == 'about-us' ? 'active' : '' }}"><a href="{{ route('about-us') }}">About Us</a></li>
                    </ul>
                </nav>
                
                <!-- Mobile Menu -->
                <div class="mobile-menu section d-md-none"></div>

            </div><!-- Header Bottom Wrapper End -->
            
        </div>
    </div>
</div>
<!-- Header Bottom End -->