@extends('adminlte::page')

@section('title', 'Lihat Log Aktivitas')

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
                    <td>Nama Log</td>
                    <td>{{ $activity->log_name }}</td>
                </tr>
                <tr>
                    <td>Deskripsi</td>
                    <td>{{ $activity->description }}</td>
                </tr>
                <tr>
                    <td>Model</td>
                    <td>{{ $activity->subject_type }}</td>
                </tr>
                <tr>
                    <td>Subjek</td>
                    <td>{{ $activity->subject->id }} - {{ $activity->subject->name }}</td>
                </tr>
                <tr>
                    <td>User</td>
                    <td>{{ $activity->causer->name }} ({{ $activity->causer->email }})</td>
                </tr>
                <tr>
                    <td>Properti Lama</td>
                    <td>
                        <table class="table table-bordered">
                            @foreach ($activity->changes()['old'] as $key => $old)
                                <tr>
                                    <td>{{ $key }}</td>
                                    <td>{{ $old }}</td>
                                </tr>
                            @endforeach
                        </table>
                    </td>
                </tr>
                <tr>
                    <td>Properti Baru</td>
                    <td>
                        <table class="table table-bordered">
                            @foreach ($activity->changes()['attributes'] as $key => $new)
                                <tr>
                                    <td>{{ $key }}</td>
                                    <td>{{ $new }}</td>
                                </tr>
                            @endforeach
                        </table>
                    </td>
                </tr>
                <tr>
                    <td>Tanggal</td>
                    <td>{{ DateHelper::id_datetime($activity->created_at) }}</td>
                </tr>
            </table>
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
            <a href="{{ url('admin/activity-log') }}" class="btn btn-default btn-flat">Kembali</a>
        </div>
        <!-- /.box-footer-->
    </div>
    <!-- /.box -->
@stop
