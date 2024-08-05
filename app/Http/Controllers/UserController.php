<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $users = User::all();
        return response()->json([
            'totalUser' => $users->count(),
            'users' => $users,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserStoreRequest $request): JsonResponse
    {
        $data = $request->validated();
        $user = User::create([
            'name' => $data['name'],
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => 'user',
        ]);

        $user->profile()->create();

        if ($user && $user->save()) {
            return response()->json(['message' => 'Tambah data user berhasil']);
        } else {
            return response()->json(['message' => 'Gagal menambah data user']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user): JsonResponse
    {
        return response()->json($user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserUpdateRequest $request, User $user): JsonResponse
    {
        $data = $request->validated();

        $user->name = $data['name'];
        $user->username = $data['username'];
        $user->email = $data['email'];

        if ($user->save()) {
            return response()->json(['message' => 'Update data user berhasil']);
        } else {
            return response()->json(['message' => 'Gagal mengupdate data user']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user): JsonResponse
    {
        if ($user->delete()) {
            return response()->json(['message' => 'Hapus data user berhasil']);
        } else {
            return response()->json(['message' => 'Gagal menghapus data user']);
        }
    }
}
