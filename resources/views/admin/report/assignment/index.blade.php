@extends('adminlte::page')

@section('title', 'Laporan Penugasan')

@section('css')
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css">
@stop

@section('js')
    <script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>
    <script>
        $('.datetimepicker1').datetimepicker({
            format: 'YYYY-MM-DD',
            showTodayButton: true
        });
        $('.datetimepicker2').datetimepicker({
            format: 'YYYY-MM-DD',
            showTodayButton: true,
            useCurrent: false
        });
        $('.datetimepicker1').on('dp.change', function (e) {
            $('.datetimepicker2').data('DateTimePicker').minDate(e.date);
        });
        $('.datetimepicker2').on('dp.change', function (e) {
            $('.datetimepicker1').data('DateTimePicker').maxDate(e.date);
        });

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
                <form action="">
                    <div class="box-header with-border">
                        <h3 class="box-title">Filter</h3>
                    </div>
                    <div class="box-body">
                        <div class="form-group">
                            <label>Dari tanggal</label>
                            <input type="text" name="start" class="form-control datetimepicker1" value="{{ $start }}" autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label>Sampai tanggal</label>
                            <input type="text" name="end" class="form-control datetimepicker2" value="{{ $end }}" autocomplete="off">
                        </div>
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary btn-flat">Cari</a>
                    </div>
                    <!-- /.box-footer-->
                </form>
            </div>
            <!-- /.box -->
        </div>

        @if (!empty($start) && !empty($end))
            <div class="col-md-9">
                <!-- Default box -->
                <div class="box">
                    <form action="">
                        <div class="box-body">
                            <iframe src="{{ url('admin/report/assignment/print?start=' . $start . '&end=' . $end) }}" frameborder="0" class="print-iframe" id="printf" name="printf"></iframe>
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
        @endif
    </div>
@stop
