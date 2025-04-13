<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RegisterController
{
    public function index()
    {
        $petugas = User::all();
        return response()->json([
            'success' => true,
            'data' => $petugas
        ]);
    }

    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'jabatan' => 'required|string',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'jabatan' => $validatedData['jabatan'],
            'password' => Hash::make($validatedData['password']),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Petugas berhasil diregistrasi.',
            'data' => $user
        ]);
    }

    public function create()
    {
        $lastPetugas = User::orderBy('id', 'desc')->first();
        $nextIdNumber = $lastPetugas ? $lastPetugas->id + 1 : 1;
        $nextId = 'ID' . str_pad($nextIdNumber, 3, '0', STR_PAD_LEFT);

        return response()->json([
            'success' => true,
            'next_id' => $nextId
        ]);
    }

    public function edit($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Petugas tidak ditemukan.'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $user
        ]);
    }

    public function update(Request $request, $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Petugas tidak ditemukan.'
            ], 404);
        }

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'jabatan' => 'required|string',
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        $user->update([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'jabatan' => $validatedData['jabatan'],
        ]);

        if ($request->filled('password')) {
            $user->update([
                'password' => Hash::make($validatedData['password']),
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Data petugas berhasil diperbarui.',
            'data' => $user
        ]);
    }

    public function destroy($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Petugas tidak ditemukan.'
            ], 404);
        }

        $user->delete();

        return response()->json([
            'success' => true,
            'message' => 'Petugas berhasil dihapus.'
        ]);
    }
}
