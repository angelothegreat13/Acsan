@extends('admin.app')
@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Dashboard</h1>
            </div>
        </div>
    </div>
</div>
<!-- /.content-header -->

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $newOrders }}</h3>
                    <p>New Orders</p>
                </div>
                <div class="icon">
                    <i class="ion ion-bag"></i>
                </div>
                <a href="{{ route('admin.orders.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $totalProducts }}</h3>
                    <p>Total Products</p>
                </div>
                <div class="icon">
                    <i class="ion ion-pricetag"></i>
                </div>
                <a href="{{ route('admin.products.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ $totalCustomers }}</h3>
                    <p>Customer Registrations</p>
                </div>
                <div class="icon">
                    <i class="ion ion-person-add"></i>
                </div>
                <a href="{{ route('admin.customers.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-danger">
                <div class="inner">
                    <h3>{{ $totalCategories }}</h3>
                    <p>Total Categories</p>
                </div>
                <div class="icon">
                    <i class="ion ion-ios-list-outline"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
        </div>
        <!-- /.row -->

        <!-- Main row -->
        <div class="row mt-3">
            <div class="col-lg-12">
                <div class="text-right mb-3">
                    <button type="button" class="btn btn-primary mr-1" id="daily">Daily</button>
                    <button type="button" class="btn btn-success mr-1" id="weekly">Weekly</button>
                    <button type="button" class="btn btn-warning mr-1" id="monthly">Monthly</button>
                    <button type="button" class="btn btn-info" id="yearly">Yearly</button>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-chart-bar mr-1 text-primary"></i>
                            <span class="sales-report-title">Total Sales Report</span>
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="chart tab-pane active" id="revenue-chart" style="position: relative; height: 300px;">
                            <canvas id="revenue-chart-canvas" height="300" style="height: 300px;"></canvas>                         
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.row (main row) -->
    </div>
</section>
<!-- /.content -->
@endsection

@section('extra-scripts')
<script src="{{ asset('plugins/chart.js/Chart.min.js') }}"></script>
<script type="text/javascript">

const salesFilterURL = {!! json_encode(route('admin.total-sales-report.filter')) !!};
const salesChartCanvas = document.getElementById('revenue-chart-canvas').getContext('2d');
var salesChart;
var dynamicColors = function() 
{
    var r = Math.floor(Math.random() * 255);
    var g = Math.floor(Math.random() * 255);
    var b = Math.floor(Math.random() * 255);
    return "rgb(" + r + "," + g + "," + b + ")";
};

function renderSalesReportChart(type)
{   
    $.ajax({
        type: "POST",
        url: salesFilterURL,
        data: { type: type },
        dataType: "JSON",
        success: function (res) 
        {
            let dates = [];
            let sales = [];
            let colors = [];

            for (const i in res) {
                dates.push(res[i].date);
                sales.push(res[i].sale)
                colors.push(dynamicColors());
            }

            const salesChartData = {
                labels  : dates,
                datasets: [
                    {
                        backgroundColor: colors,
                        pointRadius         : false,
                        pointColor          : '#3b8bba',
                        pointStrokeColor    : 'rgba(60,141,188,1)',
                        pointHighlightFill  : '#fff',
                        pointHighlightStroke: 'rgba(60,141,188,1)',
                        data                : sales
                    }
                ]
            }

            const salesChartOptions = {
                maintainAspectRatio : false,
                responsive : true,
                legend: {
                    display: false
                },
                scales: {
                    xAxes: [],
                    yAxes: [{
                        ticks: {
                            beginAtZero:true,
                        }
                    }]
                }
            }

            salesChart = new Chart(salesChartCanvas, { 
                type: 'bar', 
                data: salesChartData, 
                options: salesChartOptions
            });
        }
    });
}

$(document).ready(function () {
    renderSalesReportChart("monthly");
});

$("#daily").click(function () { 
    $(".sales-report-title").text("Daily Sales Report");
    salesChart.destroy();
    renderSalesReportChart("daily");
});

$("#weekly").click(function () { 
    $(".sales-report-title").text("Weekly Sales Report");
    salesChart.destroy();
    renderSalesReportChart("weekly");
});

$("#monthly").click(function () { 
    $(".sales-report-title").text("Monthly Sales Report");
    salesChart.destroy();
    renderSalesReportChart("monthly");
});

$("#yearly").click(function () { 
    $(".sales-report-title").text("Yearly Sales Report");
    salesChart.destroy();
    renderSalesReportChart("yearly");
});
</script>
@endsection