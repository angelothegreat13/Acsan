@extends('admin.app')
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Orders</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Orders</li>
                </ol>
            </div>
        </div>
    </div>
</section>
<section class="content">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">List of Orders</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <table id="ordesTable" class="table table-bordered table-striped">
                <thead>
                    <tr class="text-center">
                        <th>ID</th>
                        <th>Customer</th>
                        <th>Total Price</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th>Manage</th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($orders  as $order)
                    <tr class="text-center">
                        <td>{{ $order->id }}</td>
                        <td>{{ ucwords($order->customer->firstname.' '.$order->customer->lastname) }}</td>
                        <td>₱ {{ number_format((float)$order->total, 2, '.', '') }}</td>
                        <td><span class="badge badge-pill badge-secondary py-2 px-3">{{ ucwords($order->orderStatus->name) }}</span></td>
                        <td>{{ $order->created_at->format('m-d-Y H:i') }}</td>
                        <td>
                            <a href="{{ route('admin.orders.manage',$order->id) }}" class="btn btn-sm btn-success" title="Manage Order"><i class="fas fa-edit"></i></a>
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
    $("#ordesTable").DataTable({
        "responsive": true,
        "autoWidth": false,
        "order": [[ 0, "desc" ]]
    });
});
</script>
@endsection