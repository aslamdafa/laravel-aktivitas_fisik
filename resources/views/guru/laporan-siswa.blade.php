@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="mb-4">
        <h2 class="text-primary">Laporan Aktivitas: {{ $siswa->nama }}</h2>
        <p class="text-muted">Email: {{ $siswa->user->email ?? '-' }}</p>
        <a href="{{ route('guru.siswa') }}" class="btn btn-outline-secondary mt-2">← Kembali ke Daftar Pengguna</a>
    </div>

    {{-- Dropdown Filter Minggu --}}
    <form method="GET" class="mb-4">
        <label for="filterMinggu">Filter Minggu:</label>
        <select name="minggu" id="filterMinggu" class="form-control w-50 d-inline-block" onchange="this.form.submit()">
            <option value="">-- Semua Minggu --</option>
            @foreach($mingguList as $minggu)
    <option value="{{ $minggu }}" {{ $selectedMinggu == $minggu ? 'selected' : '' }}>
        {{ $minggu }}
    </option>
@endforeach
        </select>
    </form>

    {{-- Tombol Export --}}
    <a href="{{ route('guru.export.siswa', $siswa->id) }}" class="btn btn-success mb-3">📤 Export Excel</a>

    @if($laporanPerMinggu->isEmpty())
        <div class="alert alert-warning">
            Belum ada laporan aktivitas fisik untuk pengguna ini.
        </div>
    @else
        @foreach($laporanPerMinggu as $minggu => $laporans)
            <h5 class="mt-4">🗓️ {{ $minggu }}</h5>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Aktivitas</th>
                        <th>Durasi (menit)</th>
                    </tr>
                </thead>
                <tbody>
                    @php $totalDurasi = 0; @endphp
                    @foreach($laporans as $laporan)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($laporan->tanggal)->translatedFormat('d F Y') }}</td>
                            <td>{{ $laporan->aktivitas }}</td>
                            <td>{{ $laporan->menit }}</td>
                            @php $totalDurasi += $laporan->menit; @endphp
                        </tr>
                    @endforeach
                    <tr class="table-success font-weight-bold">
                    <td colspan="2" class="text-right">Total Durasi Minggu Ini:</td>
                    <td><strong>{{ $totalDurasi }} menit</strong></td>
                </tr>
                <tr class="{{ $totalDurasi >= 420 ? 'table-primary' : 'table-warning' }}">
                    <td colspan="3">
                        <strong>Status: {{ $totalDurasi >= 420 ? 'Aktif' : 'Kurang Aktif' }}</strong>
                    </td>
                </tr>
                </tbody>
            </table>
        @endforeach
    @endif
</div>
@endsection
