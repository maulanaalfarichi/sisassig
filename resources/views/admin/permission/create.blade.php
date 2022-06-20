@extends('adminlte::page')

@section('title', 'Buat Permission')

@section('content_header')
    <h1>@yield('title')</h1>
@stop

@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Whoops!</strong> There were some problems with your input.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Default box -->
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Form</h3>
        </div>

        @include('admin.permission.form', ['action' => 'create'])
    </div>
    <!-- /.box -->
@stop
