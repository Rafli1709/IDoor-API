<?php

namespace App\Http\Controllers;

use App\Helpers\Utils;
use DateTime;
use DateTimeZone;
use App\Models\Alat;
use App\Models\HistoryAkses;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\HistoryAksesStoreRequest;

class HistoryAksesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($id): JsonResponse
    {
        $historyAkses = HistoryAkses::with("user", "alat")
            ->whereHas('alat', function ($query) use ($id) {
                $query->where('user_id', $id);
            })
            ->orWhere('user_id', $id)
            ->get();
        return response()->json($historyAkses);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(HistoryAksesStoreRequest $request): JsonResponse
    {
        $data = $request->validated();

        $timezone = new DateTimeZone('Asia/Shanghai');
        $currentDateTime = new DateTime('now', $timezone);
        $currentTimeFormatted = $currentDateTime->format('Y-m-d H:i:s');

        $userId = $data['user_id'];

        $utils = new Utils();
        $decryption = $utils->decryptBlowfish($data['password'], $data['imei_alat']);

        $alat = Alat::whereHas('hakAkses', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })
            ->orWhere('user_id', $userId)
            ->get();
        $alat = $alat->filter(function ($item) use ($decryption) {
            return $item->secret_key === $decryption;
        });
        $alat = $alat->first();

        if ($alat) {
            HistoryAkses::create([
                'user_id' => $data['user_id'],
                'alat_id' => $alat->id,
                'waktu_akses' => $currentTimeFormatted,
                'status_pintu' => $data['status_pintu'],
                'status_akses' => "Berhasil",
                'imei' => $data['imei_akses'],
                'device_model' => $data['device_model'],
            ]);
            return response()->json(['message' => "Berhasil"]);
        } else {
            $temp = Alat::where('imei', $data['imei_alat'])->first();
            HistoryAkses::create([
                'user_id' => $data['user_id'],
                'alat_id' => $temp->id,
                'waktu_akses' => $currentTimeFormatted,
                'status_pintu' => $data['status_pintu'],
                'status_akses' => "Gagal",
                'imei' => $data['imei_akses'],
                'device_model' => $data['device_model'],
            ]);
            return response()->json(['message' => "Gagal"]);
        }
    }
}
