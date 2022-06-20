@extends('adminlte::page')

@section('title', 'Surat Tugas')

@section('js')
    <script>
        function printData() {
            window.frames['printf'].focus();
            window.frames['printf'].print();
        }
    </script>
@stop

@section('content_header')
    <h1>@yield('title')</h1>
@stop

@section('content')
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
                    <a href="{{ url('admin/assignment/' . $id) }}" class="btn btn-default btn-flat">Kembali</a>
                </div>
                <!-- /.box-footer-->
            </div>
            <!-- /.box -->
        </div>
        <div class="col-md-9">
            <!-- Default box -->
            <div class="box">
                <form action="">
                    <div class="box-body">
                        <iframe src="{{ url('admin/assignment/letter/' . $id . '/print/') }}" frameborder="0" class="print-iframe" id="printf" name="printf"></iframe>
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer">
                        <a onclick="printData()" class="btn btn-success btn-flat">Cetak</a>
                    </div>
                    <!-- /.box-footer-->
                </form>
            </div>
            <!-- /.box -->
        </div>
    </div>
@stop
