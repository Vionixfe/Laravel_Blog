<?php

namespace App\Http\Controllers\Backend;

use App\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\EditWriterRequest;

class VerifiedController extends Controller
{
    public function update(EditWriterRequest $request, $id)
    {
        $data = $request->validated(); // Validasi input

        $writer = User::where('id', $id)->firstOrFail(); // Temukan artikel berdasarkan UUID

        // Set status konfirmasi
        $writer->is_verified = $data['is_verified'] ?? null; // Set ke null jika tidak ada
        $writer->save(); // Simpan perubahan

        return response()->json(['message' => 'Status konfirmasi Writer berhasil diperbarui!']);
    }
}
