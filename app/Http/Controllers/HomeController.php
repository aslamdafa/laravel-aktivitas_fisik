<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Laporan;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Models\Siswa;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
{
    $user = Auth::user();
    $siswa = $user->siswa->first(); // ambil siswa yang terkait

    if (!$siswa) {
        // fallback jika user belum punya data siswa
        return view('home', ['chartData' => []]);
    }

    $laporanPerMinggu = Laporan::where('siswa_id', $siswa->id)
        ->get()
        ->groupBy(function($item) {
            return Carbon::parse($item->tanggal)->startOfWeek()->format('Y-m-d');
        });

    $chartData = [];

    foreach ($laporanPerMinggu as $minggu => $laporans) {
        $start = Carbon::parse($minggu);
        $end = Carbon::parse($minggu)->addDays(6);

        $chartData[] = [
            'minggu' => $start->translatedFormat('d') . '–' . $end->translatedFormat('d M'),
            'total_menit' => $laporans->sum('menit'),
            'minggu_raw' => $minggu,
        ];
    }

    $chartData = collect($chartData)->sortBy('minggu_raw')->values()->map(function($item) {
        return [
            'minggu' => $item['minggu'],
            'total_menit' => $item['total_menit']
        ];
    })->all();

    return view('home', [
        'chartData' => $chartData
    ]);
}

}
