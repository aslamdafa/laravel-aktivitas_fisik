@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="text-primary">📋 Daftar Akun Pengguna</h2>
    </div>

    @if($siswa->isEmpty())
        <div class="alert alert-info">
            Belum ada pengguna yang terdaftar.
        </div>
    @else
        <div class="card shadow-sm">
            <div class="card-body p-0">
                <table class="table table-hover table-bordered mb-0">
                <thead class="table-light">
                    <tr>
                        <th>👤 Nama Siswa</th>
                        <th>🏫 Kelas</th>
                        <th class="text-center">📄 Lihat Laporan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($siswa as $s)
                    <tr>
                        <td>{{ $s->nama }}</td>
                        <td>{{ $s->kelas }}</td>
                        <td class="text-center">
                            <a href="{{ route('guru.laporan-siswa', ['id' => $s->id]) }}" class="btn btn-sm btn-outline-primary">
                                Lihat Laporan
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            </div>
        </div>
    @endif
</div>
@endsection
