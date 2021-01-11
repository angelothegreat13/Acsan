@extends('admin.app')
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Sales Report</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Sales Report</li>
                </ol>
            </div>
        </div>
    </div>
</section>
<section class="content">
    <form method="POST" action="{{ route('admin.sales-report.export-excel') }}">
        @csrf
        <div class="text-right mb-3">
            <button type="submit" class="btn btn-success">Export Excel</button>
        </div>
    </form>
    
    <div class="card">
        <div class="card-header pt-10">
            <h3 class="card-title font-weight-bold text-lg">Total Sales: ₱ {{ number_format((float)$totalSales, 2, '.', '') }}</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body py-1">
            <table id="salesTable" class="table table-condensed table-striped">
                <thead>
                    <tr class="text-center">
                        <th>Order ID</th>
                        <th>Customer</th>
                        <th>Total Sale</th>
                        <th>Ordered Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($sales as $sale)
                        <tr class="text-center">
                            <td>{{ $sale->id }}</td>
                            <td>{{ ucwords($sale->customer->firstname.' '.$sale->customer->lastname) }}</td>
                            <td>₱ {{ number_format((float)$sale->total, 2, '.', '') }}</td>
                            <td>{{ $sale->created_at->format('m-d-Y H:i') }}</td>
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
    $("#salesTable").DataTable({
        "responsive": true,
        "autoWidth": false,
        "order": [[ 0, "desc" ]]
    });
});

</script>    
@endsection