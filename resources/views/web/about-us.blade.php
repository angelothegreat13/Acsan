@extends('web.app')
@section('content')
<!-- About Section Start-->
<div class="about-section section pt-120 pb-90">
    <div class="container">
        <div class="row flex-row-reverse">
            
            <!-- About Image -->
            <div class="about-image col-lg-6 col-12 mb-30">
                <a class="video-popup" href="https://www.youtube.com/watch?v=N1jKlda6SEs">
                <img src="{{ asset('img/logo_big.png') }}"></a>
            </div>
            
            <!-- Mission Content -->
            <div class="about-content col-lg-6 col-12 mb-30">
                <h2>About <span>Acsan Enterprise</span></h2>
                <p>Acsan Enterprise is a trading company engaged in offset and letterpress printing services of all kinds of forms,boxes, packaging label sticker, receipt, poster, paper bags, calendars, papers and other related printing services.
We also offer our services to provide your needs in promotional giveaways such as umbrellas, eco bags, ballpens, mugs, calendar, planner, t-shirt, customized polo shirts, silkscreen, heat pressed printing and more.</p>
                <a href="{{ route('home') }}" class="button">Shop Now</a>
            </div>
            
        </div>
    </div>
</div>
<!-- About Section End-->
    
<!-- Contact Section Start-->
<div class="contact-section section bg-white pt-120 py-5">
    <div class="container">
        <div class="row">
            
            <div class="col-xl-10 col-12 ml-auto mr-auto">
                
                <div >
                    <div class="row">

                        <div class="contact-info col-lg-5 col-12">
                            <h4 class="title">Contact Info</h4>
                            <ul>
                                <li><span>Address:</span>Blk 3 Lot 6 Sipvestre St. Genesiz Village, San Isidro, Cainta, Rizal</li>
                                <li><span>Email:</span>acsan2288@gmail.com</li>
                                <li><span>Phone:</span>0917-926-7112</li>
                            </ul>
                            <div class="contact-social">
                                <a href="https://www.facebook.com/acsanenterprise" target="_blank"><i class="fa fa-facebook"></i></a>
                            </div>
                        </div>
                        <div class="contact-form col-lg-7 col-12">
                            <h4 class="title">Feedback</h4>
                            @if ($message = Session::get('success'))
                                <div class="alertMsg alert alert-success text-center" role="alert">
                                    <p>{{ $message }}</p>
                                </div>
                            @endif
                            <form action="{{ route('send-feedback') }}" method="POST">
                                @csrf
                                <input type="text" name="name" placeholder="Your Name" required>
                                <input type="email" name="email" placeholder="Your Email" required>
                                <textarea name="message" placeholder="Your Message" required></textarea>
                                <button type="submit" class="btn btn-primary text-sm">Send Message</button>
                            </form>
                        </div>

                    </div>
                </div>
                
            </div>
        
        </div>
    </div>
</div>
<!-- Contact Section End-->    
@endsection
@section('extra-scripts')
<script type="text/javascript">
    $(".alertMsg").fadeIn("fast").delay(5000).fadeOut("slow");
</script>
@endsection