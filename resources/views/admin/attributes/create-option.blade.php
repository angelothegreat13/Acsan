@extends('admin.app')
@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Create New Option</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.attributes.index') }}">Products Attributes List</a></li>
                    <li class="breadcrumb-item active">Create New Option</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <div class="card border col-xs-10 col-sm-8 col-md-6 col-lg-6 mx-auto">
        <form action="{{ route('admin.attributes.store-option') }}" method="POST" role="form">
            @csrf
            <div class="card-body">
                <div class="form-group">
                    <label for="label">Option Label</label>
                    <input type="text" class="form-control" name="label" id="label" value="{{ old('label') }}" autocomplete="off" required>
                    @error('label')<small class="form-text text-danger font-italic font-weight-bold">{{ $message }}</small>@enderror
                </div>

                <div class="form-group">
                    <label for="type">Option Type</label>
                    <select class="form-control" name="type" id="type" required>
                        <option value="dropdown" {{ old('type') == 'dropdown' ? "selected" : "" }}>dropdown</option>
                        <option value="colorpicker" {{ old('type') == 'colorpicker' ? "selected" : "" }}>colorpicker</option>
                    </select>
                </div>

                <div class="form-group">
                    <a href="{{ route('admin.attributes.index') }}" class="btn btn-danger mr-1">Back to Attributes</a>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </form>
    </div>
</section>
@endsection