@extends('admin.app')
@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Create New Product Attribute</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.products.index') }}">Products List</a></li>
                    <li class="breadcrumb-item active">New Product Attribute</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <div class="card card-default">
        <div class="card-header">
            <h3 class="card-title">List of Added Options and Option Values</h3>
        </div>

        <div class="card-body">
            <div class="text-right">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#attrib-modal">
                    Add Additional Option
                </button>
            </div><br>

            @if ($message = Session::get('success'))
                <div class="alertMsg alert alert-success mb-3" role="alert">
                    <p>{{ $message }}</p>
                </div>
            @endif

            @if (count($errors))
                <div class="alertMsg alert alert-danger mb-3" role="alert">
                    {{ $errors->first() }}
                </div>
            @endif

            <table class="table table-condensed table-striped">
            <thead>
                <tr class="text-center">
                    <th>Option Name</th>
                    <th>Option Value</th>
                    <th>Price</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($attributes as $attribute)
                    <tr class="text-center">
                        <td>{{ ucwords($attribute->option) }}</td>
                        <td>{{ ucwords($attribute->option_value) }}</td>
                        <td>{{ $attribute->price }}</td>
                        <td>
                            <form action="{{ route('admin.product-attrib.destroy', $attribute->product_attrib_id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Are you sure to delete?')" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i> Remove</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr class="text-center">
                        <td colspan="4"><strong>No Attributes</strong></td>
                    </tr>
                @endforelse
            </tbody>
            </table>

            {{-- product option, option value modal --}}
            <div class="modal fade" id="attrib-modal">
                <div class="modal-dialog modal-md">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Add Colors,Sizes and Fabrics</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="{{ route('admin.product-attrib.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">
                            <input type="hidden" name="product_id" id="product_id" value="{{ $productID }}">
                            <div class="form-group">
                                <label for="option_name">Option Name</label>
                                <select class="form-control" name="option_name" id="option_name" required>
                                    <option value="">Select option to fillup option value</option>
                                    @foreach ($options as $option)
                                        <option value="{{ $option->id }}" data-type="{{ $option->type }}">{{ ucwords($option->label) }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="name">Option Value</label>
                                <select class="form-control" name="option_value" id="option_value" required>
                                    
                                </select>
                            </div>

                            <div class="form-group color-img" style="display:none;">
                                <label for="color_img">Color Image</label><br>
                                <input type="file" name="color_img" id="color_img" accept="image/x-png,image/gif,image/jpeg">
                            </div>

                            <div class="form-group">
                                <label for="price" >Price</label>
                                <input type="number" class="form-control" name="price" id="price" placeholder="Option Value Price" value="0" autocomplete="off" required>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" id="addOption">Add Option</button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@section('extra-scripts')
<script type="text/javascript">
$(function () {
    $(".alertMsg").fadeIn("fast").delay(3000).fadeOut("slow");

    $("#option_name").on("change", function () 
    {
        let optionType = $(this).find(":selected").attr("data-type");
        let optionValueURL = window.location.origin + "/admin/product-option-values";
        let optionValueHTML = "";


        // get option values based on option id
        $.ajax({
            type: "POST",
            url: optionValueURL,
            data: {optionID: $(this).val()},
            dataType: "JSON",
            success: function (res, textStatus, xhr) 
            {   
                if (xhr.status === 200) 
                {
                    if (optionType === "colorpicker") {
                        $(".color-img").show();
                    } else {
                        $(".color-img").hide();
                        $("#color_img").val("");
                    }

                    for (const i in res) {
                        let optionValue = res[i];
                        let optionValueName = optionValue.name.toLowerCase().replace(/\b[a-z]/g, function(letter) {
                            return letter.toUpperCase();
                        });

                        optionValueHTML+= `<option value="${optionValue.id}">${optionValueName}</option>`;
                    }

                    $("#option_value").html(optionValueHTML);
                }
            }
        });
    });
})
</script>
@endsection