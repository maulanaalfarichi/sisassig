@extends('adminlte::page')

@section('title', 'Penugasan')

@section('js')
    <script>
        var table = $('#assignment-table').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            ajax: '{{ url('admin/my-assignment/api') }}',
            columns: [
                {data: 'DT_Row_Index', name: 'DT_Row_Index'},
                {data: 'assignment.name', name: 'assignment.name'},
                {data: 'assignment.start_datetime', name: 'assignment.start_datetime'},
                {data: 'assignment.end_datetime', name: 'assignment.end_datetime'},
                {data: 'assignment.location', name: 'assignment.location'},
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
                <button type="button" class="btn btn-box-tool btn-default btn-flat" onclick="helpers.refreshData()">
                    <i class="fa fa-refresh"></i> Refresh data
                </button>
            </div>
        </div>
        <div class="box-body">
            <table class="table table-bordered table-striped" id="assignment-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Kegiatan</th>
                        <th>Waktu Awal</th>
                        <th>Waktu Akhir</th>
                        <th>Lokasi</th>
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
