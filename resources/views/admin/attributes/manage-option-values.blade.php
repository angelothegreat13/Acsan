@extends('admin.app')
@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 style="font-size:22px;">Option Value for: {{ $option->label }}</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.attributes.index') }}">Products Attributes List</a></li>
                    <li class="breadcrumb-item active">Manage Option Value</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<section class="content">
<div class="row">
    @if ($message = Session::get('success'))
        <div class="col-md-12">
            <div class="alertMsg alert alert-success alert-dismissible py-3">
                <i class="icon fas fa-check"></i> {{ $message }}
            </div>
        </div>
    @endif

    <div class="col-md-5">
        <div class="card card-default">
            <div class="card-header">
                <h3 class="card-title">Add New Option Value</h3>
            </div>
            <form action="{{ route('admin.attributes.store-option-value') }}" method="POST" role="form">
                @csrf
                <div class="card-body">
                    @if (count($errors))
                        <div class="alertMsg alert alert-danger" role="alert">
                            {{ $errors->first() }}
                        </div>
                    @endif
                    <input type="hidden" name="option_id" value="{{ $option->id }}">
                    <div class="form-group">
                        <label for="name">Option Value Name</label>
                        <input type="text" class="form-control" name="name" autocomplete="off" required>
                    </div>
                    <div class="form-group">
                        <a href="{{ route('admin.attributes.index') }}" class="btn btn-danger mr-1">Back</a>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="col-md-7">
        <div class="card card-default">
            <div class="card-header">
                <h3 class="card-title">List of Option Values</h3>
            </div>
            <div class="card-body p-0 py-1">
                <table id="attributesTable" class="table table-striped table-condensed">
                <thead>
                    <tr class="text-center">
                        <th>ID</th>
                        <th>Option Value</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($option->productOptionValues as $optionValue)
                        <tr class="text-center">
                            <td>{{ $optionValue->id }}</td>
                            <td>{{ ucwords($optionValue->name) }}</td>
                            <td>
                                <button 
                                    type="button"
                                    class="btn btn-sm btn-success" 
                                    title="Edit Option Value" 
                                    data-toggle="modal" 
                                    data-target="#editOptionValueModal"
                                    onclick="editOptionValue({{ json_encode($optionValue->id) }})"
                                ><i class="fas fa-edit"></i></button>
                                <form action="{{ route('admin.attributes.destroy-option-value', $optionValue->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('Are you sure to delete?')" class="btn btn-sm btn-danger" title="Delete Product"><i class="fas fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr class="text-center font-weight-bold"><td colspan="3">No Option Values</td></tr>
                    @endforelse
                </tbody>
            </table>
            </div>
        </div>
    </div>

    <!-- Edit Option Value Modal -->
    <div class="modal fade" id="editOptionValueModal" tabindex="-1" role="dialog" aria-labelledby="editOptionValueTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Option Value</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="#" method="POST" role="form" id="editOptionValueForm">
                    @method('PATCH') 
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name">Option Value Name</label>
                            <input type="text" class="form-control optionValueName" name="name" required>
                            @error('name')<small class="form-text text-danger font-italic font-weight-bold">{{ $message }}</small>@enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</section>
@endsection
@section('extra-scripts')
<script type="text/javascript">
$(".alertMsg").fadeIn("fast").delay(3000).fadeOut("slow");

function editOptionValue(optionValueID)
{
    let baseURL = window.location.origin+"/admin/attributes/";

    $.ajax({
        type: "GET",
        url: baseURL+optionValueID+"/edit-option-value",
        dataType: "JSON",
        success: function (res, textStatus, xhr) 
        {
            if (xhr.status === 200) 
            {
                $("#editOptionValueForm").attr("action", baseURL+optionValueID+"/update-option-value");
                $("#editOptionValueForm .optionValueName").val(res.name);
            }
            else {
                alert("Something went wrong, SHIT!!!");
            }
        }
    });
}

</script>
@endsection