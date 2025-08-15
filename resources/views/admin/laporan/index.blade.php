@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Daftar Semua Laporan</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form method="GET" action="{{ route('admin.laporan.index') }}" class="form-inline mb-3">
        <label for="siswa_id" class="mr-2">Filter berdasarkan siswa:</label>
        <select name="siswa_id" id="siswa_id" class="form-control mr-2">
            <option value="">-- Semua Siswa --</option>
            @foreach ($siswas as $siswa)
                <option value="{{ $siswa->id }}" {{ request('siswa_id') == $siswa->id ? 'selected' : '' }}>
                    {{ $siswa->nama }}
                </option>
            @endforeach
        </select>
        <button type="submit" class="btn btn-secondary">Tampilkan</button>
    </form>

    <table class="table table-bordered mt-3">
        <thead>
            <tr>
                <th>Nama Siswa</th>
                <th>Tanggal</th>
                <th>Aktivitas</th>
                <th>Intensitas</th>
                <th>Durasi</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($laporans as $laporan)
            <tr>
                <td>{{ $laporan->siswa->nama ?? '-' }}</td>
                <td>{{ $laporan->tanggal }}</td>
                <td>{{ $laporan->aktivitas }}</td>
                <td>{{ $laporan->intensitas }}</td>
                <td>{{ $laporan->menit }} menit</td>
                <td>
                    <a href="{{ route('admin.laporan.edit', $laporan->id) }}" class="btn btn-sm btn-primary">Edit</a>
                    <form action="{{ route('admin.laporan.destroy', $laporan->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Hapus laporan ini?')">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{ $laporans->links() }}
</div>
@endsection