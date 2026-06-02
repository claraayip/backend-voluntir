<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Pendaftaran;
use App\Models\Favorite;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'foto',
        'role'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function pendaftarans()
    {
    return $this->hasMany(Pendaftaran::class);
    }

    public function favorites()
    {
    return $this->hasMany(Favorite::class);
    }
    
    public function kegiatans()
    {
    return $this->hasMany(Kegiatan::class, 'organizer_id');
    }
}