@extends('web.app')
@section('content')
<div class="row">
    
    <div class="card border p-5 mt-5 col-xs-10 col-sm-8 col-md-6 col-lg-5 mx-auto" style="margin-bottom:100px;">
        @if ($message = Session::get('success'))
            <div class="alertMsg alert alert-success text-center" role="alert">
                <p>{{ $message }}</p>
            </div>
        @endif

        @if (count($errors))
            <div class="alertMsg alert alert-danger" role="alert">
                <ul>
                    @foreach ($errors->all() as $message) 
                        <li class="text-xs">{{ $message }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <h3 class="text-center mb-4">Login Form</h3>
        <form action="{{ route('auth.process-login') }}" method="POST">
            @csrf
            <div class="form-group">
                <label class="font-weight-bold text-lg" for="email">Email address</label>
                <input type="email" class="form-control" name="email" id="email" placeholder="Enter email" value="{{ old('email') }}" required>
                @error('email')<small class="form-text text-danger font-italic font-weight-bold">{{ $message }}</small>@enderror
            </div>
            <div class="form-group">
                <label class="font-weight-bold text-lg" for="password">Password</label>
                <input type="password" class="form-control" name="password" id="password" placeholder="Password" required>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary">SIGN IN</button>
            </div>
            <div class="form-group text-center">
                <span>Don't have an account? </span><a href="{{ route('registration.index') }}" class="text-info font-weight-bold">Register Here</a>
            </div>
        </form>
    </div>
</div>
@endsection
@section('extra-scripts')
<script type="text/javascript">
    $(".alertMsg").fadeIn("fast").delay(5000).fadeOut("slow");
</script>
@endsection