<?php

namespace App\Http\Controllers;

use App\Models\Alat;
use App\Models\HakAkses;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\HakAksesStoreRequest;

class HakAksesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($id): JsonResponse
    {
        $alat = Alat::with("hakAkses")->whereHas('hakAkses', function ($query) use ($id) {
            $query->where('user_id', $id);
        })
            ->orWhere('user_id', $id)
            ->get();

        $totalAlatDimiliki = Alat::where('user_id', $id)->count();

        $totalAlatDipinjam = Alat::whereHas('hakAkses', function ($query) use ($id) {
            $query->where('user_id', $id);
        })->count();

        return response()->json([
            'totalAlatDimiliki' => $totalAlatDimiliki,
            'totalAlatDipinjam' => $totalAlatDipinjam,
            'alat' => $alat,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(HakAksesStoreRequest $request): JsonResponse
    {
        $data = $request->validated();
        $hakAkses = HakAkses::create([
            'user_id' => $data['user_id'],
            'alat_id' => $data['alat_id'],
            'batas_waktu' => $data['batas_waktu'],
        ]);

        if ($hakAkses) {
            return response()->json(['message' => 'Tambah data hak akses berhasil']);
        } else {
            return response()->json(['message' => 'Gagal menambah data hak akses']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id): JsonResponse
    {
        $hakAkses = HakAkses::with("user")->where('alat_id', $id)->get();
        return response()->json($hakAkses);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id): JsonResponse
    {
        $hakAkses = HakAkses::find($id);
        if ($hakAkses->delete()) {
            return response()->json(['message' => 'Hapus data hak akses berhasil']);
        } else {
            return response()->json(['message' => 'Gagal menghapus data hak akses']);
        }
    }
}
