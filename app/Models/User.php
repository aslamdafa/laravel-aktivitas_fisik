<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Siswa;
use App\Models\Sekolah;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role', // Tambahkan role untuk menyelesaikan error silent
        'sekolah_id', // Tambahkan sekolah_id untuk relasi
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
        ];
    }
    public function laporans()
    {
    return $this->hasMany(Laporan::class);
    }

    public function sekolah()
{
    return $this->belongsTo(Sekolah::class);
}

public function siswa()
{
    return $this->hasMany(Siswa::class, 'orangtua_id');
}


public function orangTua()
{
    return $this->hasOne(OrangTua::class);
}

}
