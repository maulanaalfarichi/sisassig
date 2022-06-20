@section('css')
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css">
@stop

@section('js')
    <script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>
@stop

@php ($id = ($action == 'edit') ? $role->id : '')

<form action="{{ url('admin/role/' . $id) }}" method="POST">
    <div class="box-body">
        {{ csrf_field() }}
        @if ($action == 'edit')
            {{ method_field('PUT') }}
        @endif
        <div class="form-group">
            <label>{{ $role->attributes('name') }}</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $role->name) }}">
        </div>

        <div class="form-group">
            <label>{{ $role->attributes('permissions') }}</label>
            @foreach ($permissions as $permission)
                @if ($action == 'edit')
                    @php ($checked = in_array($permission->id, $role->permissions) ? 'checked' : '')
                @else
                    @php ($checked = '')
                @endif
                <div class="checkbox">
                    <label><input type="checkbox" name="permissions[]" id="permission-{{ $permission->id }}" value="{{ $permission->id }}" {{ $checked }}> {{ $permission->name }}</label>
                </div>
            @endforeach
        </div>
    </div>
    <div class="box-footer">
        <a href="{{ url('admin/role') }}" class="btn btn-default btn-flat">Kembali</a>
        <button type="submit" class="btn btn-primary btn-flat">Simpan</button>
    </div>
</form>