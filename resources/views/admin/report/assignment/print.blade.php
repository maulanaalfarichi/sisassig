@extends('layouts.print')

@section('title', 'Cetak Penugasan')

@section('content')
    <div class="text-center">
        <h3>LAPORAN KEGIATAN RELAWAN TIK CABANG KOTA CIREBON</h3>
        <p>{{ DateHelper::id_date($start) }} - {{ DateHelper::id_date($end) }}</p>
    </div>

    <br>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="35%">Nama Kegiatan</th>
                <th width="15%">Waktu Awal</th>
                <th width="15%">Waktu Akhir</th>
                <th>Lokasi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($assignments as $assignment)
                <tr>
                    <td rowspan="2">{{ $loop->iteration }}</td>
                    <td>{{ $assignment->name }}</td>
                    <td>{{ DateHelper::id_datetime($assignment->start_datetime) }}</td>
                    <td>{{ DateHelper::id_datetime($assignment->end_datetime) }}</td>
                    <td>{{ $assignment->location }}</td>
                </tr>
                <tr>
                    <td colspan="4">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Sebagai</th>
                                    <th>Beban Kerja</th>
                                    <th>Status</th>
                                    <th>Info</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($assignment->assignmentUser as $user)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $user->user['name'] }}</td>
                                        <td>{{ $user->assignmentAs->name }}</td>
                                        <td>{{ $user->workload }}</td>
                                        <td>{{ $user->assignmentStatus->name }}</td>
                                        <td>{{ $user->info }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

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
