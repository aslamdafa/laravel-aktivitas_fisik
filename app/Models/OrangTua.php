<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrangTua extends Model
{
    protected $fillable = ['user_id', 'siswa_id'];

    public function user()
{
    return $this->belongsTo(User::class, 'user_id');
}


    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }
}

