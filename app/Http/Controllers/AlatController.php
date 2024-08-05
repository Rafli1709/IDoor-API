<?php

namespace App\Http\Controllers;

use App\Helpers\Utils;
use App\Http\Requests\AlatStoreRequest;
use App\Http\Requests\AlatUpdateRequest;
use App\Models\Alat;
use Illuminate\Http\JsonResponse;

class AlatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $alat = Alat::with("user")->get();
        return response()->json([
            'totalAlat' => $alat->count(),
            'alat' => $alat,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AlatStoreRequest $request): JsonResponse
    {
        $data = $request->validated();

        $utils = new Utils();
        $encryptedText = $utils->encryptBlowfish($data['secret_key'], $data['imei']);

        $alat = Alat::create([
            'user_id' => $data['user_id'],
            'nama' => $data['nama'],
            'secret_key' => $data['secret_key'],
            'imei' => $data['imei'],
            'password' => $encryptedText
        ]);

        if ($alat) {
            return response()->json(['message' => 'Tambah data alat berhasil']);
        } else {
            return response()->json(['message' => 'Gagal menambah data alat']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Alat $alat): JsonResponse
    {
        $alat->load('user');
        return response()->json($alat);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AlatUpdateRequest $request, Alat $alat): JsonResponse
    {
        $data = $request->validated();

        $alat->nama = $data['nama'];
        $alat->user_id = $data['user_id'];

        if ($alat->save()) {
            return response()->json(['message' => 'Ubah data alat berhasil']);
        } else {
            return response()->json(['message' => 'Gagal mengubah data alat']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Alat $alat): JsonResponse
    {
        if ($alat->delete()) {
            return response()->json(['message' => 'Hapus data alat berhasil']);
        } else {
            return response()->json(['message' => 'Gagal menghapus data alat']);
        }
    }
}
