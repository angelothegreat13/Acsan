@extends('admin.app')
@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Feedback Details</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.feedbacks.index') }}">Feedbacks List</a></li>
                    <li class="breadcrumb-item active">Feedback Message</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <div class="card card-primary">
        <!-- form start -->
        <form role="form">
            <div class="card-body">
                <div class="form-group">
                    <label>Email address</label>
                    <input type="email" class="form-control" value="{{ $feedback->email }}" readonly>
                </div>

                <div class="form-group">
                    <label>Sender Name</label>
                    <input type="text" class="form-control" value="{{ $feedback->name }}" readonly>
                </div>

                <div class="form-group">
                    <label>Full Message</label>
                    <textarea class="form-control" rows="5" readonly>{{ $feedback->message }}</textarea>
                </div>

                <div class="form-group">
                    <a href="{{ route('admin.feedbacks.index') }}" class="btn btn-danger">Back</a>
                </div>
            </div>
        </form>
    </div>
</section>
@endsection