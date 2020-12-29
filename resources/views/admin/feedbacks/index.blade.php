@extends('admin.app')
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Feedbacks</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Feedbacks</li>
                </ol>
            </div>
        </div>
    </div>
</section>
<section class="content">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">List of Feedbacks</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <table id="feedbacksTable" class="table table-bordered table-striped">
                <thead>
                    <tr class="text-center">
                        <th>#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Message</th>
                        <th>Date Sent</th>
                        <th>View</th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($feedbacks  as $key => $feedback)
                    <tr class="text-center">
                        <td>{{ $key+1 }}</td>
                        <td>{{ $feedback->name }}</td>
                        <td>{{ $feedback->email }}</td>
                        <td>{{ Str::limit($feedback->message, 20, ' ...') }}</td>
                        <td>{{ $feedback->created_at->format('m-d-Y H:i') }}</td>
                        <td>
                            <a href="{{ route('admin.feedbacks.show',$feedback->id) }}" class="btn btn-sm btn-success" title="View Feedback"><i class="fas fa-eye"></i></a>
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
    $("#feedbacksTable").DataTable({
        "responsive": true,
        "autoWidth": false,
    });
});
</script>
@endsection