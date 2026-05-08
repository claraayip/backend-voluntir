<?php

namespace App\Http\Controllers;

use App\Models\Kegiatan;
use App\Models\Pendaftaran;

class DashboardController extends Controller
{
    public function stats()
    {
        $totalKegiatan = Kegiatan::count();

        $totalPeserta = Pendaftaran::count();

        $kegiatanPenuh = Kegiatan::where('kuota', '<=', 0)->count();

        $kegiatanSelesai = Kegiatan::where(
            'tanggal',
            '<',
            now()->toDateString()
        )->count();

        return response()->json([
            'total_kegiatan' => $totalKegiatan,
            'total_peserta' => $totalPeserta,
            'kegiatan_penuh' => $kegiatanPenuh,
            'kegiatan_selesai' => $kegiatanSelesai,
        ]);
    }
}