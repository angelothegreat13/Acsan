<!-- Footer Section Start-->
<div class="footer-section section bg-dark" >
    <div class="container">
        
        <div class="row">
            <div class="col">

                <!-- Footer Top Start -->
                <div class="footer-top section pt-80 pb-50">
                    <div class="row">

                        <!-- Footer Widget -->
                        <div class="footer-widget col-lg-4 col-md-6 col-12 mb-40">
                            <img class="footer-logo" src="{{ asset('img/test.png') }}" alt="logo">
                            <p>Acsan Enterprise is a trading company engaged in offset and letterpress printing services of all kinds of forms,boxes, packaging label sticker, receipt, poster, paper bags, calendars, papers and other related printing services. We also offer our services to provide your needs in promotional giveaways such as umbrellas, eco bags, ballpens, mugs, calendar, planner, t-shirt, customized polo shirts, silkscreen, heat pressed printing and more.</p>
                        </div>

                        <!-- Footer Widget -->
                        <div class="footer-widget col-lg-2 col-md-3 col-12 mb-40">
                            <h4 class="widget-title">Information</h4>
                            <ul>
                                <li><a href="{{ route('about-us') }}">About us</a></li>
                                <li><a href="{{ route('faqs') }}">Faqs</a></li>
                            </ul>  
                        </div>

                        <!-- Footer Widget -->
                        <div class="footer-widget col-lg-2 col-md-3 col-12 mb-40">
                            <h4 class="widget-title">Products</h4>
                            <ul>
                                 @foreach ($categories as $category)
                                    <li><a href="{{ URL::to($category->slug) }}">{{ $category->name }}</a></li>
                                @endforeach
                            </ul>  
                        </div>

                        <!-- Footer Widget -->
                        <div class="footer-widget col-lg-4 col-md-6 col-12 mb-40">
                            <h4 class="widget-title">Contact Us</h4>
                            <ul>
                                <li><span>Address:</span> Blk 3 Lot 6 Sipvestre St. Genesiz Village, San Isidro, Cainta, Rizal</li>
                                <li><span>Phone:</span> 0917-926-7112</li>
                                <li><span class="mr-1">Facebook:</span> <a href="https://www.facebook.com/acsanenterprise">https://www.facebook.com/acsanenterprise</a></li>
                                <li><span>Email:</span> acsan2288@gmail.com</li>
                            </ul>  
                        </div>

                    </div>
                </div><!-- Footer Top End -->
                
            </div>
        </div>
        
    </div>
</div><!-- Footer Section End-->