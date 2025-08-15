<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Pelaporan Aktivitas Fisik</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            display: flex;
            height: 100vh;
            margin: 0;
            font-family: 'Roboto', sans-serif;
        }
        .logo-container {
            flex: 1;
            background-color: white;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }
        .logo {
            width: 150px;
            height: auto; 
        }
        .website-name {
            margin-top: 10px;
            font-size: 20px;
            font-weight: 700;
            text-align: center;
            color: rgb(47, 52, 120);
        }
        .form-container {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: rgb(47, 52, 120);
            padding: 20px;
        }
        form {
            max-width: 400px;
            width: 100%;
            background: #f9f9f9;
            padding: 30px;
            border-radius: 25px;
            box-shadow: 0 10px 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            font-weight: 700;
            margin-bottom: 20px;
        }
        input,
        select {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 20px;
            font-size: 14px;
        }
        label {
            display: block;
            margin-top: 10px;
            font-weight: bold;
            font-size: 14px;
        }
        button {
            width: 100%;
            padding: 10px;
            background-color: #007BFF;
            color: white;
            border: none;
            border-radius: 20px;
            cursor: pointer;
            font-size: 16px;
        }
        button:hover {
            background-color: #0056b3;
        }
        .caption {
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
        }
        .caption a {
            color: #007BFF;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="logo-container">
        <img src="https://i.pinimg.com/736x/89/ae/8d/89ae8db9db5cc0850720ce96ae369af5.jpg" alt="Logo" class="logo">
        <div class="website-name">PELAPORAN AKTIVITAS FISIK SISWA SEKOLAH DASAR</div>
    </div>

    <div class="form-container">
        <form method="POST" action="{{ route('register') }}">
            @csrf
            <h2>Hi! Selamat Datang</h2>

            <!-- Data Orang Tua -->
            <label for="name">Nama Lengkap</label>
            <input type="text" name="name" id="name" required>

            <label for="email">Email</label>
            <input type="email" name="email" id="email" required>

            <label for="password">Password</label>
            <input type="password" name="password" id="password" required>

            <label for="password_confirmation">Konfirmasi Password</label>
            <input type="password" name="password_confirmation" id="password_confirmation" required>

            <!-- Data Siswa -->
            <label for="nama_siswa">Nama Siswa</label>
            <input type="text" name="nama_siswa" id="nama_siswa" required>

            <label for="kelas">Kelas</label>
            <input type="text" name="kelas" id="kelas" required>

            <label for="sekolah_id">Pilih Sekolah</label>
            <select name="sekolah_id" id="sekolah_id" required>
                @foreach(\App\Models\Sekolah::all() as $sekolah)
                    <option value="{{ $sekolah->id }}">{{ $sekolah->nama_sekolah }}</option>
                @endforeach
            </select>

            <button type="submit">Daftar Sekarang</button>

            <div class="caption">
                Sudah punya akun? <a href="{{ route('login') }}">Login di sini</a>
            </div>
        </form>
    </div>
</body>
</html>
