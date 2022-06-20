@extends('adminlte::page')

@section('title', 'Lihat User')

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
                    <h3 class="box-title">{{ $user->attributes('photo') }}</h3>
                </div>
                <div class="box-body">
                    <img src="{{ url('img/' . $user->photo) }}" id="photo" class="img-responsive">
                </div>
                <div class="box-footer">
                    <a href="{{ url('admin/user') }}" class="btn btn-default btn-flat">Kembali</a>
                </div>
                <!-- /.box-footer-->
            </div>
        </div>
        <div class="col-md-9">
            <!-- Default box -->
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Detail</h3>
                </div>
                <div class="box-body">
                    <table class="table table-bordered table-striped">
                        <tr>
                            <td>{{ $user->attributes('name') }}</td>
                            <td>{{ $user->name }}</td>
                        </tr>
                        <tr>
                            <td>{{ $user->attributes('email') }}</td>
                            <td>{{ $user->email }}</td>
                        </tr>
                        <tr>
                            <td>{{ $user->attributes('roles') }}</td>
                            <td>{{ $user->roles }}</td>
                        </tr>
                        <tr>
                            <td>{{ $user->attributes('birth_place') }}</td>
                            <td>{{ $user->birthplace->name }}</td>
                        </tr>
                        <tr>
                            <td>{{ $user->attributes('birth_date') }}</td>
                            <td>{{ $user->birth_date }}</td>
                        </tr>
                        <tr>
                            <td>{{ $user->attributes('age') }}</td>
                            <td>{{ $user->age }}</td>
                        </tr>
                        <tr>
                            <td>{{ $user->attributes('bio') }}</td>
                            <td>{{ $user->bio }}</td>
                        </tr>
                        <tr>
                            <td>{{ $user->attributes('province_id') }}</td>
                            <td>{{ $user->province->name }}</td>
                        </tr>
                        <tr>
                            <td>{{ $user->attributes('regency_id') }}</td>
                            <td>{{ $user->regency->name }}</td>
                        </tr>
                        <tr>
                            <td>{{ $user->attributes('district_id') }}</td>
                            <td>{{ $user->district->name }}</td>
                        </tr>
                        <tr>
                            <td>{{ $user->attributes('village_id') }}</td>
                            <td>{{ $user->village->name }}</td>
                        </tr>
                        <tr>
                            <td>{{ $user->attributes('address') }}</td>
                            <td>{{ $user->address }}</td>
                        </tr>
                        <tr>
                            <td>{{ $user->attributes('expertise') }}</td>
                            <td>{{ $user->expertise }}</td>
                        </tr>
                        <tr>
                            <td>{{ $user->attributes('active') }}</td>
                            <td>{{ $user->active }}</td>
                        </tr>
                    </table>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
    </div>
@stop
