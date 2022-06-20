@extends('layouts.frontend')

@section('title', 'Detail Kegiatan')

@section('content')
    <h1><b>Detail</b>Kegiatan</h1>

    <table class="table table-bordered table-striped">
        <tr>
            <td width="30%">{{ $assignment->attributes('name') }}</td>
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

    <h3>Partisipasi Anggota</h3>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Sebagai</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($assignment_users as $assignment_user)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $assignment_user->user->name }}</td>
                    <td>{{ $assignment_user->assignmentAs->name }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@stop
