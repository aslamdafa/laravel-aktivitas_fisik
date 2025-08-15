@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Manajemen Sekolah</h2>

    <a href="{{ route('admin.sekolah.create') }}" class="btn btn-primary mb-3">+ Tambah Sekolah</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nama Sekolah</th>
                <th>Alamat</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($sekolahs as $sekolah)
                <tr>
                    <td>{{ $sekolah->nama_sekolah }}</td>
                    <td>{{ $sekolah->alamat }}</td>
                    <td>
                        <a href="{{ route('admin.sekolah.edit', $sekolah->id) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('admin.sekolah.destroy', $sekolah->id) }}" method="POST" style="display:inline;">
                            @csrf @method('DELETE')
                            <button onclick="return confirm('Hapus sekolah ini?')" class="btn btn-sm btn-danger">Hapus</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
