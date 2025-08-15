@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Tambah Sekolah</h2>

    <form action="{{ route('admin.sekolah.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label>Nama Sekolah</label>
            <input type="text" name="nama" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Alamat</label>
            <textarea name="alamat" class="form-control" required></textarea>
        </div>
        <button type="submit" class="btn btn-success">Simpan</button>
    </form>
</div>
@endsection
