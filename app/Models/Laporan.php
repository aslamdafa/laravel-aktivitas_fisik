<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Aktivitas;
class Laporan extends Model
{
    use HasFactory;

    protected $fillable = [ 
    'siswa_id',
    'tanggal',
    'aktivitas',
    'intensitas',
    'menit',
    'waktu',
    ];
    
    // Relasi ke user

    public function aktivitas()
{
    return $this->belongsTo(Aktivitas::class);
}

    public function siswa()
{
    return $this->belongsTo(Siswa::class);
}

}
