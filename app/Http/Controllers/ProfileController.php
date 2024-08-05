<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class ProfileController extends Controller
{
    /**
     * Display the specified resource.
     */
    public function show($id): JsonResponse
    {
        $user = User::with('profile')->find($id);
        return response()->json($user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProfileUpdateRequest $request, $id): JsonResponse
    {
        $data = $request->validated();

        $user = User::with('profile')->find($id);

        $user->name = $data['name'];
        $user->username = $data['username'];
        $user->email = $data['email'];
        $user->save();

        $user->profile->no_hp = $data['no_hp'];
        $user->profile->jenis_kelamin = $data['jenis_kelamin'];
        $user->profile->tgl_lahir = $data['tgl_lahir'];
        $user->profile->alamat = $data['alamat'];
        $user->profile->save();

        return response()->json($user);
    }
}
