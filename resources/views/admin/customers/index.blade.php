@extends('admin.app')
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Customers</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Customers</li>
                </ol>
            </div>
        </div>
    </div>
</section>
<section class="content">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">List of Customers</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <table id="customersTable" class="table table-bordered table-striped">
                <thead>
                    <tr class="text-center">
                        <th>#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Address</th>
                        <th>Date Created</th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($customers  as $key => $customer)
                    <tr class="text-center">
                        <td>{{ $key+1 }}</td>
                        <td>{{ $customer->firstname.' '.$customer->lastname }}</td>
                        <td>{{ $customer->email }}</td>
                        <td>{{ Str::limit($customer->address, 20, ' ...') }}</td>
                        <td>{{ $customer->created_at->format('m-d-Y H:i') }}</td>
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
    $("#customersTable").DataTable({
        "responsive": true,
        "autoWidth": false,
    });
});
</script>
@endsection