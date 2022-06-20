@extends('adminlte::page')

@section('title', 'Log Aktivitas')

@section('js')
    <script>
        var table = $('#activity-table').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            ajax: '{{ url('admin/activity-log/api') }}',
            columns: [
                {data: 'DT_Row_Index', name: 'DT_Row_Index'},
                {data: 'description', name: 'description'},
                {data: 'subject_type', name: 'subject_type'},
                {data: 'subject_id', name: 'subject_id'},
                {data: 'causer_id', name: 'causer_id'},
                {data: 'created_at', name: 'created_at'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });
        new $.fn.dataTable.FixedHeader(table);
    </script>
@stop

@section('content_header')
    <h1>@yield('title')</h1>
@stop

@section('content')
    <div class="response">
        @if (session()->has('success'))
            <div class="alert alert-success">
                <p>{!! session('success') !!}</p>
            </div>
        @endif
    </div>

    <!-- Default box -->
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">List</h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool btn-default btn-flat" onclick="refreshData()">
                    <i class="fa fa-refresh"></i> Refresh data
                </button>
            </div>
        </div>
        <div class="box-body">
            <table class="table table-bordered table-striped" id="activity-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Deskripsi</th>
                        <th>Model</th>
                        <th>Subjek</th>
                        <th>User</th>
                        <th>Tanggal</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
        <!-- /.box-body -->
    </div>
    <!-- /.box -->
@stop
