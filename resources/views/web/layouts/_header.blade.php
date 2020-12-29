<!-- Header Top Start -->
<div class="header-top">
    <div class="container">
        <div class="row">
            <div class="col">
                <!-- Header Top Wrapper Start -->
                <div class="header-top-wrapper">
                    <div class="row">

                        <!-- Header Social -->
                        <div class="header-social col-md-4 col-12">
                            {{-- <a href="#"><i class="fa fa-facebook"></i></a>
                            <a href="#"><i class="fa fa-twitter"></i></a>
                            <a href="#"><i class="fa fa-linkedin"></i></a>
                            <a href="#"><i class="fa fa-instagram"></i></a>
                            <a href="#"><i class="fa fa-pinterest-p"></i></a> --}}
                        </div>

                        <!-- Header Logo -->
                        <div class="header-logo col-md-4 col-12">
                            <a href="{{ route('home') }}" class="logo"><img src="{{ asset('img/test.png') }}" alt="logo"></a>
                        </div>

                        <!-- Account Menu -->
                        <div class="account-menu col-md-4 col-12">
                            <ul>
                                @if (Auth::guard('customer')->check())
                                    <div class="dropdown">
                                        <button class="btn btn-default dropdown-toggle" style="font-size:12px;padding:0;" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            {{ currentCustomer()->firstname."'s Account" }}
                                        </button>   
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            <a class="dropdown-item" style="font-size:12px;" href="{{ route('profile.index') }}">Manage Profile</a>
                                            <a class="dropdown-item" style="font-size:12px;" href="{{ route('orders.index') }}">My Orders</a>
                                            <a class="dropdown-item" style="font-size:12px;" href="{{ route('change-password') }}">Change Password</a>
                                        </div>
                                    </div>
                                    <li><a href="{{ route('auth.logout') }}">Logout</a></li>
                                @else 
                                    <li><a href="{{ route('auth.login') }}">Login</a></li>
                                    <li><a href="{{ route('registration.index') }}">Register</a></li>
                                @endif
                                <li>
                                    <a href="{{ route('cart.index') }}">
                                        Cart <i class="fa fa-shopping-cart"></i><span class="num">{{ $totalCartQty }}</span>
                                    </a>
                                </li>
                            </ul>
                        </div>

                    </div>
                </div><!-- Header Top Wrapper End -->
            </div>
        </div>
    </div>
</div><!-- Header Top End -->