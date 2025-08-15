@extends('layouts.app')

@section('content')
<style>
    body {
        background-color: #f8f9fa;
    }
    .sidebar {
        background: linear-gradient(to bottom, #0d6efd, #3b82f6);
        color: white;
        min-height: 100vh;
        padding: 30px 20px;
    }
    .sidebar h5 {
        font-weight: bold;
        margin-bottom: 30px;
    }
    .sidebar a {
        color: white;
        display: flex;
        align-items: center;
        padding: 10px 10px;
        border-radius: 10px;
        margin-bottom: 10px;
        transition: background 0.3s;
        text-decoration: none;
        font-weight: 500;
    }
    .sidebar a i {
        margin-right: 10px;
    }
    .sidebar a:hover {
        background-color: rgba(255, 255, 255, 0.1);
    }
    .btn-logout {
        border: 1px solid white;
        color: white;
        background-color: transparent;
        width: 100%;
        margin-top: 30px;
        padding: 8px 16px;
        border-radius: 8px;
        text-align: center;
        display: block;
        text-decoration: none;
    }
    .btn-logout:hover {
        background-color: rgba(255, 255, 255, 0.1);
    }

    .bg-aktif {
        background-color: #d0f0ff !important;
    }
    .bg-menengah {
        background-color: #fff6d1 !important;
    }
    .bg-kurang {
        background-color: #ffdede !important;
    }
</style>

<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-2 sidebar">
            <h2> Menu Navigasi</h2>
            <a href="{{ url('/home') }}" class="nav-link"><i class="bi bi-house-door"></i>Home</a>
            <a href="{{ route('laporan.input') }}" class="nav-link"><i class="bi bi-pencil-square"></i>Input Laporan</a>
            <a href="{{ route('aktivitas.harian') }}" class="nav-link"><i class="bi bi-calendar-day"></i>Aktivitas Harian</a>
            <a href="{{ route('evaluasi') }}" class="nav-link"><i class="bi bi-bar-chart-line"></i>Laporan Mingguan</a>

            <!-- Tombol Logout -->
            <form action="{{ route('logout') }}" method="POST" class="logout-button">
                @csrf
                <button type="submit" class="btn btn-outline-light w-100">
                    <i class="bi bi-box-arrow-right"></i> Logout
                </button>
            </form>
        </div>

        <!-- Konten -->
        <div class="col-md-9 p-4">
            <h2 class="mb-4">Daftar Aktivitas Harian</h2>

            @if(session('status'))
                <div class="alert alert-success">{{ session('status') }}</div>
            @endif
                    @if(session('message'))
            <div class="alert alert-info">
                {{ session('message') }}
            </div>
        @endif
        @if (isset($laporans) && $laporans->isNotEmpty())
    <table> ... </table> 
        @else
            <div class="alert alert-info">
                Belum ada laporan yang dimasukkan.
            </div>
        @endif


            <table class="table table-bordered">
                <thead class="thead-dark">
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Intensitas</th>
                        <th>Jenis Aktivitas</th>
                        <th>Menit</th>
                        <th>Waktu</th>
                        <th>Motivasi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($laporans as $index => $laporan)
                        <tr class="
                            @if($laporan->menit >= 60)
                                bg-aktif
                            @elseif($laporan->menit >= 30)
                                bg-menengah
                            @else
                                bg-kurang
                            @endif
                        ">
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $laporan->tanggal }}</td>
                            <td>{{ ucfirst($laporan->intensitas) }}</td>
                            <td>{{ $laporan->aktivitas }}</td>
                            <td>{{ $laporan->menit }}</td>
                            <td>{{ $laporan->waktu }}</td>
                            <td>
                                @if ($laporan->menit >= 60)
                                    💪 Mantap! Kamu sangat aktif hari ini!
                                @elseif ($laporan->menit >= 30)
                                    🌟 Bagus! Tinggal sedikit lagi capai target!
                                @else
                                    🌱 Ayo semangat, kamu pasti bisa lebih aktif!
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>    
            </table>
        </div>
    </div>
</div>
@endsection
