<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Laporan;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Siswa;
use Illuminate\Support\Facades\Auth;
use App\Models\sekolah;
class LaporanController extends Controller
{
    // Tampilkan form input laporan
    public function input()
    {
        $jenis = 'sedang'; // default, tapi sudah tidak digunakan
        return view('laporan.input', ['jenis' => $jenis]);
    }

    // Simpan laporan aktivitas harian
   public function store(Request $request)
{
    $request->validate([
        'tanggal' => 'required|date',
        'aktivitas' => 'required|string',
        'intensitas' => 'required|in:sedang,berat',
        'menit' => 'required|integer|min:1',
        'waktu' => 'required',
    ]);

    // Ambil siswa yang dimiliki oleh user login (sebagai orangtua)
    $siswa = Siswa::where('orangtua_id', auth()->id())->firstOrFail();

    // Simpan laporan untuk siswa yang sesuai
    Laporan::create([
        'siswa_id' => $siswa->id,
        'tanggal' => $request->tanggal,
        'aktivitas' => $request->aktivitas,
        'intensitas' => $request->intensitas,
        'menit' => $request->menit,
        'waktu' => $request->waktu,
    ]);

    return redirect()->route('aktivitas.harian')->with('status', 'Laporan berhasil disimpan.');
}


    // Tampilkan aktivitas harian
    public function index()
{
    // Cek apakah user adalah orang tua (pakai tabel orang_tuas)
    if (auth()->user()->orangTua) {
        $siswa = auth()->user()->orangTua->siswa; // relasi dari model
    } else {
        // Default lama: Ambil siswa berdasarkan kolom orangtua_id di tabel siswa
        $siswa = Siswa::where('orangtua_id', auth()->id())->first();
    }

    // Jika siswa belum ditemukan
    if (!$siswa) {
        $laporans = collect(); // Collection kosong
        return view('aktivitas.harian', compact('laporans'))
            ->with('message', 'Belum ada data siswa yang terkait dengan akun ini.');
    }

    // Ambil laporan milik siswa
    $laporans = Laporan::where('siswa_id', $siswa->id)
        ->orderBy('tanggal', 'desc')
        ->get();

    // Tambahkan motivasi (jika perlu)
    $laporans->transform(function ($laporan) {
        $laporan->motivasi = $this->motivasi($laporan->menit);
        return $laporan;
    });

    return view('aktivitas.harian', compact('laporans'));
}


    // Evaluasi mingguan berdasarkan total menit (laporan aktivitas)
    public function evaluasiMingguan(Request $request)
{
    $siswa = Siswa::where('orangtua_id', auth()->id())->firstOrFail();
    $userId = $siswa->id; // Gunakan siswa_id untuk filter laporan

    // Ambil parameter dari query string (?start_date=...)
    $selectedStartDate = $request->input('start_date');

    // Jika ada input, gunakan itu, jika tidak pakai hari ini
    $startDate = $selectedStartDate
        ? Carbon::parse($selectedStartDate)
        : Carbon::today();

    // Ambil 7 hari ke depan dari tanggal awal
    $endDate = $startDate->copy()->addDays(6);

    // Ambil laporan dari periode tersebut
   $laporans = Laporan::where('siswa_id', $siswa->id)
    ->whereBetween('tanggal', [$startDate, $endDate])
    ->whereIn('intensitas', ['sedang', 'berat'])
    ->get();

    // Total menit aktivitas
    $totalMenit = $laporans->sum('menit');

    // Cari semua minggu unik untuk filter
    $availableStartDates = Laporan::where('siswa_id', $siswa->id)
        ->selectRaw('MIN(tanggal) as start_date')
        ->groupByRaw('FLOOR(DAYOFYEAR(tanggal)/7)')
        ->orderBy('start_date', 'desc')
        ->pluck('start_date');

    // ------------------------
    //  RULE-BASED SYSTEM (RBS)
    // ------------------------
    $rules = [
        [
            'condition' => fn($menit) => $menit >= 420,
            'result' => 'Aktif',
        ],
        [
            'condition' => fn($menit) => $menit < 420,
            'result' => 'Kurang Aktif',
        ]
    ];

    $status = 'Tidak Diketahui';
    foreach ($rules as $rule) {
        if ($rule['condition']($totalMenit)) {
            $status = $rule['result'];
            break;
        }
    }

    return view('laporan.aktivitas', compact(
        'laporans',
        'totalMenit',
        'startDate',
        'endDate',
        'availableStartDates',
        'selectedStartDate',
        'status'
    ));
}

    // Fungsi bantu untuk kalimat motivasi harian
    private function motivasi($menit)
    {
        if ($menit >= 60) {
            return '💪 Mantap! Kamu sangat aktif hari ini!';
        } elseif ($menit >= 30) {
            return '🌟 Bagus! Tinggal sedikit lagi capai target!';
        } else {
            return '🌱 Ayo semangat, kamu pasti bisa lebih aktif!';
        }
    }

    // Untuk admin, tampilkan semua laporan
    public function adminIndex(Request $request)
    {
        $query = Laporan::with('siswa');

        if ($request->filled('siswa_id')) {
            $query->where('siswa_id', $request->siswa_id);
        }

        $laporans = $query->paginate(10);
        $siswas = Siswa::all();

        return view('admin.laporan.index', compact('laporans', 'siswas'));
    }

    // Edit laporan
    public function edit($id)
    {
        $laporan = Laporan::findOrFail($id);
        return view('admin.laporan.edit', compact('laporan'));
    }

