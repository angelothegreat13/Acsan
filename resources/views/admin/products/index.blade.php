@extends('admin.app')
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Products</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Products</li>
                </ol>
            </div>
        </div>
    </div>
</section>
<section class="content">
    <div class="text-right mb-3">
        <a href="{{ route('admin.products.create') }}" class="btn bg-gradient-primary">Add New Product</a>
    </div>
    @if ($message = Session::get('success'))
        <div class="alertMsg alert alert-success alert-dismissible py-3">
            <i class="icon fas fa-check"></i> {{ $message }}
        </div>
    @endif
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Products List</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <table id="productsTable" class="table table-bordered table-striped">
                <thead>
                    <tr class="text-center">
                        <th>ID</th>
                        <th>Product</th>
                        <th>Image</th>
                        <th>Category</th>
                        <th>Price</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($products as $product)
                    <tr class="text-center">
                        <td>{{ $product->id }}</td>
                        <td>{{ $product->name }}</td>
                        <td><img src="{{ asset($product->image) }}" alt="{{ $product->name }}" height="60" width="60"></td>
                        <td>{{ $product->category->name }}</td>
                        <td>{{ $product->price }}</td>
                        <td>
                            <a href="{{ route('admin.products.edit',$product->id) }}" class="btn btn-sm btn-success" title="Edit Product"><i class="fas fa-edit"></i></a>
                            <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Are you sure to delete?')" class="btn btn-sm btn-danger" title="Delete Product"><i class="fas fa-trash"></i></button>
                            </form>
                            <a href="{{ route('admin.products.attribute',$product->id) }}" class="btn btn-sm btn-warning" title="Manage Product Attributes"><i class="fas fa-list"></i></a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>  
</section>
@endsection
@section('extra-scripts')
<script type="text/javascript">
$(function () {
    $("#productsTable").DataTable({
        "responsive": true,
        "autoWidth": false,
        "order": [[ 0, "desc" ]]
    });
    
    $(".alertMsg").fadeIn("fast").delay(3000).fadeOut("slow");
});
</script>
@endsection