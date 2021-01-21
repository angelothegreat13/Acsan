@extends('admin.app')
@section('extra-css')
<style>
    #salesTable tbody tr {
        text-align: center !important;
    }
</style>
@endsection
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
    <div class="text-right mb-3">
        <button type="button" class="btn btn-primary mr-1" id="daily">Daily</button>
        <button type="button" class="btn btn-danger mr-1" id="weekly">Weekly</button>
        <button type="button" class="btn btn-warning mr-1" id="monthly">Monthly</button>
        <button type="button" class="btn btn-info mr-1" id="yearly">Yearly</button>
        <form method="POST" action="{{ route('admin.sales-report.export-excel') }}" style="display:inline;">
            @csrf
            <input type="hidden" id="filter" name="filter" value="">
            <button type="submit" class="btn btn-success">Export Excel</button>
        </form>
    </div>

    <div class="card">
        <div class="card-header pt-10">
            <h3 class="card-title text-lg sales-title">Overall Sales</h3>
            <h3 class="card-title text-lg float-right">Total Sales: ₱ <span class="total-sale">{{ number_format((float)$totalSales, 2, '.', '') }}</span></h3>
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
<script src="{{ asset('plugins/moment/moment.min.js') }}"></script>
<script type="text/javascript">
$(function () {
    $("#salesTable").DataTable({
        "responsive": true,
        "autoWidth": false,
        "order": [[ 0, "desc" ]],
        'processing': true,
    });

    const salesReportFilterURL = {!! json_encode(route('admin.sales-report.filter')) !!};
    const prettyDate = date => moment(date).format('MM-DD-YYYY HH:mm');

    function populateTable(data)
    {
        $("#salesTable").DataTable().clear().draw();

        let totalSales = 0;

        for (const i in data) 
        {
            let customerName = data[i].customer.firstname + " " + data[i].customer.lastname;

            $('#salesTable').dataTable().fnAddData([
                data[i].id,
                customerName.toLowerCase().replace(/(?<= )[^\s]|^./g, a=>a.toUpperCase()),
                "₱ "+data[i].total.toFixed(2),
                prettyDate(data[i].created_at)
            ]);
            
            totalSales += parseFloat(data[i].total);
        }

        $(".total-sale").text(totalSales.toFixed(2));
    }

    function filterData(type)
    {
        $("#filter").val(type);

        $.ajax({
            type: "GET",
            url: salesReportFilterURL,
            data: { type:type },
            dataType: "JSON",
            success: function (res) {
                populateTable(res);
            }
        });
    }

    $("#daily").click(function () { 
        $(".sales-title").text("Daily Sales Report");
        filterData("daily");
    });

    $("#weekly").click(function () { 
        $(".sales-title").text("Weekly Sales Report");
        filterData("weekly");
    });

    $("#monthly").click(function () { 
        $(".sales-title").text("Monthly Sales Report");
        filterData("monthly");
    });

    $("#yearly").click(function () { 
        $(".sales-title").text("Yearly Sales Report");
        filterData("yearly");
    });
});
</script>    
@endsection