@section('css')
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css">
@stop

@section('js')
    <script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>
    <script>
        $('.datetimepicker1').datetimepicker({
            format: 'YYYY-MM-DD HH:mm',
            showTodayButton: true
        });
        $('.datetimepicker2').datetimepicker({
            format: 'YYYY-MM-DD HH:mm',
            showTodayButton: true,
            useCurrent: false
        });
        $('.datetimepicker1').on('dp.change', function (e) {
            $('.datetimepicker2').data('DateTimePicker').minDate(e.date);
        });
        $('.datetimepicker2').on('dp.change', function (e) {
            $('.datetimepicker1').data('DateTimePicker').maxDate(e.date);
        });
    </script>
@stop

@php ($id = ($action == 'edit') ? $assignment->id : '')

<form action="{{ url('admin/assignment/' . $id) }}" method="POST">
    <div class="box-body">
        {{ csrf_field() }}
        @if($action == 'edit')
            {{ method_field('PUT') }}
        @endif
        <div class="form-group">
            <label>{{ $assignment->attributes('name') }}</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $assignment->name) }}">
        </div>

        <div class="form-group">
            <label>{{ $assignment->attributes('start_datetime') }}</label>
            <input type="text" name="start_datetime" class="form-control datetimepicker1" value="{{ old('start_datetime', $assignment->start_datetime) }}" autocomplete="off">
        </div>

        <div class="form-group">
            <label>{{ $assignment->attributes('end_datetime') }}</label>
            <input type="text" name="end_datetime" class="form-control datetimepicker2" value="{{ old('end_datetime', $assignment->end_datetime) }}" autocomplete="off">
        </div>

        <div class="form-group">
            <label>{{ $assignment->attributes('location') }}</label>
            <input type="text" name="location" class="form-control" value="{{ old('location', $assignment->location) }}">
        </div>
    </div>
    <!-- /.box-body -->
    <div class="box-footer">
        <a href="{{ url('admin/assignment') }}" class="btn btn-default btn-flat">Kembali</a>
        <button type="submit" class="btn btn-primary btn-flat">Simpan</button>
    </div>
    <!-- /.box-footer-->
</form>