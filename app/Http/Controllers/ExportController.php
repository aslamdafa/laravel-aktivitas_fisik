<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\Laporan;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Illuminate\Support\Facades\Response;

class ExportController extends Controller
{
    public function exportSiswa(Siswa $siswa)
    {
        // Validasi: hanya guru dari sekolah yang sama yang boleh mengakses
        if (auth()->user()->role !== 'guru' || auth()->user()->sekolah_id !== $siswa->sekolah_id) {
            abort(403, 'Anda tidak memiliki akses untuk siswa ini.');
        }

        // Ambil semua laporan dari siswa tersebut
        $laporans = Laporan::where('siswa_id', $siswa->id)->get();

        // Inisialisasi spreadsheet
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Header kolom
        $sheet->setCellValue('A1', 'Tanggal');
        $sheet->setCellValue('B1', 'Aktivitas');
        $sheet->setCellValue('C1', 'Intensitas');
        $sheet->setCellValue('D1', 'Waktu');
        $sheet->setCellValue('E1', 'Durasi (menit)');

        // Isi data
        $row = 2;
        foreach ($laporans as $laporan) {
            $sheet->setCellValue("A$row", $laporan->tanggal);
            $sheet->setCellValue("B$row", $laporan->aktivitas);
            $sheet->setCellValue("C$row", $laporan->intensitas);
            $sheet->setCellValue("D$row", $laporan->waktu);
            $sheet->setCellValue("E$row", $laporan->menit);
            $row++;
        }

        // Simpan ke file sementara
        $writer = new Xlsx($spreadsheet);
        $fileName = 'laporan_siswa_' . $siswa->nama . '_' . now()->format('Ymd_His') . '.xlsx';
        $tempFile = storage_path('app/public/' . $fileName);
        $writer->save($tempFile);

        // Download dan hapus setelah dikirim
        return response()->download($tempFile)->deleteFileAfterSend(true);
    }
}
