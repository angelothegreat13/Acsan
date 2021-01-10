@extends('web.app')
@section('extra-css')
    {!! NoCaptcha::renderJs() !!}
@endsection
@section('content')
<div class="row">
    <div class="card border p-5 mt-5 col-xs-10 col-sm-8 col-md-6 col-lg-5 mx-auto" style="margin-bottom:100px;">
        <h3 class="text-center mb-4">Registration Form</h3>
        <form action="{{ route('registration.process') }}" method="POST">
            @csrf
            <div class="form-group">
                <label class="font-weight-bold text-lg" for="firstname">First Name</label>
                <input type="text" class="form-control" name="firstname" id="firstname" value="{{ old('firstname') }}" required>
                @error('firstname')<small class="form-text text-danger font-italic font-weight-bold">{{ $message }}</small>@enderror
            </div>
            <div class="form-group">
                <label class="font-weight-bold text-lg" for="lastname">Last Name</label>
                <input type="text" class="form-control" name="lastname" id="lastname" value="{{ old('lastname') }}" required>
                @error('lastname')<small class="form-text text-danger font-italic font-weight-bold">{{ $message }}</small>@enderror
            </div>
            <div class="form-group">
                <label class="font-weight-bold text-lg" for="email">Email address</label>
                <input type="email" class="form-control" name="email" id="email" value="{{ old('email') }}" required>
                @error('email')<small class="form-text text-danger font-italic font-weight-bold">{{ $message }}</small>@enderror
            </div>
            <div class="form-group">
                <label class="font-weight-bold text-lg" for="contact_number">Contact Number</label>
                <input type="text" class="form-control" name="contact_number" id="contact_number" value="{{ old('contact_number') }}" required>
                @error('contact_number')<small class="form-text text-danger font-italic font-weight-bold">{{ $message }}</small>@enderror
            </div>
            <div class="form-group">
                <label class="font-weight-bold text-lg" for="address">Address</label>
                <textarea class="form-control text-xs" name="address" id="address" rows="3" required>{{ old('address') }}</textarea>
                @error('address')<small class="form-text text-danger font-italic font-weight-bold">{{ $message }}</small>@enderror
            </div>
            <div class="form-group">
                <label class="font-weight-bold text-lg" for="password">Password</label>
                <input type="password" class="form-control" name="password" id="password" required>
                @error('password')<small class="form-text text-danger font-italic font-weight-bold">{{ $message }}</small>@enderror
            </div>
            <div class="form-group">
                <label class="font-weight-bold text-lg" for="password_confirmation">Confirm Password</label>
                <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" required>
            </div>
            <div class="form-group">
                {!! app('captcha')->display() !!}
                @if ($errors->has('g-recaptcha-response'))
                    <small class="form-text text-danger font-italic font-weight-bold">
                        {{ $errors->first('g-recaptcha-response') }}
                    </small>
                @endif
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-info">Register</button>
            </div>
        </form>
    </div>
</div>
@endsection