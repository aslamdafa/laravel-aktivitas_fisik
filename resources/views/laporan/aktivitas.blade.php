@extends('layouts.app')

@section('content')
@push('styles')
<style>
        .sidebar {
        background: linear-gradient(180deg, #1e3a8a, #3b82f6);
        min-height: 100vh;
        padding: 24px 16px;
        color: white;
        width: 250px;
        position: fixed;
        top: 0;
        left: 0;
        z-index: 1000;
    }

    .sidebar h4 {
        font-weight: 700;
        margin-bottom: 32px;
        color: #ffffff;
    }

    .sidebar a {
        color: white;
        text-decoration: none;
        display: flex;
        align-items: center;
        padding: 10px 0;
        font-weight: 500;
        transition: color 0.2s;
    }

    .sidebar a:hover {
        color: #dbeafe;
    }

    .sidebar a i {
        margin-right: 10px;
    }

    .sidebar .btn-logout {
        border: 1px solid white;
        border-radius: 8px;
        padding: 8px 16px;
        color: white;
        display: inline-block;
        margin-top: 32px;
        font-weight: 500;
        background: transparent;
        transition: background 0.2s;
    }

    .sidebar .btn-logout:hover {
        background-color: rgba(255, 255, 255, 0.1);
    }

    .content-area {
        margin-left: 250px; /* same as sidebar width */
    }

    .status-biru {
        background-color: #1e3a8a !important; /* Biru tua modern */
        color: white !important;
        padding: 8px 16px !important;
        border-radius: 8px !important;
        font-weight: 600 !important;
        display: inline-block;
    }

    .status-merah {
        background-color: #dc2626 !important; /* Merah kontras modern */
        color: white !important;
        padding: 8px 16px !important;
        border-radius: 8px !important;
        font-weight: 600 !important;
        display: inline-block;
    }

    .modern-card {
        background: white;
        border-radius: 16px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        border: 1px solid #f3f4f6;
        transition: box-shadow 0.3s ease;
    }

    .modern-card:hover {
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .stats-icon {
        width: 40px;
        height: 40px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
    }

    .intensity-badge {
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        text-transform: capitalize;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .intensity-ringan {
        background-color: #dcfce7;
        color: #166534;
    }

    .intensity-sedang {
        background-color: #fef3c7;
        color: #92400e;
    }

    .intensity-berat {
        background-color: #fee2e2;
        color: #991b1b;
    }

    .intensity-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
    }

    .dot-ringan { background-color: #22c55e; }
    .dot-sedang { background-color: #eab308; }
    .dot-berat { background-color: #ef4444; }

    .modern-form {
        background: white;
        border-radius: 16px;
        padding: 24px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        border: 1px solid #f3f4f6;
    }

    .form-input {
        padding: 12px 16px;
        border: 1px solid #d1d5db;
        border-radius: 8px;
        transition: all 0.2s ease;
        width: 100%;
        max-width: 200px;
    }

    .form-input:focus {
        outline: none;
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }

    .btn-modern {
        background: #3b82f6;
        color: white;
        padding: 12px 24px;
        border: none;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s ease;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
    }

    .btn-modern:hover {
        background: #2563eb;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .modern-table {
        width: 100%;
        border-collapse: collapse;
        background: white;
    }

    .modern-table th {
        background: #f9fafb;
        padding: 16px 24px;
        text-align: left;
        font-size: 12px;
        font-weight: 600;
        color: #6b7280;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        border-bottom: 1px solid #f3f4f6;
    }

    .modern-table td {
        padding: 16px 24px;
        border-bottom: 1px solid #f3f4f6;
        color: #111827;
    }

    .modern-table tr:hover {
        background: #f9fafb;
    }

    .mobile-card {
        background: #f9fafb;
        border-radius: 12px;
        padding: 16px;
        margin-bottom: 16px;
    }

    .summary-card {
        background: linear-gradient(135deg, #3b82f6 0%, #6366f1 100%);
        color: white;
        border-radius: 16px;
        padding: 24px;
        margin-top: 32px;
    }

    @media (max-width: 768px) {
        .desktop-table { display: none; }
        .mobile-cards { display: block; }
        .stats-grid { grid-template-columns: 1fr; }
        .form-flex { flex-direction: column; align-items: flex-start; }
    }

    @media (min-width: 769px) {
        .desktop-table { display: block; }
        .mobile-cards { display: none; }
        .stats-grid { grid-template-columns: repeat(3, 1fr); }
        .form-flex { flex-direction: row; align-items: center; }
    }
</style>
@endpush

    <div class="sidebar">
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

<div class="min-h-screen content-area" style="background: linear-gradient(135deg, #dbeafe 0%, #ffffff 50%, #e0e7ff 100%);">
    <div class="container mx-auto px-4 py-5">
        
        <!-- Header Section -->
        <div class="mb-4">
            <div class="d-flex align-items-center mb-3">
                <div class="stats-icon me-3" style="background: #3b82f6; color: white;">
                    📊
                </div>
                <div>
                    <h1 class="h3 mb-1 fw-bold text-dark">Laporan Aktivitas</h1>
                    <p class="text-muted mb-0">Pantau progress aktivitas fisik Anda</p>
                </div>
            </div>
        </div>

        <!-- Filter Section -->
        <div class="modern-form mb-4">
            <div class="d-flex align-items-center mb-3">
                <span class="me-2">🔍</span>
                <h5 class="mb-0 fw-semibold text-dark">Filter Periode</h5>
            </div>
            <form method="GET" action="{{ route('evaluasi') }}" class="form-flex d-flex gap-3">
                <div class="d-flex flex-column">
                    <label for="start_date" class="form-label small fw-medium text-dark mb-2">
                        Pilih tanggal mulai:
                    </label>
                    <input type="date" 
                           name="start_date" 
                           id="start_date"
                           value="{{ request('start_date', now()->toDateString()) }}"
                           class="form-input">
                </div>
                <button type="submit" class="btn-modern align-self-end">
                    Tampilkan
                </button>
            </form>
        </div>

        <!-- Stats Cards -->
        <div class="row g-4 mb-4 stats-grid">
            <!-- Period Card -->
            <div class="col">
                <div class="modern-card p-4">
                    <div class="d-flex align-items-center mb-3">
                        <div class="stats-icon me-3" style="background: #a855f7; color: white;">
                            📅
                        </div>
                        <h5 class="mb-0 fw-semibold text-dark">Periode</h5>
                    </div>
                    <p class="h4 fw-bold text-dark mb-1">
                        {{ $startDate->format('d M Y') }} - {{ $endDate->format('d M Y') }}
                    </p>
                    <p class="small text-muted mb-0">7 hari periode</p>
                </div>
            </div>

            <!-- Total Duration Card -->
            <div class="col">
                <div class="modern-card p-4">
                    <div class="d-flex align-items-center mb-3">
                        <div class="stats-icon me-3" style="background: #3b82f6; color: white;">
                            ⏱️
                        </div>
                        <h5 class="mb-0 fw-semibold text-dark">Total Durasi Mingguan</h5>
                    </div>
                    <p class="h4 fw-bold text-dark mb-1">
                        {{ $totalMenit }} <span class="h6 fw-normal text-muted">menit</span>
                    </p>
                    <p class="small text-muted mb-0">{{ round($totalMenit / 60, 1) }} jam</p>
                </div>
            </div>

            <!-- Status Card -->
            <div class="col">
                <div class="modern-card p-4">
                    <div class="d-flex align-items-center mb-3">
                        <div class="stats-icon me-3" style="background: #10b981; color: white;">
                            ⚡
                        </div>
                        <h5 class="mb-0 fw-semibold text-dark">Status Keaktifan</h5>
                    </div>
                    <div class="d-flex align-items-center mb-2">
                        @if ($status == 'Aktif')
                            <span class="status-biru">Aktif</span>
                        @elseif ($status == 'Kurang Aktif')
                            <span class="status-merah">Kurang Aktif</span>
                        @else
                            <span class="badge bg-secondary">Tidak Diketahui</span>
                        @endif
                    </div>
                    <p class="small text-muted mb-0">Target: 420 menit/minggu</p>
                </div>
            </div>
        </div>

        <!-- Activities Table -->
        <div class="modern-card overflow-hidden">
            <div class="p-4 border-bottom">
                <h5 class="mb-1 fw-semibold text-dark">Rincian Aktivitas</h5>
                <p class="text-muted mb-0">Detail aktivitas dalam periode yang dipilih</p>
            </div>

            <!-- Desktop Table View -->
            <div class="desktop-table">
                <table class="modern-table">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Aktivitas</th>
                            <th>Intensitas</th>
                            <th>Durasi (menit)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($laporans as $laporan)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($laporan->tanggal)->format('d M Y') }}</td>
                                <td>
                                    <div class="fw-medium text-dark">{{ $laporan->aktivitas }}</div>
                                </td>
                                <td>
                                    <span class="intensity-badge intensity-{{ $laporan->intensitas }}">
                                        <div class="intensity-dot dot-{{ $laporan->intensitas }}"></div>
                                        {{ ucfirst($laporan->intensitas) }}
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <span class="me-2">⏱️</span>
                                        {{ $laporan->menit }} menit
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-5">
                                    <div class="d-flex flex-column align-items-center">
                                        <div class="mb-3" style="font-size: 48px; color: #d1d5db;">⚡</div>
                                        <p class="h6 fw-medium text-muted mb-1">Tidak ada aktivitas dalam minggu ini.</p>
                                        <p class="small text-muted">Belum ada aktivitas dalam periode ini</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Mobile Card View -->
            <div class="mobile-cards p-3">
                @forelse ($laporans as $laporan)
                    <div class="mobile-card">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div>
                                <h6 class="fw-semibold text-dark mb-1">{{ $laporan->aktivitas }}</h6>
                                <p class="small text-muted mb-0">{{ \Carbon\Carbon::parse($laporan->tanggal)->format('d M Y') }}</p>
                            </div>
                            <span class="intensity-badge intensity-{{ $laporan->intensitas }}">
                                <div class="intensity-dot dot-{{ $laporan->intensitas }}"></div>
                                {{ ucfirst($laporan->intensitas) }}
                            </span>
                        </div>
                        <div class="d-flex align-items-center text-dark">
                            <span class="me-2">⏱️</span>
                            <span class="fw-medium">{{ $laporan->menit }} menit</span>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-5">
                        <div class="d-flex flex-column align-items-center">
                            <div class="mb-3" style="font-size: 48px; color: #d1d5db;">⚡</div>
                            <p class="h6 fw-medium text-muted mb-1">Tidak ada aktivitas dalam minggu ini.</p>
                            <p class="small text-muted">Belum ada aktivitas dalam periode ini</p>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>


    </div>
</div>
@endsection
