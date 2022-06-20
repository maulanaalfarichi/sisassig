@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>@yield('title')</h1>
@stop

@section('content')
    <div class="panel panel-default welcome-panel">
        <div class="panel-body">
        	<div class="logo">
        		<img src="{{ asset('img/logo.png') }}" alt="">
        	</div>
            <p>Selamat Datang</p>
            <p class="name">{{ auth()->user()->name }}</p>
        </div>
    </div>
@stop
