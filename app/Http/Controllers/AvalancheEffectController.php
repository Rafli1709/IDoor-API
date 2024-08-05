<?php

namespace App\Http\Controllers;

use App\Models\Alat;
use App\Helpers\Utils;
use Illuminate\Http\Request;
use App\Models\AvalancheEffect;

class AvalancheEffectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $avalancheEffect = AvalancheEffect::all();
        return response()->json($avalancheEffect);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store()
    {
        $utils = new Utils();

        $alat = Alat::take(10)->get();
        foreach ($alat as $item) {
            $encryptedText = $utils->encryptBlowfish($item->secret_key, $item->imei);
            $avalancheEffect = $utils->avalancheEffect($item->secret_key, $item->imei);

            $findAV = AvalancheEffect::where('plaintext', $item->secret_key)->first();

            if ($findAV) {
                $findAV->update([
                    'ciphertext' => $encryptedText,
                    'avalance_effect' => $avalancheEffect,
                ]);
            } else {
                AvalancheEffect::create([
                    'plaintext' => $item->secret_key,
                    'ciphertext' => $encryptedText,
                    'avalance_effect' => $avalancheEffect,
                ]);
            }
        }

        return response()->json(['message' => 'Hitung Nilai Avalance Effect berhasil']);
    }

    /**
     * Display the specified resource.
     */
    public function show(AvalancheEffect $avalancheEffect)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AvalancheEffect $avalancheEffect)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, AvalancheEffect $avalancheEffect)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AvalancheEffect $avalancheEffect)
    {
        //
    }
}
