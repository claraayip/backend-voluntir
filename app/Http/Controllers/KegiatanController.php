<?php

namespace App\Http\Controllers;

use App\Models\Kegiatan;
use Illuminate\Http\Request;

class KegiatanController extends Controller
{
    // 🔍 READ + SEARCH + FILTER
    public function index(Request $request)
    {
        $query = Kegiatan::query();

        // 🔍 Search
        if ($request->search) {
            $query->where('nama_kegiatan', 'like', '%' . $request->search . '%');
        }

        // 📂 Filter kategori
        if ($request->kategori) {
            $query->where('kategori', $request->kategori);
        }

        // 📍 Filter lokasi
        if ($request->lokasi) {
            $query->where('lokasi', 'like', '%' . $request->lokasi . '%');
        }

        $kegiatan = $query->get();

        return response()->json($kegiatan);
    }

    // ➕ CREATE
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_kegiatan' => 'required|string|max:255',
            'deskripsi' => 'required',
            'lokasi' => 'required',
            'tanggal' => 'required|date',
            'kategori' => 'required',
            'durasi' => 'required',
            'kuota' => 'required|integer|min:1',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'

        ]);

        // 🖼 Upload gambar
        if ($request->hasFile('gambar')) {
            $validated['gambar'] = $request->file('gambar')
                ->store('kegiatan', 'public');
        }

        $validated['organizer_id'] = $request->user()->id;
        $validated['status'] = 'Menunggu';
        $data = Kegiatan::create($validated);

        return response()->json([
            'message' => 'Kegiatan berhasil ditambahkan',
            'data' => $data
        ], 201);
    }

    // 🔍 DETAIL
    public function show($id)
    {
        $kegiatan = Kegiatan::findOrFail($id);

        return response()->json($kegiatan);
    }

    // ✏️ UPDATE
    public function update(Request $request, $id)
    {
        $kegiatan = Kegiatan::findOrFail($id);

        $validated = $request->validate([
            'nama_kegiatan' => 'required|string|max:255',
            'deskripsi' => 'required',
            'lokasi' => 'required',
            'tanggal' => 'required|date',
            'kategori' => 'required',
            'durasi' => 'required',
            'kuota' => 'required|integer|min:1',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        // 🖼 Upload gambar
        if ($request->hasFile('gambar')) {
            $validated['gambar'] = $request->file('gambar')
                ->store('kegiatan', 'public');
        }

        $kegiatan->update($validated);

        return response()->json([
            'message' => 'Data berhasil diupdate',
            'data' => $kegiatan
        ]);
    }

    // ❌ DELETE
    public function destroy($id)
    {
        $kegiatan = Kegiatan::findOrFail($id);

        $kegiatan->delete();

        return response()->json([
            'message' => 'Data berhasil dihapus'
        ]);
    }

    // ✅ APPROVE KEGIATAN
    public function approve($id)
    {
        $kegiatan = Kegiatan::findOrFail($id);

        $kegiatan->update([
            'status' => 'Diterima'
        ]);

        return response()->json([
            'message' => 'Kegiatan disetujui'
        ]);
    }

    // ❌ REJECT KEGIATAN
    public function reject($id)
    {
        $kegiatan = Kegiatan::findOrFail($id);

        $kegiatan->update([
            'status' => 'Ditolak'
        ]);

        return response()->json([
            'message' => 'Kegiatan ditolak'
        ]);
    }
}