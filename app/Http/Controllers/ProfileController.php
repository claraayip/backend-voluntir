<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    // 👤 LIHAT PROFILE
    public function me(Request $request)
    {
        return response()->json($request->user());
    }

    // ✏️ UPDATE PROFILE
    public function update(Request $request)
    {
        $user = $request->user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // 🖼 Upload foto
        if ($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')
                ->store('profile', 'public');
        }

        $user->update($validated);

        return response()->json([
            'message' => 'Profile berhasil diupdate',
            'data' => $user
        ]);
    }
}