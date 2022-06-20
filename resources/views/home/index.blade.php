@extends('layouts.frontend')

@section('title', 'Beranda')

@section('content')
    <h1><b>Daftar</b>Kegiatan</h1>

    @foreach ($assignments as $assignment)
        <div class="row assignment-item">
            <div class="col-md-1">
                <img src="{{ asset('img/logo-sm.png') }}" alt="" class="img-responsive">
            </div>
            <div class="col-md-11">
                <h3>{{ $assignment->name }}</h3>
                <p>
                    di {{ $assignment->location }}
                    pada {{ DateHelper::id_datetime($assignment->start_datetime) }} -
                    {{ DateHelper::id_datetime($assignment->end_datetime) }}
                </p>
                <a href="{{ url('assignment/' . $assignment->id) }}" class="btn btn-primary">Lihat Detail <i class="glyphicon glyphicon-chevron-right"></i></a>
            </div>
        </div>
        {!! (!$loop->last) ? '<hr>' : '' !!}
    @endforeach

    {{ $assignments->links() }}
@stop
