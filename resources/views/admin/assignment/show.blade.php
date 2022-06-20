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
                {data: 'workload', name: 'workload'},
                {data: 'assignment_status.name', name: 'assignment_status.name'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });
        new $.fn.dataTable.FixedHeader(table);

        $('.select2').select2({
            width: '100%'
        });
        $('.select2-name').select2({
            width: '100%',
            minimumInputLength: 3,
            ajax: {
                url: '{{ url('api/search/user') }}',
                dataType: 'json',
                processResults: function (data, page) {
                    var results = [];

                    $.each(data, function(index, item) {
                        results.push({
                            id: item.id,
                            text: item.name
                        });
                    });

                    return {
                        results: results
                    };
                },
            }
        });

        function showData(id) {
            $('#modal-show .modal-response').html('');

            $('#modal-show .modal-title').text('Lihat');
            $('#modal-show').modal('show');

            $.ajax({
                url: '{{ url('admin/assignment-user') }}' + '/' + id,
                type: 'GET',
                dataType: 'JSON',
                success: function(data) {
                    $('#modal-show #assignment_id').text(data.assignment_id);
                    $('#modal-show #user_id').text(data.user.name);
                    $('#modal-show #served_as').text(data.assignment_as.name);
                    $('#modal-show #workload').text(data.workload);
                    $('#modal-show #status_id').text(data.assignment_status.name);
                    $('#modal-show #info').text(data.info);
                },
                error: function(xhr, status, err) {
                    obj = JSON.parse(xhr.responseText);
                    response = obj.message;
                    responseDetail = '<ul>';
                    $.each(obj.errors, function( k, v ) {
                        responseDetail = responseDetail + '<li>' + v.join(', ') + '</li>';
                    });
                    responseDetail = responseDetail + '</ul>';

                    $('#modal-show .modal-response').html('<div class="alert alert-danger"><b>' + response + '</b> ' + responseDetail+  '</div>');
                }
            });
        }

        function createData() {
            saveMethod = 'create';

            $('#modal-form form')[0].reset();
            $("#modal-form select").val('').change();
            $('#modal-form .modal-response').html('');
            $('#modal-form #assignment_id').val({!! $assignment->id !!});

            $('#modal-form .modal-title').text('Tambah');
            $('#modal-form input[name=_method]').val('POST');
            $('#modal-form #password-help-block').text('');
            $('#modal-form #submit').text('Simpan');
            $('#modal-form').modal('show');
        }

        function editData(id) {
            saveMethod = 'edit';

            $('#modal-form form')[0].reset();
            $("#modal-form select").val('').change();
            $('#modal-form .modal-response').html('');

            $('#modal-form .modal-title').text('Edit');
            $('#modal-form input[name=_method]').val('PUT');
            $('#modal-form #submit').text('Update');
            $('#modal-form').modal('show');

            $.ajax({
                url: '{{ url('admin/assignment-user') }}' + '/' + id + '/edit',
                type: 'GET',
                dataType: 'JSON',
                success: function(data) {
                    $('#modal-form #id').val(data.id);
                    $('#modal-form #assignment_id').val(data.assignment_id);
                    $('#modal-form #user_id').val(data.user_id);
                    $('#modal-form #served_as').val(data.served_as).change();
                    $('#modal-form #workload').val(data.workload);
                    $('#modal-form #status_id').val(data.status_id).change();
                    $('#modal-form #info').val(data.info);

                    $.ajax({
                        url: '{{ url('api/user') }}' + '/' + data.user_id,
                        type: 'GET',
                        dataType: 'JSON',
                        success: function(data) {
                            $('#modal-form #user_id').html('');
                            $('#modal-form #user_id').append('<option value="' + data.id + '">' + data.name + '</option>');
                        }
                    });
                },
                error: function(xhr, status, err) {
                    obj = JSON.parse(xhr.responseText);
                    response = obj.message;
                    responseDetail = '<ul>';
                    $.each(obj.errors, function( k, v ) {
                        responseDetail = responseDetail + '<li>' + v.join(', ') + '</li>';
                    });
                    responseDetail = responseDetail + '</ul>';

                    $('#modal-form .modal-response').html('<div class="alert alert-danger"><b>' + response + '</b> ' + responseDetail+  '</div>');
                }
            });
        }

        function deleteData(id) {
            $('.response').html('');
            deleteConfirm = confirm('Yakin menghapus data ini?');

            if (deleteConfirm) {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: '{{ url('admin/assignment-user') }}' + '/' + id,
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

        $('#modal-form form').on('submit', function(e) {
            e.preventDefault();

            $('#modal-form .modal-response').html('');
            id = $('#modal-form #id').val();

            if (saveMethod == 'create') {
                url = '{{ url('admin/assignment-user') }}';
                buttonName = 'simpan';
                successResponse = 'Anda dapat menutup window ini atau menambah data baru.';
            } else {
                url = '{{ url('admin/assignment-user') }}' + '/' + id;
                buttonName = 'update';
                successResponse = 'Anda dapat menutup window ini atau mengedit data lagi.';
            }

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: url,
                type: 'POST',
                data: new FormData($('#modal-form form')[0]),
                contentType: false,
                processData: false,
                success: function(data) {
                    if (saveMethod == 'create') {
                        $('#modal-form form')[0].reset();
                        $("#modal-form select").val('').change();
                    }
                    table.ajax.reload();
                    response = 'Data berhasil di' + buttonName + '.';
                    responseDetail = successResponse;

                    $('#modal-form .modal-response').html('<div class="alert alert-success"><b>' + response + '</b> ' + responseDetail+  '</div>');
                },
                error: function(xhr, status, err) {
                    obj = JSON.parse(xhr.responseText);
                    response = obj.message;
                    responseDetail = '<ul>';
                    $.each(obj.errors, function( k, v ) {
                        responseDetail = responseDetail + '<li>' + v.join(', ') + '</li>';
                    });
                    responseDetail = responseDetail + '</ul>';

                    $('#modal-form .modal-response').html('<div class="alert alert-danger"><b>' + response + '</b> ' + responseDetail+  '</div>');
                }
            });
            $('.modal').animate({
                scrollTop: 0
            }, 500);
            return false;
        });
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
                    <a href="{{ url('admin/assignment') }}" class="btn btn-default btn-flat">Kembali</a>
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
                                <th>Beban Kerja</th>
                                <th>Status</th>
                                <th width="20%"></th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <a onclick="createData()" class="btn btn-primary btn-flat"><i class="fa fa-plus"></i> Tambah</a>
                    <a href="{{ url('admin/assignment/letter/' . $assignment->id) }}" class="btn btn-success btn-flat">Surat Tugas</a>
                </div>
                <!-- /.box-footer-->
            </div>
            <!-- /.box -->
        </div>
    </div>
    @include('admin.assignment-user.form')
    @include('admin.assignment-user.show')
@stop
