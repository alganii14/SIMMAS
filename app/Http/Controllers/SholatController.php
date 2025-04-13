<?php

namespace App\Http\Controllers;

use App\Models\Sholat;
use Illuminate\Http\Request;

class SholatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sholats = Sholat::all();
        return view('sholat.index', compact('sholats'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('sholat.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_sholat' => 'required|string|max:255',
            'waktu_sholat' => 'required|date_format:H:i',
            'waktu_iqomah' => 'required|date_format:H:i',
        ]);

        Sholat::create($validated);
        return redirect()->route('sholat.index')->with('success', 'Data sholat berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Sholat $sholat)
    {
        return view('sholat.edit', compact('sholat'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Sholat $sholat)
    {
        $validated = $request->validate([
            'nama_sholat' => 'required|string|max:255',
            'waktu_sholat' => 'required|date_format:H:i',
            'waktu_iqomah' => 'required|date_format:H:i',
        ]);

        $sholat->update($validated);
        return redirect()->route('sholat.index')->with('success', 'Data sholat berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sholat $sholat)
    {
        $sholat->delete();
        return redirect()->route('sholat.index')->with('success', 'Data sholat berhasil dihapus.');
    }
}
