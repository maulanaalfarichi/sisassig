@extends('adminlte::page')

@section('title', 'Lihat Penugasan')

@section('js')
    <script>
        var table = $('#assignment_user-table').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            ordering: false,
            searching: false,
            ajax: '{{ url('admin/assignment-user/api' . '/' . $assignment->id) }}',
            columns: [
                {data: 'DT_Row_Index', name: 'DT_Row_Index'},
                {data: 'user.name', name: 'user.name'},
                {data: 'assignment_as.name', name: 'assignment_as.name'},
                {data: 'assignment_status.name', name: 'assignment_status.name'},
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
    <div class="row">
        <div class="col-md-3">
            <!-- Default box -->
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Detail</h3>
                </div>
                <div class="box-body">
                    <table class="table table-bordered table-striped">
                        <tr>
                            <td width="40%">{{ $assignment->attributes('name') }}</td>
                            <td>{{ $assignment->name }}</td>
                        </tr>
                        <tr>
                            <td>{{ $assignment->attributes('start_datetime') }}</td>
                            <td>{{ DateHelper::id_datetime($assignment->start_datetime) }}</td>
                        </tr>
                        <tr>
                            <td>{{ $assignment->attributes('end_datetime') }}</td>
                            <td>{{ DateHelper::id_datetime($assignment->end_datetime) }}</td>
                        </tr>
                        <tr>
                            <td>{{ $assignment->attributes('location') }}</td>
                            <td>{{ $assignment->location }}</td>
                        </tr>
                    </table>
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <a href="{{ url('admin/my-assignment') }}" class="btn btn-default btn-flat">Kembali</a>
                </div>
                <!-- /.box-footer-->
            </div>
            <!-- /.box -->
        </div>
        <div class="col-md-9">
            <!-- Default box -->
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">List Anggota</h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool btn-default btn-flat" onclick="helpers.refreshData()">
                            <i class="fa fa-refresh"></i> Refresh data
                        </button>
                    </div>
                </div>
                <div class="box-body">
                    <table class="table table-bordered table-striped" id="assignment_user-table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Sebagai</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
    </div>
@stop
