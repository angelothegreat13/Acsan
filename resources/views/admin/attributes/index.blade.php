@extends('admin.app')
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Product Attributes</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Product Attributes</li>
                </ol>
            </div>
        </div>
    </div>
</section>
<section class="content">
    <div class="text-right mb-3">
        <a href="{{ route('admin.attributes.create-option') }}" class="btn bg-gradient-primary">Add New Option</a>
    </div>
    @if ($message = Session::get('success'))
        <div class="alertMsg alert alert-success alert-dismissible py-3">
            <i class="icon fas fa-check"></i> {{ $message }}
        </div>
    @endif
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Product Attributes List</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <table id="attributesTable" class="table table-bordered table-striped">
                <thead>
                    <tr class="text-center">
                        <th>ID</th>
                        <th>Option</th>
                        <th>Values</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($options as $option)
                    <tr class="text-center">
                        <td>{{ $option->id }}</td>
                        <td class="text-sm">
                            {{ ucwords($option->label) }}
                            <a href="{{ route('admin.attributes.edit-option',$option->id) }}" class=" d-block">Edit Option</a>
                        </td>
                        <td>
                            <small>
                                @php
                                    $values = '';
                                    foreach ($option->productOptionValues as $optionValue) {
                                        $values .= ucwords($optionValue->name).',';
                                    }
                                    echo rtrim($values,",");
                                @endphp
                            </small>
                            <a href="{{ route('admin.attributes.manage-option-values',$option->id) }}" class="text-sm d-block">Manage Values</a>
                        </td>
                        <td>
                            <form action="{{ route('admin.attributes.destroy-option', $option->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Are you sure to delete?')" class="btn btn-sm btn-danger" title="Delete Product"><i class="fas fa-trash"></i></button>
                            </form>
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
    $("#attributesTable").DataTable({
        "responsive": true,
        "autoWidth": false,
    });
    
    $(".alertMsg").fadeIn("fast").delay(3000).fadeOut("slow");
});
</script>
@endsection