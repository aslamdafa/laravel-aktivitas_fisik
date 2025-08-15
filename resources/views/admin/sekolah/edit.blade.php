@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Edit Sekolah</h2>

    <form action="{{ route('admin.sekolah.update', $sekolah->id) }}" method="POST">
        @csrf @method('PUT')
        <div class="form-group">
            <label>Nama Sekolah</label>
            <input type="text" name="nama" value="{{ $sekolah->nama }}" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Alamat</label>
            <textarea name="alamat" class="form-control" required>{{ $sekolah->alamat }}</textarea>
        </div>
        <button type="submit" class="btn btn-success">Update</button>
    </form>
</div>
@endsection