    // Update laporan
    public function update(Request $request, $id)
    {
        $laporan = Laporan::findOrFail($id);

        $request->validate([
            'tanggal' => 'required|date',
            'aktivitas' => 'required|string|max:255',
            'intensitas' => 'required|string',
            'menit' => 'required|integer|min:1',
        ]);

        $laporan->update($request->all());

        return redirect()->route('admin.laporan.index')->with('success', 'Laporan berhasil diperbarui.');
    }

    // Hapus laporan
    public function destroy($id)
    {
        $laporan = Laporan::findOrFail($id);
        $laporan->delete();

        return redirect()->route('admin.laporan.index')->with('success', 'Laporan berhasil dihapus.');
    }

    public function dashboardGuru()
    {
    $users = User::where('role', 'user')->get(); // Ambil semua user

    $recentLaporans = Laporan::with('siswa')
        ->latest('created_at')
        ->take(5)
        ->get(); // Ambil 5 laporan terakhir

    return view('guru.dashboard', [
        'users' => $users,
        'recentLaporans' => $recentLaporans
    ]);
    }

    public function laporanPerUser(Siswa $siswa)
{
    // Ambil semua laporan user ini untuk semua minggu
    $allLaporans = Laporan::where('siswa_id', $siswa->id)->orderBy('tanggal')->get();

    if ($allLaporans->isEmpty()) {
        return view('guru.laporan-user', [
            'siswa' => $siswa,
            'laporanPerMinggu' => collect(),
            'mingguList' => collect(),
            'selectedMinggu' => null,
        ]);
    }

    // Ambil tanggal laporan pertama user ini (sebagai anchor)
    $anchorDate = Carbon::parse($allLaporans->first()->tanggal)->startOfDay();

    // Group laporan berdasarkan minggu buatan dari anchorDate (setiap 7 hari)
    $groupedByMinggu = $allLaporans->groupBy(function ($laporan) use ($anchorDate) {
        $tanggal = Carbon::parse($laporan->tanggal)->startOfDay();
        $diffDays = $anchorDate->diffInDays($tanggal);
        $mingguKe = floor($diffDays / 7);
        return $anchorDate->copy()->addDays($mingguKe * 7)->toDateString(); // awal minggu ke-n
    });

    // Ambil list tanggal minggu untuk dropdown filter
    $mingguList = $groupedByMinggu->keys();

    // Cek apakah ada filter minggu yang dikirimkan
    $selectedMinggu = request('minggu');
    if ($selectedMinggu && $groupedByMinggu->has($selectedMinggu)) {
        // Ambil hanya laporan pada minggu yang dipilih
        $filteredLaporans = collect([
            $selectedMinggu => $groupedByMinggu[$selectedMinggu]
        ]);
    } else {
        // Tampilkan semua minggu jika tidak ada filter
        $filteredLaporans = $groupedByMinggu;
    }

    return view('guru.laporan-user', [
        'user' => $siswa,
        'laporanPerMinggu' => $filteredLaporans,
        'mingguList' => $mingguList,
        'selectedMinggu' => $selectedMinggu,
    ]);
}


    public function daftarUser()
{
    $guru = Auth::user(); // guru yang login
    $sekolahId = $guru->sekolah_id; // pastikan guru punya relasi ke sekolah

    // Ambil hanya siswa dari sekolah yang sama
    $users = User::where('role', 'siswa')
        ->where('sekolah_id', $sekolahId)
        ->get();

    return view('guru.laporan.daftar-user', compact('users'));
}

    public function daftarSiswa()
{
    $siswa = Siswa::where('sekolah_id', auth()->user()->sekolah_id)->get();
    return view('guru.laporan.daftar-user', compact('siswa'));
}

public function laporanSekolah()
{
    $laporans = Laporan::whereHas('siswa', function ($q) {
        $q->where('sekolah_id', auth()->user()->sekolah_id);
    })->get();
    return view('guru.laporan.sekolah', compact('laporans'));
}


public function laporanPerSiswa($id)
{
    $guru = auth()->user();

    $siswa = Siswa::with(['laporans', 'user'])
        ->where('sekolah_id', $guru->sekolah_id)
        ->where('id', $id)
        ->firstOrFail();

    $laporans = collect($siswa->laporans)->sortBy('tanggal');

if ($laporans->isEmpty()) {
    return view('guru.laporan-user', [
        'siswa' => $siswa,
        'mingguList' => [],
        'selectedMinggu' => null,
        'laporanPerMinggu' => [],
    ]);
}

$startDate = Carbon::parse($laporans->first()->tanggal)->startOfDay();

$laporanGrouped = $laporans->groupBy(function ($laporan) use ($startDate) {
    $laporanDate = Carbon::parse($laporan->tanggal)->startOfDay();
    $diffInDays = $startDate->diffInDays($laporanDate);
    $weekNumber = floor($diffInDays / 7) + 1;
    return 'Minggu ke-' . $weekNumber;
});

$mingguList = collect($laporanGrouped->keys())->values()->all();

$selectedMinggu = request('minggu');

if ($selectedMinggu) {
    $laporanGrouped = $laporanGrouped->only($selectedMinggu);
}

return view('guru.laporan-user', [
    'siswa' => $siswa,
    'mingguList' => $mingguList,
    'selectedMinggu' => $selectedMinggu,
    'laporanPerMinggu' => $laporanGrouped,
]);
}


    public function show($id)
{
    $siswa = Siswa::where('sekolah_id', auth()->user()->sekolah_id)->firstOrFail();
    $laporan = Laporan::where('siswa_id', $siswa->id)->findOrFail($id);
    
    return view('laporan.show', compact('laporan'));
}

    public function laporanAnak()
{
    $user = Auth::user();
    $siswa = $user->siswa; // semua siswa anaknya

    return view('orangtua.laporan_anak', compact('siswa'));
}

}
