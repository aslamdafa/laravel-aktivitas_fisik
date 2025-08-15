@extends('layouts.app')

@section('content')
<div class="container">
    {{-- Header --}}
    <div class="mb-4">
        <h4>Selamat datang 👋</h4>
        <p>Berikut adalah daftar siswa yang Anda bimbing.</p>
    </div>

    <h2 class="mb-4">Monitoring & Kelola Orang Tua Siswa</h2>

    {{-- Jika tidak ada siswa --}}
    @if($siswaList->isEmpty())
        <div class="alert alert-info">
            Tidak ada siswa yang terdaftar di sekolah Anda.
        </div>
    @else
        @foreach($siswaList as $siswa)
            <div class="card mb-3 shadow-sm">
                {{-- Header Card --}}
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <strong>{{ $siswa->nama }}</strong> 
                        <span class="text-muted">(Kelas: {{ $siswa->kelas ?? '-' }})</span>
                        <br>
                        <small class="text-muted">
                            {{ $siswa->sekolah->nama_sekolah ?? 'Sekolah tidak tersedia' }}
                        </small>
                    </div>
                    <div class="btn-group">
                        <a href="{{ route('guru.laporan-siswa', ['id' => $siswa->id]) }}" 
                           class="btn btn-outline-primary btn-sm">
                            📄 Laporan Siswa
                        </a>
                        <a href="{{ route('guru.export.siswa', $siswa->id) }}" 
                           class="btn btn-success btn-sm">
                            ⬇️ Export Excel
                        </a>
                    </div>
                </div>

                {{-- Body Card --}}
                <div class="card-body">
                    {{-- Daftar Orang Tua --}}
                    <h6>Daftar Orang Tua</h6>
                    @if($siswa->orangTua && $siswa->orangTua->count() > 0)
                        <ul class="list-group mb-3">
                            @foreach($siswa->orangTua as $ot)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        {{ optional($ot->user)->name ?? 'Nama tidak tersedia' }}
                                        <br>
                                        <small class="text-muted">
                                            {{ optional($ot->user)->email ?? 'Email tidak tersedia' }}
                                        </small>
                                    </div>
                                    <form action="{{ route('orangtua.destroy', $ot->id) }}" 
                                          method="POST" 
                                          onsubmit="return confirm('Hapus orang tua ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                    </form>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-muted">Belum ada orang tua yang ditautkan.</p>
                    @endif

                    {{-- Form Tambah Orang Tua --}}
                    <h6>Tambah Orang Tua</h6>
                    <form action="{{ route('orangtua.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="siswa_id" value="{{ $siswa->id }}">
                        <div class="form-group">
                            <select name="user_id" class="form-control" required>
                            <option value="">-- Pilih Orang Tua --</option>
                            @if($orangTuaUsers->isEmpty())
                                <option disabled>Tidak ada orang tua tersedia</option>
                            @else
                                @foreach($orangTuaUsers as $user)
                                    <option value="{{ $user->id }}">
                                        {{ $user->name }} ({{ $user->email }})
                                    </option>
                                @endforeach
                            @endif
                        </select>
                        </div>
                        <button type="submit" class="btn btn-primary btn-sm mt-2">Tambah Orang Tua</button>
                    </form>
                </div>
            </div>
        @endforeach
    @endif
</div>
@endsection
