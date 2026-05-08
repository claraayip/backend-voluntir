<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kegiatan extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function pendaftarans()
    {
        return $this->hasMany(Pendaftaran::class);
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }
}