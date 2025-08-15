<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Siswa;
use App\Models\Laporan;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\OrangTua;

class GuruController extends Controller
{
    public function siswa()
{
    $siswa = Siswa::where('sekolah_id', auth()->user()->sekolah_id)->get();
    return view('guru.siswa', compact('siswa'));
}

public function index()
{
    $sekolahId = auth()->user()->sekolah_id;

    // Ambil semua siswa dari sekolah tersebut
    $siswaList = Siswa::where('sekolah_id', $sekolahId)->with('laporans')->get();

    return view('guru.monitoring', compact('siswaList'));
}

    public function destroy($id)
{
    // Logika penghapusan data
    $orangTua = OrangTua::findOrFail($id);
    $orangTua->delete();
    
    return redirect()->back()->with('success', 'Orang tua berhasil dihapus');
}


public function laporanSiswa(Request $request, $id)
{
    $siswa = Siswa::with(['orangTua.user', 'laporans'])
        ->findOrFail($id);

    // Ambil semua minggu yang tersedia dari laporan
    $mingguList = $siswa->laporans
        ->pluck('minggu')
        ->unique()
        ->sort()
        ->values();

    // Ambil minggu yang dipilih dari query string
    $selectedMinggu = $request->get('minggu');

    // Filter laporan berdasarkan minggu (jika dipilih)
    $laporanPerMinggu = DB::table('laporans')
    ->where('siswa_id', $id)
    ->get()
    ->filter() // buang null/false
    ->groupBy(function($laporan) {
        return Carbon::parse($laporan->tanggal)->startOfWeek()->translatedFormat('d M Y') . ' - ' .
               Carbon::parse($laporan->tanggal)->endOfWeek()->translatedFormat('d M Y');
    });


    return view('guru.laporan-siswa', compact(
        'siswa',
        'mingguList',
        'selectedMinggu',
        'laporanPerMinggu'
    ));
}

    public function dashboard()
{
    $guru = auth()->user(); // user yang login

    // Ambil siswa yang sekolahnya sama dengan sekolah guru, beserta relasi sekolah dan orangTua.user
    $siswaList = Siswa::with(['sekolah', 'orangTua.user'])
        ->where('sekolah_id', $guru->sekolah_id)
        ->get();

    // Ambil user yang rolenya 'orangtua' dan sekolahnya sama dengan guru
    $orangTuaUsers = User::where('role', 'orangtua')
        ->where('sekolah_id', $guru->sekolah_id)
        ->get();

    // JANGAN lupa kirim $guru juga kalau di blade ada pakai $guru (opsional)
    return view('guru.dashboard', compact( 'siswaList', 'orangTuaUsers'));
}



}
