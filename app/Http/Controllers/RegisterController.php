<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        $petugas = User::all(); // Retrieve all users to display in the table
        return view('register.index', compact('petugas'));
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'jabatan' => 'required|string',
            'password' => 'required|string|min:6|confirmed',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'jabatan' => $request->jabatan,
            'password' => bcrypt($request->password),
        ]);

        return redirect()->route('register')->with('success', 'Petugas berhasil diregistrasi.');
    }

    // This is the missing 'create' method
    public function create()
    {
        // Get the last ID from the database and increment it.
        $lastPetugas = User::orderBy('id', 'desc')->first();  // assuming 'id' is the name of the ID field
        $nextIdNumber = $lastPetugas ? $lastPetugas->id + 1 : 1; // If there's no record, start from 1.

        // Format the next ID with 'ID00' prefix and zero-padded number (e.g., ID001, ID002, etc.)
        $nextId = 'ID' . str_pad($nextIdNumber, 3, '0', STR_PAD_LEFT);  // 3 is the length of the number you want, change as needed.

        return view('register.create', compact('nextId'));
    }

    public function edit(User $user)
    {
        return view('register.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        // Validate the input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'jabatan' => 'required|string',
            'password' => 'nullable|string|min:6|confirmed',  // Make password field optional
        ]);

        // Update user information
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'jabatan' => $request->jabatan,
        ]);

        // If a password is provided, update it
        if ($request->filled('password')) {
            $user->update([
                'password' => bcrypt($request->password),
            ]);
        }

        return redirect()->route('register')->with('success', 'Data petugas berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('register')->with('success', 'Petugas berhasil dihapus.');
    }
}