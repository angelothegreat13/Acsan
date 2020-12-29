@include('admin.layouts._top')
<div class="wrapper">
    @include('admin.layouts._navbar')
    @include('admin.layouts._sidebar')
    <div class="content-wrapper">
        @yield('content')
    </div>
    @include('admin.layouts._footer')
</div>
@include('admin.layouts._bottom')