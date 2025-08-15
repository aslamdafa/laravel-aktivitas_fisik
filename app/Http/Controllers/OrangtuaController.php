<?php

namespace App\Http\Controllers;

use App\Models\OrangTua;
use App\Models\User;
use App\Models\Siswa;
use App\Models\Laporan;    // ini sudah benar
use Illuminate\Http\Request;
use Carbon\Carbon;

class OrangTuaController extends Controller
{
    public function index()
    {
        $orangTuas = OrangTua::with(['user', 'siswa'])->get();
        $users = User::whereDoesntHave('orangTua')->get(); // hanya user yg belum jadi orang tua
        $siswas = Siswa::all();

        return view('orangtua.index', compact('orangTuas', 'users', 'siswas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'siswa_id' => 'required|exists:siswa,id',
        ]);

        OrangTua::create([
            'user_id' => $request->user_id,
            'siswa_id' => $request->siswa_id
        ]);

        return back()->with('success', 'Orang tua berhasil ditautkan dengan siswa.');
    }

    public function destroy($id)
    {
        OrangTua::findOrFail($id)->delete();
        return back()->with('success', 'Data orang tua berhasil dihapus.');
    }

    public function lihatLaporan()
    {
        $user = auth()->user();
        
        // Ambil laporan berdasarkan user (orang tua) yang login
        $laporan = Laporan::where('orangtua_id', $user->id)->get();

        return view('orangtua.laporan', compact('laporan'));
    }

   public function laporan(Request $request)
    {
        $orangTua = auth()->user()->orangTua;
        
        if (!$orangTua || !$orangTua->siswa) {
            $laporans = collect();
            $namaAnak = 'Anak Anda';
            $totalMenit = 0;
            $status = 'Tidak Diketahui';
            $startDate = Carbon::now()->toDateString();
            $endDate = Carbon::now()->addDays(6)->toDateString();
            
            return view('orangtua.laporan', compact('laporans', 'namaAnak', 'totalMenit', 'status', 'startDate', 'endDate'));
        }

        $siswa = $orangTua->siswa;

        // Mendapatkan tanggal mulai dari request. Jika tidak ada, gunakan tanggal hari ini.
        $selectedDate = $request->input('start_date', Carbon::now()->toDateString());
        $startDate = Carbon::parse($selectedDate);
        $endDate = $startDate->copy()->addDays(6);

        // Ambil semua laporan dalam rentang 7 hari
        $laporans = Laporan::where('siswa_id', $siswa->id)
            ->whereBetween('tanggal', [$startDate, $endDate])
            ->orderBy('tanggal', 'asc')
            ->get();

        // Aturan RBS
        $totalMenit = $laporans->sum('durasi_menit');
        $status = ($totalMenit >= 420) ? 'Aktif' : 'Kurang Aktif';

        $namaAnak = $siswa->nama;

        return view('orangtua.laporan', compact('laporans', 'namaAnak', 'totalMenit', 'status', 'startDate', 'endDate'));
    }
}

