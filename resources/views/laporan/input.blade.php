@extends('layouts.app')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Montserrat&family=Poppins:wght@500&display=swap');

    .wrapper {
        display: flex;
        min-height: 100vh;
    }

    .sidebar {
        width: 250px;
        background: linear-gradient(to bottom, #007bff, #0056b3);
        padding: 20px;
        color: white;
    }

    .sidebar h2 {
        font-family: 'Poppins', sans-serif;
        font-weight: 600;
        font-size: 20px;
        margin-bottom: 30px;
    }

    .sidebar .nav-link {
        display: block;
        padding: 10px 15px;
        color: white;
        text-decoration: none;
        border-radius: 8px;
        font-family: 'Montserrat', sans-serif;
        margin-bottom: 10px;
        transition: background 0.3s;
    }

    .sidebar .nav-link:hover,
    .sidebar .nav-link.active {
        background-color: #ffffff22;
        font-weight: bold;
    }

    .logout-button {
        margin-top: 20px;
    }

    .content {
        flex-grow: 1;
        padding: 30px;
        background-color: #ffffff;
    }

    .judul-sistem {
        font-family: 'Poppins', sans-serif;
        font-weight: 600;
        color: #007bff;
    }

    .form-label {
        font-weight: 500;
    }
</style>

<!-- Bootstrap & Icons -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

<div class="wrapper">
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="text-center mb-4">
        </div>

        <h2 class="mb-4">Menu Navigasi</h2>

        <a href="{{ url('/home') }}" class="nav-link {{ request()->is('home') ? 'active' : '' }}">
            <i class="bi bi-house-door mr-2"></i> Home
        </a>
        <a href="{{ route('laporan.input') }}" class="nav-link {{ request()->is('laporan/input') ? 'active' : '' }}">
            <i class="bi bi-pencil-square mr-2"></i> Input Laporan
        </a>
        <a href="{{ route('aktivitas.harian') }}" class="nav-link {{ request()->is('aktivitas/harian') ? 'active' : '' }}">
            <i class="bi bi-calendar-day mr-2"></i> Aktivitas Harian
        </a>
        <a href="{{ route('evaluasi') }}" class="nav-link {{ request()->is('evaluasi') ? 'active' : '' }}">
            <i class="bi bi-bar-chart-line mr-2"></i> Laporan Mingguan
        </a>

        <form action="{{ route('logout') }}" method="POST" class="logout-button">
            @csrf
            <button type="submit" class="btn btn-outline-light w-100 mt-4">
                <i class="bi bi-box-arrow-right mr-2"></i> Logout
            </button>
        </form>
    </div>

    <!-- Konten -->
    <div class="content">
        <div class="container w-100">
            <h1 class="judul-sistem mb-3">Input Laporan Aktivitas</h1>
            <p class="text-muted mb-4">Masukkan laporan aktivitas anak secara lengkap dan akurat.</p>

            <form action="{{ route('laporan.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="tanggal" class="form-label">Tanggal</label>
                    <input type="date" name="tanggal" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="waktu" class="form-label">Waktu (jam)</label>
                    <input type="time" name="waktu" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="intensitas" class="form-label">Intensitas Aktivitas</label>
                    <select name="intensitas" id="intensitas" class="form-control" required>
                        <option value="">-- Pilih Intensitas --</option>
                        <option value="sedang">Sedang</option>
                        <option value="berat">Berat</option>
                    </select>
                    <button type="button" class="btn btn-link p-0" data-bs-toggle="modal" data-bs-target="#infoAktivitasModal">
                        ℹ️ Info aktivitas
                    </button>
                </div>

                <div class="mb-3">
                    <label for="aktivitas" class="form-label">Aktivitas</label>
                    <select name="aktivitas" id="aktivitas" class="form-control" required>
                        <option value="">-- Pilih Aktivitas --</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="menit" class="form-label">Durasi (menit)</label>
                    <select name="menit" class="form-control" required>
                        <option value="">-- Pilih Durasi --</option>
                        @for ($i = 10; $i <= 60; $i += 10)
                            <option value="{{ $i }}">{{ $i }} menit</option>
                        @endfor
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">Simpan Laporan</button>
            </form>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="infoAktivitasModal" tabindex="-1" aria-labelledby="infoAktivitasModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Informasi Aktivitas</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body">
                <strong>Sedang:</strong><br>
                Membantu pekerjaan rumah, Berjalan santai, Bermain dengan teman, dll.<br><br>
                <strong>Berat:</strong><br>
                Lari, Berenang, Bermain bola, dll.
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const aktivitasOptions = {
            sedang: [
                "Membantu pekerjaan rumah",
                "Berjalan santai",
                "Bermain dengan teman",
                "Berjalan cepat",
                "Naik sepeda",
                "Membawa barang ringan",
                "Naik tangga"
            ],
            berat: [
                "Lari",
                "Berenang",
                "Mengangkat beban",
                "Bermain bola (sepak bola, basket, voli)",
                "Bersepeda cepat",
                "Push-up, sit-up",
                "Lompat tali"
            ]
        };

        const intensitasSelect = document.getElementById('intensitas');
        const aktivitasSelect = document.getElementById('aktivitas');

        intensitasSelect.addEventListener('change', function () {
            const selected = this.value;
            aktivitasSelect.innerHTML = '<option value="">-- Pilih Aktivitas --</option>';

            if (aktivitasOptions[selected]) {
                aktivitasOptions[selected].forEach(function (aktivitas) {
                    const option = document.createElement('option');
                    option.value = aktivitas;
                    option.textContent = aktivitas;
                    aktivitasSelect.appendChild(option);
                });
            }
        });
    });
</script>
@endpush
@endsection