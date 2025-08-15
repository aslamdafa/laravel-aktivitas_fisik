<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Siswa;
use App\Models\User;
class Sekolah extends Model
{
    use HasFactory;

    protected $table = 'sekolah'; // karena bukan plural

    protected $fillable = [
        'nama_sekolah',
        'alamat',
    ];

    // Relasi ke users (guru dan ortu)
    public function users()
    {
        return $this->hasMany(User::class);
    }

    // Relasi ke siswa
    public function siswa()
    {
        return $this->hasMany(Siswa::class);
    }
}
