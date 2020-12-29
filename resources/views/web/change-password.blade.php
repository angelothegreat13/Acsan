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
                <h3 class="text-center mb-4">Change Password</h3>
                @if ($message = Session::get('success'))
                    <div class="alertMsg alert alert-success" role="alert">
                        <p>{{ $message }}</p>
                    </div>
                @endif
                <form action="{{ route('change-password.update',currentCustomer()->id) }}" method="POST">
                    @method('PATCH') 
                    @csrf
                    <div class="form-group">
                        <label class="font-weight-bold text-lg" for="current_password">Current Password</label>
                        <input type="password" class="form-control" name="current_password" id="current_password" required>
                        @error('current_password')<small class="form-text text-danger font-italic font-weight-bold">{{ $message }}</small>@enderror
                    </div>

                    <div class="form-group">
                        <label class="font-weight-bold text-lg" for="new_password">New Password</label>
                        <input type="password" class="form-control" name="new_password" id="new_password" required>
                        @error('new_password')<small class="form-text text-danger font-italic font-weight-bold">{{ $message }}</small>@enderror
                    </div>

                    <div class="form-group">
                        <label class="font-weight-bold text-lg" for="new_confirm_password">Confirm New Password</label>
                        <input type="password" class="form-control" name="new_confirm_password" id="new_confirm_password" required>
                        @error('new_confirm_password')<small class="form-text text-danger font-italic font-weight-bold">{{ $message }}</small>@enderror
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-info">Save Changes</button>
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