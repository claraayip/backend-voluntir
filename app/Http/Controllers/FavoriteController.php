<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    // ❤️ LIHAT FAVORITE
    public function index(Request $request)
    {
        return response()->json(
            Favorite::with('kegiatan')
                ->where('user_id', $request->user()->id)
                ->get()
        );
    }

    // ➕ TAMBAH FAVORITE
    public function store(Request $request)
    {
        $request->validate([
            'kegiatan_id' => 'required|exists:kegiatans,id'
        ]);

        $favorite = Favorite::create([
            'user_id' => $request->user()->id,
            'kegiatan_id' => $request->kegiatan_id
        ]);

        return response()->json([
            'message' => 'Berhasil ditambahkan ke favorite',
            'data' => $favorite
        ]);
    }

    // ❌ HAPUS FAVORITE
    public function destroy($id)
    {
        $favorite = Favorite::findOrFail($id);

        $favorite->delete();

        return response()->json([
            'message' => 'Favorite dihapus'
        ]);
    }
}