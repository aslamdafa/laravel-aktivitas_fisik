@extends('layouts.app')

@section('content')
@push('styles')
<style>
/* CSS yang sudah ada */
/* ... */
.container {
    max-width: 900px;
    margin: 20px auto;
    padding: 32px;
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 4px 16px rgba(59, 130, 246, 0.2);
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

h1 {
    color: #1e3a8a;
    margin-bottom: 12px;
}

.subtitle {
    color: #3b82f6;
    margin-bottom: 24px;
    font-weight: 600;
}

form {
    display: flex;
    align-items: flex-end;
    gap: 12px;
    margin-bottom: 32px;
}

label {
    font-weight: 600;
    color: #1e3a8a;
}

input[type="date"] {
    padding: 10px 14px;
    border-radius: 8px;
    border: 1px solid #94a3b8;
    font-size: 16px;
    outline-offset: 2px;
    outline-color: #3b82f6;
    transition: border-color 0.2s;
}

input[type="date"]:focus {
    border-color: #2563eb;
    outline-color: #2563eb;
}

button {
    background-color: #2563eb;
    border: none;
    padding: 12px 24px;
    border-radius: 12px;
    color: white;
    font-weight: 700;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

button:hover {
    background-color: #1e40af;
}

table {
    width: 100%;
    border-collapse: collapse;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 4px 12px rgba(59, 130, 246, 0.15);
    margin-top: 24px; /* Tambahkan margin agar ada jarak */
}

thead {
    background-color: #3b82f6;
    color: white;
}

th, td {
    padding: 16px 20px;
    font-size: 16px;
    border-bottom: 1px solid #e0e7ff;
    text-align: left;
}

tbody tr:hover {
    background-color: #e0e7ff;
}

.status-biru {
    background-color: #1e3a8a;
    color: white;
    padding: 6px 14px;
    border-radius: 8px;
    font-weight: 600;
    display: inline-block;
    font-size: 14px;
}

.status-merah {
    background-color: #dc2626;
    color: white;
    padding: 6px 14px;
    border-radius: 8px;
    font-weight: 600;
    display: inline-block;
    font-size: 14px;
}

/* Styling intensitas badge */
.intensity-badge {
    padding: 4px 10px;
    border-radius: 12px;
    color: white;
    font-weight: 600;
    font-size: 14px;
    display: inline-flex;
    align-items: center;
    gap: 6px;
}

.intensity-dot {
    width: 10px;
    height: 10px;
    border-radius: 50%;
    display: inline-block;
}

/* Warna intensitas */
.intensity-ringan {
    background-color: #60a5fa; /* biru muda */
}
.dot-ringan {
    background-color: #3b82f6; /* biru */
}

.intensity-sedang {
    background-color: #facc15; /* kuning */
}
.dot-sedang {
    background-color: #ca8a04; /* kuning tua */
}

.intensity-berat {
    background-color: #ef4444; /* merah */
}
.dot-berat {
    background-color: #b91c1c; /* merah gelap */
}
</style>
@endpush

<div class="container">
    <h1>Laporan Aktivitas {{ $namaAnak }}</h1>
    <p class="subtitle">Pantau progress aktivitas fisik anak Anda</p>

    <form method="GET" action="{{ route('orangtua.evaluasi') }}">
        <div>
            <label for="start_date">Pilih tanggal awal periode (7 hari)</label>
            <input 
                type="date" 
                id="start_date" 
                name="start_date" 
                value="{{ request('start_date', \Carbon\Carbon::now()->toDateString()) }}">
        </div>
        <button type="submit">Tampilkan</button>
    </form>
    
    @if($laporans->isEmpty() && request('start_date'))
        {{-- Kondisi jika tidak ada laporan untuk rentang yang dipilih --}}
        <p>Tidak ada laporan aktivitas untuk periode {{ $startDate->format('d M Y') }} - {{ $endDate->format('d M Y') }}.</p>
    @else
        {{-- Tampilkan ringkasan dan tabel jika ada data --}}
        <h3 class="mt-4">Periode: {{ $startDate->format('d M Y') }} - {{ $endDate->format('d M Y') }}</h3>
        <p>Status Aktivitas: 
            {{-- Tampilkan status berdasarkan total durasi --}}
            @if($status == 'Aktif')
                <span class="status-biru">Aktif</span>
            @else
                <span class="status-merah">Kurang Aktif</span>
            @endif
        </p>

        <table>
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Aktivitas</th>
                    <th>Durasi (menit)</th>
                    <th>Intensitas</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($laporans as $item)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}</td>
                    <td>{{ $item->aktivitas }}</td>
                    <td>{{ $item->menit }}</td>
                    <td>{{ $item->intensitas }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="4">Tidak ada aktivitas yang dilaporkan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    @endif
</div>
@endsection