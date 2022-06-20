@extends('adminlte::page')

@section('title', 'Lihat Role')

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
            <h3 class="box-title">Detail</h3>
        </div>
        <div class="box-body">
            <table class="table table-bordered table-striped">
                <tr>
                    <td>{{ $role->attributes('name') }}</td>
                    <td>{{ $role->name }}</td>
                </tr>
                <tr>
                    <td>{{ $role->attributes('permissions') }}</td>
                    <td>
                        <ul>
                            @foreach ($role->permissions as $permission)
                                <li>{{ $permission->name }}</li>
                            @endforeach
                        </ul>
                    </td>
                </tr>
            </table>
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
            <a href="{{ url('admin/role') }}" class="btn btn-default btn-flat">Kembali</a>
        </div>
        <!-- /.box-footer-->
    </div>
    <!-- /.box -->
@stop
