<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AktifKids - Aplikasi Pelaporan Aktivitas Fisik Siswa SD</title>
    <meta name="description" content="Aplikasi pelaporan aktivitas fisik untuk siswa SD yang membantu memantau dan mendorong gaya hidup aktif">
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    
    <!-- Styles -->
    <style>
        :root {
            --primary: #2563eb;
            --primary-dark: #1d4ed8;
            --primary-light:rgb(2, 57, 159);
            --neutral-50: #f8fafc;
            --neutral-100: #f1f5f9;
            --neutral-600: #475569;
            --neutral-700: #334155;
            --neutral-800: #1e293b;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Nunito', sans-serif;
            line-height: 1.5;
            color: var(--neutral-800);
        }

        .container {
            width: 100%;
            max-width: 1280px;
            margin: 0 auto;
            padding: 0 1rem;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            text-decoration: none;
        }

        .logo-text {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--primary);
        }

        .nav-buttons {
            display: flex;
            gap: 1rem;
        }

        /* Hero Section */
        .hero {
            padding: 5rem 1rem;
            background: linear-gradient(to bottom,rgba(76, 127, 222, 0.67), white);
        }

        .hero-container {
            display: flex;
            align-items: center;
            gap: 2rem;
        }

        .hero-content {
            flex: 1;
        }

        .hero-image {
            flex: 1;
            display: none;
        }

        .hero-image img {
            width: 100%;
            border-radius: 0.5rem;
            box-shadow: 0 20px 25px -5px rgba(0, 106, 255, 0.1);
        }

        /* Features Section */
        .features {
            padding: 2rem 1rem; 
            background-color: white;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 1.25rem;
        }

        .feature-card {
            background-color: white;
            padding: 1rem; /* sebelumnya 1.5rem */
            border-radius: 0.75rem;
            box-shadow: 0 2px 4px rgba(20, 144, 253, 0.41);
            transition: box-shadow 0.3s ease;
            text-align: center;
        }

        .feature-card:hover {
            box-shadow: 0 6px 12px -3px rgba(0, 0, 0, 0.1);
        }

        .feature-icon {
            background-color: #eff6ff;
            width: 3rem;
            height: 3rem;
            border-radius: 9999px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem auto;
        }

        .feature-icon svg {
            width: 24px;
            height: 24px;
        }

        .feature-card h3 {
            font-size: 1.125rem;
            margin-bottom: 0.5rem;
        }

        .feature-card p {
            font-size: 0.95rem;
            color: var(--neutral-700);
        }

        /* Buttons */
        .btn {
            display: inline-block;
            padding: 0.75rem 1.5rem;
            border-radius: 9999px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .btn-primary {
            background-color: var(--primary);
            color: white;
            border: 2px solid var(--primary);
        }

        .btn-primary:hover {
            background-color: var(--primary-dark);
            border-color: var(--primary-dark);
        }

        .btn-outline {
            background-color: transparent;
            border: 2px solid var(--primary);
            color: var(--primary);
        }

        .btn-outline:hover {
            background-color: var(--primary-light);
            color: white;
        }

        .btn-white {
            background-color: white;
            color: var(--primary);
        }

        .btn-white:hover {
            background-color: var(--neutral-100);
        }

        /* Typography */
        h1 {
            font-size: 2.5rem;
            line-height: 1.2;
            margin-bottom: 1rem;
            color: var(--neutral-800);
        }

        h2 {
            font-size: 2rem;
            line-height: 1.2;
            margin-bottom: 1rem;
        }

        h3 {
            font-size: 1.25rem;
            margin-bottom: 0.75rem;
        }

        .text-lg {
            font-size: 1.125rem;
        }

        /* Responsive */
        @media (min-width: 768px) {
            .hero-image {
                display: block;
            }

            .features-grid {
                grid-template-columns: repeat(3, 1fr);
            }

            .footer-container {
                flex-direction: row;
                justify-content: space-between;
            }
        }
    </style>
</head>
<body>

    <!-- Hero Section -->
    <section class="hero">
        <div class="container hero-container">
            <div class="hero-content">
                <h1>Pantau Aktivitas Fisik Siswa dengan Mudah</h1>
                <p class="text-lg text-neutral-600 mb-8">
                    Catat dan analisis aktivitas fisik siswa SD untuk mendorong gaya hidup sehat dan aktif.
                </p>
                <div class="nav-buttons">
                    <a href="{{ route('register') }}" class="btn btn-primary">Mulai Sekarang</a>
                    <a href="{{ route('login') }}" class="btn btn-outline">Masuk</a>
                </div>
            </div>
            <div class="hero-image">
                <img src="https://img.freepik.com/free-photo/group-young-children-running-playing-park_1150-3891.jpg?uid=R87584107&ga=GA1.1.715236373.1709318836&semt=ais_hybrid&w=740" alt="Anak-anak berolahraga">
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features">
        <div class="container">
            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-primary">
                            <path d="M9 11l3 3L22 4"></path><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path>
                        </svg>
                    </div>
                    <h3>Input Aktivitas</h3>
                    <p>Catat durasi dan intensitas aktivitas fisik siswa dengan mudah</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-primary">
                            <path d="M18 20V10M12 20V4M6 20v-6"></path>
                        </svg>
                    </div>
                    <h3>Laporan Harian</h3>
                    <p>Lihat hasil aktivitas harian untuk pemantauan rutin</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-primary">
                            <path d="M3 3v18h18"></path><path d="m19 9-5 5-4-4-3 3"></path>
                        </svg>
                    </div>
                    <h3>Laporan Aktivitas Fisik Mingguan</h3>
                    <p>Evaluasi tingkat keaktifan siswa</p>
                </div>
            </div>
        </div>
    </section>
</body>
</html>