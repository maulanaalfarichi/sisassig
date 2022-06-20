@extends('adminlte::page')

@section('title', 'Role')

@section('js')
    <script>
        var table = $('#role-table').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            ajax: '{{ url('admin/role/api') }}',
            columns: [
                {data: 'DT_Row_Index', name: 'DT_Row_Index'},
                {data: 'name', name: 'name'},
                {data: 'created_at', name: 'created_at'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });
        new $.fn.dataTable.FixedHeader(table);

        function deleteData(id) {
            $('.response').html('');
            deleteConfirm = confirm('Yakin menghapus data ini?');

            if (deleteConfirm) {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: '{{ url('admin/role') }}' + '/' + id,
                    type: 'POST',
                    data: {'_method': 'DELETE'},
                    success: function(data) {
                        table.ajax.reload();
                        response = 'Data berhasil dihapus.';

                        $('.response').html('<div class="alert alert-success"><b>' + response + '</b></div>');
                    },
                    error: function(xhr, status, err) {
                        obj = JSON.parse(xhr.responseText);
                        response = obj.message;
                        responseDetail = '<ul>';
                        $.each(obj.errors, function( k, v ) {
                            responseDetail = responseDetail + '<li>' + v.join(', ') + '</li>';
                        });
                        responseDetail = responseDetail + '</ul>';

                        $('.response').html('<div class="alert alert-danger"><b>' + response + '</b> ' + responseDetail+  '</div>');
                    }
                });
                return false;
            }
        }
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
            <table class="table table-bordered table-striped" id="role-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Tanggal Ditambah</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
            <a href="{{ url('admin/role/create') }}" class="btn btn-primary btn-flat"><i class="fa fa-plus"></i> Tambah</a>
        </div>
        <!-- /.box-footer-->
    </div>
    <!-- /.box -->
@stop
