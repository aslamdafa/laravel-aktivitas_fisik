@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Laporan Mingguan</h3>

    <p><strong>Nama Anak:</strong> {{ $siswa->nama ?? 'Data siswa tidak ditemukan' }}</p>
    <p><strong>Periode:</strong> {{ $startDate->format('d M Y') }} - {{ $endDate->format('d M Y') }}</p>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Durasi (menit)</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($laporans as $laporan)
            <tr>
                <td>{{ \Carbon\Carbon::parse($laporan->tanggal)->format('d M Y') }}</td>
                <td>{{ $laporan->menit }}</td>
                <td>{{ $laporan->keterangan ?? '-' }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="3">Tidak ada laporan untuk periode ini.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <p><strong>Total Durasi Mingguan:</strong> {{ $totalMenit }} menit</p>
    <p><strong>Status:</strong> {{ $status }}</p>
</div>
@endsection
