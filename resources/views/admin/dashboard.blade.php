@extends('layouts.app')
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

@section('content')
<div class="container">
    <h2 class="mb-4 fw-bold">Admin Dashboard</h2>

    {{-- Tombol Navigasi --}}
    <div class="mb-4 d-flex flex-wrap gap-2">
    <a href="{{ route('admin.laporan.index') }}" class="btn btn-outline-dark btn-lg">
        <i class="bi bi-folder2-open"></i> Kelola Data Pelaporan
    </a>
    <a href="{{ route('admin.sekolah.create') }}" class="btn btn-outline-success btn-lg">
        <i class="bi bi-building-add"></i> Tambah Sekolah
    </a>
    <a href="{{ route('admin.sekolah.index') }}" class="btn btn-outline-secondary btn-lg">
        <i class="bi bi-building"></i> Lihat Data Sekolah
    </a>
</div>

    {{-- Kartu Statistik --}}
    <div class="row g-4">
        <div class="col-md-4">
            <div class="card shadow-sm border-0 text-white bg-primary">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title">Total Pengguna</h6>
                            <h3 class="fw-bold">{{ \App\Models\User::count() }}</h3>
                        </div>
                        <i class="bi bi-people-fill fs-1 opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm border-0 text-white bg-success">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title">Total Laporan</h6>
                            <h3 class="fw-bold">{{ \App\Models\Laporan::count() }}</h3>
                        </div>
                        <i class="bi bi-file-earmark-text-fill fs-1 opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm border-0 text-white bg-warning">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title">Laporan Hari Ini</h6>
                            <h3 class="fw-bold">{{ \App\Models\Laporan::whereDate('created_at', today())->count() }}</h3>
                        </div>
                        <i class="bi bi-calendar-check-fill fs-1 opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
