@extends('web.app')
@section('extra-css')
    <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
@endsection
@section('content')
<div class="container mb-50">
<div class="row">
    <div class="col-lg-3 col-12 mt-40">
        @include('web.layouts._sidebar')
    </div>
    <div class="col-lg-9 col-12 mt-40">
        <div class="card">
            <div class="card-body">
                <h3 class="text-center mb-4">My Orders</h3>
                <table class="table table-striped" id="ordesTable">
                    <thead>
                        <tr class="text-center">
                            <th>ID</th>
                            <th>Status</th>
                            <th>Total</th>
                            <th>Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orders as $order)
                            <tr class="text-center">
                                <td>{{ $order->id }}</td>
                                <td><span class="badge badge-pill badge-secondary py-2 px-3">{{ ucwords($order->orderStatus->name) }}</span></td>
                                <td>₱ {{ number_format((float)$order->total, 2, '.', '') }}</td>
                                <td>{{ $order->created_at->format('m-d-Y H:i') }}</td>
                                <td>
                                    <a class="btn btn-sm btn-info" href="{{ route('orders.manage',$order->id) }}" role="button">Manage</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

</div>
@endsection
@section('extra-scripts')
<script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
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