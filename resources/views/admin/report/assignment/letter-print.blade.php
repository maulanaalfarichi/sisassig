@extends('layouts.print')

@section('title', 'Cetak Surat Tugas')

@section('content')
    <div class="text-center">
        <h3>SURAT TUGAS</h3>
    </div>

    <br>

    <p>Sehubungan dengan adanya <b>{{ $assignment->name }}</b> yang dilaksanakan di <b>{{ $assignment->location }}</b> pada tanggal {{ DateHelper::id_datetime($assignment->start_datetime) }} sampai dengan {{ DateHelper::id_datetime($assignment->end_datetime) }}. Maka dengan ini Bidang SDM dan Kemitraan menugaskan kepada :</p>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Sebagai</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($assignment->assignmentUser as $user)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $user->user['name'] }}</td>
                    <td>{{ $user->assignmentAs->name }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <p>Untuk dapat mengikuti <b>{{ $assignment->name }}</b> dan memberikan laporan atas kegiatan tersebut.</p>
    <p>Demikian surat tugas ini diberikan untuk dilaksanakan dengan penuh tanggung jawab.</p>

    <br><br><br>

    <table class="print-sign">
        <tr>
            <td width="75%"></td>
            <td class="text-center">
                Cirebon, {{ DateHelper::id_date(date('Y-m-d')) }}<br>
                Kabid SDM dan Kemitraan<br>
                <br>
                <br>
                <br>
                <u>Asep Sunandar</u>
            </td>
        </tr>
    </table>
@stop
