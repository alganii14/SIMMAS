<?php

namespace App\Http\Controllers\Api;

use App\Models\Donatur;
use Illuminate\Http\Request;

class DonaturController
{
    // Constructor untuk menambahkan middleware jika perlu

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $donaturs = Donatur::all();
        return response()->json($donaturs);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Mengambil nomor donatur terakhir dan generate nomor berikutnya
        $lastDonatur = Donatur::latest()->first();
        $lastNoDonatur = $lastDonatur ? $lastDonatur->no_donatur : null;
        $newNoDonatur = $this->generateNoDonatur($lastNoDonatur);

        return response()->json(['newNoDonatur' => $newNoDonatur]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|max:255',
            'no_telepon' => 'required|max:15',
            'pekerjaan' => 'nullable|max:255',
            'alamat' => 'nullable|max:500',
        ]);

        $lastDonatur = Donatur::latest()->first(); // Mengambil donatur terakhir
        $lastNoDonatur = $lastDonatur ? $lastDonatur->no_donatur : null;
        $newNoDonatur = $this->generateNoDonatur($lastNoDonatur);

        $donatur = Donatur::create([
            'no_donatur' => $newNoDonatur,
            'nama' => $request->nama,
            'no_telepon' => $request->no_telepon,
            'pekerjaan' => $request->pekerjaan,
            'alamat' => $request->alamat,
        ]);

        return response()->json($donatur, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $donatur = Donatur::findOrFail($id);
        return response()->json($donatur);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|max:255',
            'no_telepon' => 'required|max:15',
            'pekerjaan' => 'nullable|max:255',
            'alamat' => 'nullable|max:500',
        ]);

        $donatur = Donatur::findOrFail($id);
        $donatur->update($request->except('no_donatur')); // Exclude no_donatur from being updated
        return response()->json($donatur);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $donatur = Donatur::findOrFail($id);
        $donatur->delete();
        return response()->json(['message' => 'Donatur berhasil dihapus.']);
    }

    /**
     * Generate nomor donatur otomatis.
     */
    private function generateNoDonatur($lastNoDonatur)
    {
        if ($lastNoDonatur) {
            $number = (int) substr($lastNoDonatur, 2); // Ambil angka terakhir
            $number++;
            return 'Dt' . str_pad($number, 3, '0', STR_PAD_LEFT); // Tambahkan padding
        }
        return 'Dt001'; // Nomor pertama jika belum ada donatur
    }
}
