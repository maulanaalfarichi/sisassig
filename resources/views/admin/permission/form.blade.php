@php ($id = ($action == 'edit') ? $permission->id : '')

<form action="{{ url('admin/permission/' . $id) }}" method="POST">
    <div class="box-body">
        {{ csrf_field() }}
        @if ($action == 'edit')
            {{ method_field('PUT') }}
        @endif
        <div class="form-group">
            <label>{{ $permission->attributes('name') }}</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $permission->name) }}">
        </div>
    </div>
    <div class="box-footer">
        <a href="{{ url('admin/permission') }}" class="btn btn-default btn-flat">Kembali</a>
        <button type="submit" class="btn btn-primary btn-flat">Simpan</button>
    </div>
</form>