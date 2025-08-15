@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Edit Laporan</h3>

    <form action="{{ route('admin.laporan.update', $laporan->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label>Tanggal</label>
            <input type="date" name="tanggal" class="form-control" value="{{ $laporan->tanggal }}" required>
        </div>

        <div class="form-group">
            <label>Aktivitas</label>
            <input type="text" name="aktivitas" class="form-control" value="{{ $laporan->aktivitas }}" required>
        </div>

        <div class="form-group">
            <label>Intensitas</label>
            <select name="intensitas" class="form-control" required>
                <option value="sedang" {{ $laporan->intensitas == 'sedang' ? 'selected' : '' }}>Ringan</option>
                <option value="berat" {{ $laporan->intensitas == 'berat' ? 'selected' : '' }}>Berat</option>
            </select>
        </div>

        <div class="form-group">
            <label>Durasi (menit)</label>
            <input type="number" name="menit" class="form-control" value="{{ $laporan->menit }}" required>
        </div>

        <button type="submit" class="btn btn-success">Simpan Perubahan</button>
    </form>
</div>
@endsection
