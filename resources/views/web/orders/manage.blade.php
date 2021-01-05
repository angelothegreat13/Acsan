@extends('web.app')
@section('content')
<div class="container">

<nav aria-label="breadcrumb" class="mt-30 mb-30 shadow-sm">
    <ol class="breadcrumb">
        <li class="breadcrumb-item" style="color: #007bff;"><a href="{{ route('orders.index') }}">Orders List</a></li>
        <li class="breadcrumb-item active" aria-current="page">Manage Order</li>
    </ol>
</nav>

<div class="row mb-20">
    <div class="col-lg-6 col-12">
          <div class="card">
            <div class="card-header font-weight-bold" style="font-size:15px;color:#212121;">
                ORDER DETAILS
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-borderless">
                    <tbody>
                        <tr>
                            <th style="width:50%">Order ID</th>
                            <td>{{ $order->id }}</td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td><span class="badge badge-pill badge-secondary py-2 px-3">{{ ucwords($order->orderStatus->name) }}</span></td>
                        </tr>
                        <tr>
                            <th>Ordered Date</th>
                            <td>{{ $order->created_at->format('m-d-Y H:i') }}</td>
                        </tr>
                    </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-6 col-12">
          <div class="card">
            <div class="card-header font-weight-bold" style="font-size:15px;color:#212121;">
                SHIPPING DETAILS
            </div>
            <div class="card-body" style="line-height:8px;">
                <p><b style="color:#212121;">Recipient:</b> {{ $customer->firstname.' '.$customer->lastname }}</p>
                <p><b style="color:#212121;">Address:</b> {{ $customer->address }}</p>
                <p><b style="color:#212121;">Contact Number:</b> {{ $customer->contact_number }}</p>
                <p><b style="color:#212121;">Email Address:</b> {{ $customer->email }}</p>
            </div>
        </div>
    </div>
</div>

<div class="row mt-20">
    <div class="col-12">
        <div class="card">
            <div class="card-header font-weight-bold" style="font-size:15px;color:#212121;">
                ORDERED PRODUCTS
            </div>
            <div class="card-body pt-1 pb-0">
                <div class="table-responsive">
                    <table class="table table-striped table-borderless">
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
            </div>
        </div>
    </div>
</div>

<div class="row mb-50">
    <div class="col-lg-6 col-12 mt-30">
          <div class="card">
            <div class="card-header font-weight-bold" style="font-size:15px;color:#212121;">
                PAYMENT DETAILS
            </div>
            <div class="card-body">
                <form action="{{ route('orders.upload-bank-statement',$order->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH') 
                    <p><b style="color:#212121;">Payment Method:</b> Bank Deposit</p>
                    <div class="form-group">
                        <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#bankModal">View Bank Statement</button>
                    </div>
                    
                    <div class="form-group">
                        <input type="file" name="bank_statement" id="bank_statement" required>
                        @error('bank_statement')<small class="form-text text-danger font-italic font-weight-bold">{{ $message }}</small>@enderror
                        @if ($message = Session::get('success'))
                            <p class="alertMsg form-text text-success font-italic mt-3">{{ $message }}</p>
                        @endif
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-sm btn-primary">Upload Bank Statement</button>
                    </div>
                <form>
            </div>
        </div>
    </div>

    <div class="col-lg-6 col-12 mt-30">
          <div class="card">
            <div class="card-header font-weight-bold" style="font-size:15px;color:#212121;">
                ORDER SUMMARY
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-borderless">
                    <tbody>
                        <tr>
                            <th style="width:50%">Subtotal</th>
                            <td>₱ {{ number_format((float)$order->sub_total, 2, '.', '') }}</td>
                        </tr>
                        <tr>
                            <th>Shipping Fee</th>
                            <td>₱ 0.00</td>
                        </tr>
                        <tr>
                            <th>Grand Total</th>
                            <td>₱ {{ number_format((float)$order->total, 2, '.', '') }}</td>
                        </tr>
                    </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bank Statement Modal -->
<div class="modal fade" id="bankModal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Bank Statement</h5>
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
@endsection
@section('extra-scripts')
<script type="text/javascript">
$(function () {
    $(".alertMsg").fadeIn("fast").delay(3000).fadeOut("slow");
});
</script>
@endsection