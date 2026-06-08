<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Kegiatan;
use App\Models\Pendaftaran;

class DashboardController extends Controller
{
    public function stats()
{
    return response()->json([
        'total_user' => \App\Models\User::where('role', 'user')->count(),

        'total_organizer' => \App\Models\User::where('role', 'organizer')->count(),

        'total_kegiatan' => Kegiatan::count(),

        'kegiatan_pending' => Kegiatan::where('status', 'Menunggu')->count(),

        'kegiatan_approved' => Kegiatan::where('status', 'Diterima')->count(),
    ]);
    }
}