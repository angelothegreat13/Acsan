@extends('web.app')
@section('content')
<div class="container mb-50">
<div class="row">
    <div class="col-lg-3 col-12 mt-40">
        @include('web.layouts._sidebar')
    </div>
    <div class="col-lg-9 col-12 mt-40">
        <div class="card">
            <div class="card-body">
                <h3 class="text-center mb-4">Manage Profile</h3>
                @if ($message = Session::get('success'))
                    <div class="alertMsg alert alert-success" role="alert">
                        <p>{{ $message }}</p>
                    </div>
                @endif
                <form action="{{ route('profile.update',currentCustomer()->id) }}" method="POST">
                    @method('PATCH') 
                    @csrf
                    <div class="form-group">
                        <label class="font-weight-bold text-lg" for="firstname">First Name</label>
                        <input type="text" class="form-control" name="firstname" id="firstname" value="{{ old('firstname',$customer->firstname) }}" required>
                        @error('firstname')<small class="form-text text-danger font-italic font-weight-bold">{{ $message }}</small>@enderror
                    </div>

                    <div class="form-group">
                        <label class="font-weight-bold text-lg" for="lastname">Last Name</label>
                        <input type="text" class="form-control" name="lastname" id="lastname" value="{{ old('lastname',$customer->lastname) }}" required>
                        @error('lastname')<small class="form-text text-danger font-italic font-weight-bold">{{ $message }}</small>@enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold text-lg" for="email">Email address</label>
                                <input type="email" class="form-control" name="email" id="email" value="{{ old('email',$customer->email) }}" required>
                                @error('email')<small class="form-text text-danger font-italic font-weight-bold">{{ $message }}</small>@enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold text-lg" for="contact_number">Contact Number</label>
                                <input type="text" class="form-control" name="contact_number" id="contact_number" value="{{ old('contact_number',$customer->contact_number) }}" required>
                                @error('contact_number')<small class="form-text text-danger font-italic font-weight-bold">{{ $message }}</small>@enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="font-weight-bold text-lg" for="address">Address</label>
                        <textarea class="form-control text-xs" name="address" id="address" rows="3" required>{{ old('address',$customer->address) }}</textarea>
                        @error('address')<small class="form-text text-danger font-italic font-weight-bold">{{ $message }}</small>@enderror
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-info">Update Profile</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

</div>
@endsection
@section('extra-scripts')
<script type="text/javascript">
    $(".alertMsg").fadeIn("fast").delay(5000).fadeOut("slow");
</script>
@endsection