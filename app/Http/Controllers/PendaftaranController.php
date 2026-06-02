<?php

namespace App\Http\Controllers;

use App\Models\Pendaftaran;
use App\Models\Kegiatan;
use Illuminate\Http\Request;

class PendaftaranController extends Controller
{
    // 📋 HISTORY USER
    public function index(Request $request)
    {
        return response()->json(
            Pendaftaran::with('kegiatan')
                ->where('user_id', $request->user()->id)
                ->get()
        );
    }

    // ➕ DAFTAR KEGIATAN
    public function store(Request $request)
    {
        $request->validate([
            'kegiatan_id' => 'required|exists:kegiatans,id'
        ]);

        $kegiatan = Kegiatan::findOrFail($request->kegiatan_id);

        // ❌ CEK KUOTA
        if ($kegiatan->kuota <= 0) {
            return response()->json([
                'message' => 'Kuota kegiatan habis'
            ], 400);
        }

        // ❌ CEK SUDAH DAFTAR
        $sudahDaftar = Pendaftaran::where('user_id', $request->user()->id)
            ->where('kegiatan_id', $request->kegiatan_id)
            ->exists();

        if ($sudahDaftar) {
            return response()->json([
                'message' => 'Kamu sudah daftar kegiatan ini'
            ], 400);
        }

        // ✅ SIMPAN
        $pendaftaran = Pendaftaran::create([
            'user_id' => $request->user()->id,
            'kegiatan_id' => $request->kegiatan_id,
            'status' => 'Menunggu'      
            ]);

        // ✅ KURANGI KUOTA
        $kegiatan->decrement('kuota');

        return response()->json([
            'message' => 'Berhasil daftar kegiatan',
            'data' => $pendaftaran
        ], 201);
    }

    // ❌ BATAL DAFTAR
    public function destroy($id)
    {
        $pendaftaran = Pendaftaran::findOrFail($id);

        // balikin kuota
        $pendaftaran->kegiatan->increment('kuota');

        $pendaftaran->delete();

        return response()->json([
            'message' => 'Pendaftaran dibatalkan'
        ]);
    }

    // 👥 LIHAT PESERTA
    public function peserta($id)
    {
        return response()->json(
            Pendaftaran::with('user')
                ->where('kegiatan_id', $id)
                ->get()
        );
    }

    // ORGANIZER APPROVE DAN REJECT VOLUNTEER
    public function approve($id)
    {
    $pendaftaran = Pendaftaran::findOrFail($id);

    $pendaftaran->update([
        'status' => 'Diterima'
    ]);

    return response()->json([
        'message' => 'Volunteer diterima'
    ]);
    }   

    public function reject($id)
    {
    $pendaftaran = Pendaftaran::findOrFail($id);

    $pendaftaran->update([
        'status' => 'Ditolak'
    ]);

    return response()->json([
        'message' => 'Volunteer ditolak'
    ]);
    }
}