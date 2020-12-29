@include('web.layouts._top')

<div id="main-wrapper" class="section">
    <div class="header-section section">
        @include('web.layouts._header')
        @include('web.layouts._navbar')
    </div>
    @yield('content')
</div>

@include('web.layouts._footer')
@include('web.layouts._bottom')