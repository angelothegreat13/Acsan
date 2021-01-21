@extends('admin.app')
@section('content')
<section class="content-header">
    <div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
        <h1>Order Details</h1>
        </div>
        <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('admin.orders.index') }}">Orders List</a></li>
            <li class="breadcrumb-item active">Order Details</li>
        </ol>
        </div>
    </div>
    </div><!-- /.container-fluid -->
</section>

<section class="content">
    <div class="container-fluid">
    <div class="row">
        <div class="col-12">

        <!-- Main content -->
        <div class="invoice p-3 mb-3">
            <div class="row">
                <div class="col-12">
                    <h4>
                        <i class="fas fa-globe text-primary"></i> Acsan, Inc.
                        <small class="float-right">Date: {{ $order->created_at->format('m-d-Y H:i') }}</small>
                    </h4>
                </div>
            </div>
            <!-- info row -->
            <div class="row invoice-info">
            <div class="col-sm-4 invoice-col">
                <strong>Customer Details:</strong>
                <address>
                {{ $customer->firstname.' '.$customer->lastname }}<br>
                {{ $customer->address }}<br>
                Contact Number: {{ $customer->contact_number }}<br>
                Email: {{ $customer->email }}
                </address>
            </div>
            <!-- /.col -->
            <!-- /.col -->
            <div class="col-sm-4 invoice-col">
                <b>Order ID:</b> {{ $order->id }}<br>
                <b>Total Quantity:</b> {{ $totalQty }}
            </div>
            <!-- /.col -->
            </div>
            <!-- /.row -->

            <!-- Table row -->
            <div class="row">
            <div class="col-12 table-responsive">
                <table class="table table-striped">
                <thead>
                    <tr class="text-center">
                        <th>Qty</th>
                        <th>Image</th>
                        <th>Product</th>
                        <th>Logo</th>
                        <th>Product Price</th>
                        <th>Attributes</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($data as $dt)
                        @php
                            $orderProduct = $dt['order_products'];
                            $orderProductAttribs = $dt['order_product_attribs'];
                        @endphp
                    <tr class="text-center">
                        <td>{{ $orderProduct->product_qty }}</td>
                        <td><img src="{{ asset($orderProduct->prod_img) }}" alt="{{ $orderProduct->product_name }}" height="60" width="60"></td>
                        <td>{{ $orderProduct->product_name }}</td>
                        <td>
                            @if ($orderProduct->logo !== NULL)
                                <img src="{{ asset($orderProduct->logo) }}" height="60" width="60">
                            @else 
                                None
                            @endif
                        </td>
                        <td>₱ {{ number_format((float)$orderProduct->product_price, 2, '.', '') }}</td>
                        <td>
                            @if (count($orderProductAttribs))
                                <ul style="font-size:12px;text-align:center;list-style-type: none;">
                                    @foreach ($orderProductAttribs as $orderProductAttrib)
                                        <li>{{ ucwords($orderProductAttrib->product_option) }}:{{ ucwords($orderProductAttrib->product_option_value) }} =  ₱ {{ number_format((float)$orderProductAttrib->product_option_value_price, 2, '.', '')  }}</li>
                                    @endforeach
                                </ul>
                            @else 
                                <p>No Attributes</p>
                            @endif
                        </td>
                        <td>₱ {{ number_format((float)$orderProduct->product_final_price, 2, '.', '') }}</td>
                    </tr>
                    @empty
                        <tr><td colspan="5" class="text-center font-weight-bold">No Order Product</td></tr>
                    @endforelse
                </tbody>
                </table>
            </div>
            <!-- /.col -->
            </div>
            <!-- /.row -->

            <div class="row">
            <!-- accepted payments column -->
            <div class="col-6">
                <p class="lead"><strong>Payment Method:</strong> Bank Deposit</p>
                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#bankStatementModal">
                    View Bank Statement
                </button>
                <hr>
                <form method="POST" action="{{ route('admin.orders.upload-delivery-receipt',$order->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH') 
                    <div class="form-group">
                        <input type="file" name="delivery_receipt" id="delivery_receipt" >
                        @error('delivery_receipt')<small class="form-text text-danger font-italic font-weight-bold">{{ $message }}</small>@enderror
                        @if ($message = Session::get('successDelivery'))
                            <p class="alertMsg form-text text-success font-italic mt-3">{{ $message }}</p>
                        @endif
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-info btn-sm">Attach Delivery Receipt</button>
                    </div>
                </form>
                <hr>

                <form action="{{ route('admin.orders.update-order-status',$order->id) }}" method="POST" role="form">
                    @csrf
                    @method("PATCH")
                    <div class="form-group mt-4">
                        <label for="status">Order Status</label>
                        <select name="status" id="status" class="form-control">
                            @foreach ($orderStatus as $status)
                                <option value="{{ $status->id }}" {{ $order->status == old('status', $status->id) ? 'selected' : '' }}>{{ ucwords($status->name) }}</option>
                            @endforeach
                        </select>
                        @if ($message = Session::get('success'))
                            <p class="alertMsg form-text text-success font-italic mt-3">{{ $message }}</p>
                        @endif
                    </div>

                    <div class="form-group">
                        <a href="{{ route('admin.orders.index') }}" class="btn btn-danger mr-1">Back to Orders List</a>
                        <button type="submit" class="btn btn-success" onclick="return confirm('Are you sure to update the status?')">Update Order Status</button>
                    </div>
                <form>
                
                <!-- Bank Statement Modal -->
                <div class="modal fade" id="bankStatementModal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Customer Bank Statement</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                @php
                                    $bankImg = ($order->bank_statement === NULL) ? 'img/placeholder.png' : $order->bank_statement ;
                                @endphp
                                <img src="{{ asset($bankImg) }}" class="img-fluid">
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.col -->
            <div class="col-6">
                <p class="lead"><strong>Order Summary:</strong></p>
                <div class="table-responsive">
                    <table class="table">
                        <tr>
                            <th style="width:50%">Subtotal:</th>
                            <td>₱ {{ number_format((float)$order->sub_total, 2, '.', '') }}</td>
                        </tr>
                        <tr>
                            <th>Shipping:</th>
                            <td>₱ 0.00</td>
                        </tr>
                        <tr>
                            <th>Total:</th>
                            <td>₱ {{ number_format((float)$order->total, 2, '.', '') }}</td>
                        </tr>
                    </table>
                </div>
            </div>
            <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.invoice -->
        </div><!-- /.col -->
    </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</section>
@endsection
@section('extra-scripts')
<script type="text/javascript">
$(function () {
    $(".alertMsg").fadeIn("fast").delay(3000).fadeOut("slow");
});
</script>
@endsection