<?php

namespace App\Http\Controllers;

use App\Models\Muzakki;
use Illuminate\Http\Request;

class MuzakkiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $muzakkis = Muzakki::all();
        return view('muzakki.index', compact('muzakkis'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $lastMuzakki = Muzakki::latest()->first();
        $lastNumber = $lastMuzakki ? (int)substr($lastMuzakki->no_muzakki, 2) : 0;
        $newNumber = $lastNumber + 1;
        $newNoMuzakki = 'MZ' . str_pad($newNumber, 3, '0', STR_PAD_LEFT);

        return view('muzakki.create', compact('newNoMuzakki'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_muzakki' => 'required|string|max:50',
            'telp_muzakki' => 'required|string|max:13',
            'alamat_muzakki' => 'required',
        ]);

        // Generate nomor muzakki
        $lastMuzakki = Muzakki::latest()->first();
        $lastNumber = $lastMuzakki ? (int)substr($lastMuzakki->no_muzakki, 2) : 0;
        $newNumber = $lastNumber + 1;
        $newNoMuzakki = 'MZ' . str_pad($newNumber, 3, '0', STR_PAD_LEFT);

        Muzakki::create([
            'no_muzakki' => $newNoMuzakki,
            'nama_muzakki' => $request->nama_muzakki,
            'telp_muzakki' => $request->telp_muzakki,
            'alamat_muzakki' => $request->alamat_muzakki,
            'tanggal_input' => now(),
        ]);

        return redirect()->route('muzakki.index')->with('success', 'Data Muzakki berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(muzakki $muzakki)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $muzakki = Muzakki::findOrFail($id);
        return view('muzakki.edit', compact('muzakki'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_muzakki' => 'required|string|max:50',
            'telp_muzakki' => 'required|string|max:13',
            'alamat_muzakki' => 'required',
        ]);

        $muzakki = Muzakki::findOrFail($id);
        $muzakki->update($request->only([
            'nama_muzakki',
            'telp_muzakki',
            'alamat_muzakki'
        ]));

        return redirect()->route('muzakki.index')->with('success', 'Data Muzakki berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $muzakki = Muzakki::findOrFail($id);
        $muzakki->delete();
        return redirect()->route('muzakki.index')->with('success', 'Data Muzakki berhasil dihapus.');
    }
}
