<?php

namespace App\Http\Controllers;

use App\Models\Mustahik;
use Illuminate\Http\Request;

class MustahikController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $mustahiks = Mustahik::all();
        return view('mustahik.index', compact('mustahiks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Generate nomor mustahik otomatis
        $lastMustahik = Mustahik::latest()->first();
        $lastNumber = $lastMustahik ? (int) substr($lastMustahik->no_mustahik, 2) : 0;
        $newNumber = $lastNumber + 1;
        $newNoMustahik = 'MS' . str_pad($newNumber, 3, '0', STR_PAD_LEFT);

        // Daftar Asnaf
        $asnafList = [
            'Fakir',
            'Miskin',
            'Amilin',
            'Amilin Lainnya'
        ];

        return view('mustahik.create', compact('newNoMustahik', 'asnafList'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'no_kk' => 'required|string|max:18',
            'nama_mustahik' => 'required|string|max:50',
            'alamat_mustahik' => 'required',
            'asnaf' => 'required|string|max:35',
            'rt' => 'required|string|max:2',
            'jumlah_anak' => 'required|integer|min:0' // Tambahkan validasi
        ]);

        // Generate nomor mustahik
        $lastMustahik = Mustahik::latest()->first();
        $lastNumber = $lastMustahik ? (int) substr($lastMustahik->no_mustahik, 2) : 0;
        $newNumber = $lastNumber + 1;
        $newNoMustahik = 'MS' . str_pad($newNumber, 3, '0', STR_PAD_LEFT);

        Mustahik::create([
            'no_mustahik' => $newNoMustahik,
            'no_kk' => $request->no_kk,
            'nama_mustahik' => $request->nama_mustahik,
            'alamat_mustahik' => $request->alamat_mustahik,
            'asnaf' => $request->asnaf,
            'tanggal_input' => now(),
            'rt' => $request->rt,
            'jumlah_anak' => $request->jumlah_anak // Tambahkan ini
        ]);

        return redirect()->route('mustahik.index')->with('success', 'Data Mustahik berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(mustahik $mustahik)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $mustahik = Mustahik::findOrFail($id);
        $asnafList = [
            'Fakir',
            'Miskin',
            'Amilin',
            'Amilin Lainnya'
        ];
        return view('mustahik.edit', compact('mustahik', 'asnafList'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'no_kk' => 'required|string|max:18',
            'nama_mustahik' => 'required|string|max:50',
            'alamat_mustahik' => 'required',
            'asnaf' => 'required|string|max:35',
            'rt' => 'required|string|max:2',
            'jumlah_anak' => 'required|integer|min:0' // Tambahkan validasi
        ]);

        $mustahik = Mustahik::findOrFail($id);
        $mustahik->update($request->only([
            'no_kk',
            'nama_mustahik',
            'alamat_mustahik',
            'asnaf',
            'rt',
            'jumlah_anak' // Tambahkan ini
        ]));

        return redirect()->route('mustahik.index')->with('success', 'Data Mustahik berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $mustahik = Mustahik::findOrFail($id);
        $mustahik->delete();
        return redirect()->route('mustahik.index')->with('success', 'Data Mustahik berhasil dihapus.');
    }
}
