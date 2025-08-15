<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    use HasFactory;

    protected $table = 'siswa';

    protected $fillable = [
        'nama',
        'kelas',
        'sekolah_id',
        'orangtua_id',
    ];

    // Relasi ke sekolah
    public function sekolah()
    {
        return $this->belongsTo(Sekolah::class);
    }

    // Relasi ke orang tua (users)
    public function orangTua()
{
    return $this->hasMany(OrangTua::class, 'siswa_id');
}



    // Relasi ke laporan
    public function laporans()
    {
        return $this->hasMany(Laporan::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'orangtua_id');
    }
    

}
