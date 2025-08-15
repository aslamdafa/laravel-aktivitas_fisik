<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Sekolah;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Siswa;
class RegisterController extends Controller
{
    /**
     * Setelah register, arahkan ke mana.
     */
    protected $redirectTo = '/home';

    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Validasi input register.
     */
    protected function validator(array $data)
{
    return Validator::make($data, [
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
        'password' => ['required', 'string', 'min:8', 'confirmed'],
        'nama_siswa' => ['required', 'string', 'max:255'],
        'kelas' => ['required', 'string', 'max:255'],
        'sekolah_id' => ['required', 'exists:sekolah,id'],
    ]);
}


    /**
     * Simpan user baru.
     */
    protected function create(array $data)
{
    \Log::info('Memasuki method create dengan data:', $data);

    // Buat user terlebih dahulu
    $user = User::create([
        'name' => $data['name'],
        'email' => $data['email'],
        'password' => Hash::make($data['password']),
        'role' => 'user', 
        'sekolah_id' => $data['sekolah_id'],
    ]);

    \Log::info('User berhasil dibuat:', ['id' => $user->id, 'email' => $user->email]);

    // Buat data siswa yang terkait dengan user (orang tua)
    Siswa::create([
        'nama' => $data['nama_siswa'],
        'kelas' => $data['kelas'],
        'orangtua_id' => $user->id,
        'sekolah_id' => $data['sekolah_id'],
    ]);

    return $user;
}

    /**
     * Proses register manual.
     */
    public function register(Request $request)
    {
        $this->validator($request->all())->validate();
        $this->create($request->all());

        return redirect()->route('login')->with('success', 'Akun berhasil dibuat. Silakan login.');
    }

    /**
     * Tampilkan form register dan kirim data sekolah.
     */
    public function showRegistrationForm()
    {
        $sekolahs = Sekolah::all();
        return view('auth.register', compact('sekolahs')); // FIXED: 'sekolah' -> 'sekolahs'
    }
}
