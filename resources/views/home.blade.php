<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Aktivitas Fisik</title>

    <!-- Font Google -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500&family=Poppins:wght@600&display=swap" rel="stylesheet">

    <!-- Bootstrap & Icons -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        body {
            margin: 0;
            font-family: 'Montserrat', sans-serif;
            background-color: #f0f2f5;
        }

        h1.judul-sistem {
            font-family: 'Poppins', sans-serif;
            font-weight: 600;
        }

        .wrapper {
            display: flex;
            min-height: 100vh;
        }

        .sidebar {
            width: 220px;
            background: linear-gradient(to bottom, #0d6efd, #0544a3);
            color: white;
            padding: 30px 20px;
            flex-shrink: 0;
        }

        .sidebar h2 {
            font-size: 1.3rem;
            margin-bottom: 25px;
            font-weight: 500;
        }

        .nav-link {
            display: flex;
            align-items: center;
            color: white;
            margin-bottom: 15px;
            text-decoration: none;
            transition: background 0.3s;
            padding: 8px 10px;
            border-radius: 5px;
            font-weight: 400;
        }

        .nav-link i {
            margin-right: 10px;
        }

        .nav-link:hover {
            background-color: rgba(255, 255, 255, 0.15);
            text-decoration: none;
        }

        .logout-button {
            margin-top: 40px;
        }

        .content {
            flex-grow: 1;
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            padding: 40px;
            background-color: #fff;
        }

        .welcome-section {
            max-width: 60%;
        }

        .welcome-section img {
            max-width: 320px;
            width: 100%;
            margin-top: 25px;
            border-radius: 12px;
        }

        .chart-container {
        width: 100%;
        max-width: 500px;
        height: 260px;
        background-color: #ffffff;
        padding: 20px;
        border-radius: 16px;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.08);
        margin-top: 30px;
        }

        @media (max-width: 768px) {
            .wrapper {
                flex-direction: column;
            }

            .content {
                display: flex;
                justify-content: space-between;
                align-items: stretch;
                padding: 40px;
                background-color: #fff;
             }

            .welcome-section {
                max-width: 100%;
                text-align: center;
            }

            .right-image {
                flex: 1;
                display: flex;
                justify-content: center;
                align-items: center;
                padding-left: 20px;
            }

            .chart-container {
                width: 100%;
                margin-top: 30px;
            }

            .sidebar {
                width: 100%;
                text-align: center;
            }

            .nav-link {
                justify-content: center;
            }
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <!-- Sidebar -->
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

       <div class="content">
    <!-- Kiri: Teks + Grafik -->
    <div class="left-content" style="flex: 1;">
        <div class="welcome-section mb-4">
            <h5 class="text-muted">Selamat datang, <strong>{{ Auth::user()->name }}</strong></h5>
            <h1 class="mb-4 text-primary judul-sistem">Sistem Pelaporan Aktivitas Fisik</h1>
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif
            <p>Gunakan menu di sebelah kiri untuk mulai input atau melihat laporan aktivitas siswa.</p>
        </div>

        <!-- Grafik di bawah teks -->
        <div class="chart-container">
            <h6 class="text-center text-primary mb-3">Grafik Durasi / Minggu</h6>
            <canvas id="durasiChart"></canvas>
        </div>
    </div>

    <!-- Kanan: Gambar di tengah -->
    <div class="right-image d-flex justify-content-center align-items-center">
        <img src="https://i.pinimg.com/736x/4e/61/1b/4e611baf705e35602b5acd3c80744aeb.jpg"
            alt="Ilustrasi Anak Olahraga"
            style="max-width: 320px; width: 100%; border-radius: 12px;">
    </div>
</div>

    <!-- Chart.js -->
    <script>
        const ctx = document.getElementById('durasiChart').getContext('2d');
        const durasiChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: {!! json_encode(array_column($chartData, 'minggu')) !!},
                datasets: [{
                    label: 'Durasi (menit)',
                    data: {!! json_encode(array_column($chartData, 'total_menit')) !!},
                    borderColor: '#0d6efd',
                    backgroundColor: 'rgba(13,110,253,0.2)',
                    fill: true,
                    tension: 0.4,
                    pointRadius: 4,
                    pointBackgroundColor: '#0d6efd'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                aspectRatio: 2.2,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 10
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });
    </script>
</body>

</html>