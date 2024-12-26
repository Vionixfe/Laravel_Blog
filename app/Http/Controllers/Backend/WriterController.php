<?php

namespace App\Http\Controllers\Backend;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Requests\WriterRequest;
use App\Http\Services\Backend\WriterService;

class WriterController extends Controller
{
    public function __construct(private WriterService $writerService) {
        $this->middleware('owner');
    }

    public function index(): View
    {
        return view('backend.writers.index');
    }

    public function serverside(Request $request): JsonResponse
    {
        return $this->writerService->dataTable($request);
    }

    public function destroy(string $id): JsonResponse
    {
        $getData = $this->writerService->getFirstBy('id', $id);

        $getData->delete();

        return response()->json(['message' => 'Data Writer Berhasil Dihapus!']);
    }

    public function update(WriterRequest $request, $id)
    {
        $data = $request->validated(); // Validasi input

        $user = User::where('id', $id)->firstOrFail(); // Temukan user berdasarkan UUID

        // Set status is_verified
        if (empty($data['is_verified'])) {
            $user->is_verified = null; // Jika tidak ada input, set ke null
        } else {
            $user->is_verified = $data['is_verified']; // Set ke tanggal yang diberikan
        }

        $user->save(); // Simpan perubahan

        return response()->json(['message' => 'Status verifikasi user berhasil diperbarui!']);
        }
    



    public function edit(string $id)
    {
        $writer = $this->writerService->getFirstBy('id', $id, true);

        return view('backend.writers.edit', [
            'writer' => $writer,

        ]);
    }

 public function show(string $id): JsonResponse
{
    return response()->json(['data' => $this->writerService->getFirstBy('id', $id)]);
}

}
