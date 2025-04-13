<?php

namespace App\Http\Controllers;

use App\Models\Petugas;
use Illuminate\Http\Request;

class PetugasController extends Controller
{
    public function index()
    {
        $petugas = Petugas::all();
        return view('petugas.index', compact('petugas'));
    }

    public function create()
    {
        return view('petugas.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nik' => 'required',
            'nama' => 'required',
            'tahun_hijriah' => 'required',
            'status' => 'required|in:Petugas DKM,Warga,Penyembelih,Lainnya',
        ]);

        $validated['role'] = 'qurban';
        
        Petugas::create($validated);

        return redirect()->route('petugas.index')
            ->with('success', 'Data petugas berhasil ditambahkan');
    }

    public function edit(Petugas $petuga)
    {
        return view('petugas.edit', compact('petuga'));
    }

    public function update(Request $request, Petugas $petuga)
    {
        $validated = $request->validate([
            'nik' => 'required',
            'nama' => 'required',
            'tahun_hijriah' => 'required',
            'status' => 'required|in:Petugas DKM,Warga,Penyembelih,Lainnya',
        ]);

        $petuga->update($validated);

        return redirect()->route('petugas.index')
            ->with('success', 'Data petugas berhasil diperbarui');
    }

    public function destroy(Petugas $petuga)
    {
        $petuga->delete();
        return redirect()->route('petugas.index')
            ->with('success', 'Data petugas berhasil dihapus');
    }
}

