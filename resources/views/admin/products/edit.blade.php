@extends('admin.app')
@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Edit Product</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.products.index') }}">Products List</a></li>
                    <li class="breadcrumb-item active">Edit Product</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <div class="card card-primary">
        <form action="{{ route('admin.products.update',$product->id) }}" method="POST" role="form" enctype="multipart/form-data">
            @method('PATCH') 
            @csrf
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-6">
                         <div class="form-group">
                            <label for="name">Product Name</label>
                            <input type="text" class="form-control" name="name" id="name" value="{{ old('name', $product->name) }}"  autocomplete="off" required>
                            @error('name')<small class="form-text text-danger font-italic font-weight-bold">{{ $message }}</small>@enderror
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="exampleInputPassword1">Select Category</label>
                            <select class="form-control" name="category" id="category">
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" {{ $category->id == old('category', $product->category_id) ? 'selected' : '' }}>{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-6">
                         <div class="form-group">
                            <label for="price">Price</label>
                            <input type="number" class="form-control" name="price" id="price" min="1" value="{{ old('price', $product->price) }}" autocomplete="off" required>
                            @error('price')<small class="form-text text-danger font-italic font-weight-bold">{{ $message }}</small>@enderror
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea 
                        class="description" 
                        name="description" 
                        id="description" 
                        style="width: 100%; height: 300px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;" 
                        required
                    >{!! old('description', $product->description) !!} 
                    </textarea>
                    @error('description')<small class="form-text text-danger font-italic font-weight-bold">{{ $message }}</small>@enderror
                </div>

                <div class="form-group">
                    <label for="image">Image</label>
                    <img id="output" src="{{ asset($product->image) }}" width="100" height="100">
                    <input type="file" name="image" id="image" accept="image/x-png,image/gif,image/jpeg" onchange="document.getElementById('output').src = window.URL.createObjectURL(this.files[0])">
                    @error('image')<small class="form-text text-danger font-italic font-weight-bold">{{ $message }}</small>@enderror
                </div>
            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
    </div>
</section>
@endsection
@section('extra-scripts')
<script type="text/javascript">
$(function () {
    $('.description').summernote();
})
</script>
@endsection