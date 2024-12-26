<?php

namespace App\Http\Controllers\Backend;

use App\Models\Article;
use App\Http\Controllers\Controller;
use App\Http\Requests\EditArticleRequest;

class ConfirmController extends Controller
{
    public function update(EditArticleRequest $request, $uuid)
    {
        $data = $request->validated(); // Validasi input

        $article = Article::where('uuid', $uuid)->firstOrFail(); // Temukan artikel berdasarkan UUID

        // Set status konfirmasi
        $article->is_confirm = $data['is_confirm'] ?? null; // Set ke null jika tidak ada
        $article->save(); // Simpan perubahan

        return response()->json(['message' => 'Status konfirmasi artikel berhasil diperbarui!']);
    }
}
