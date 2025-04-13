<?php

namespace App\Http\Controllers;

use App\Models\HargaHewanQurban;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class HargaHewanQurbanController extends Controller
{
    public function index()
    {
        $hargaHewan = HargaHewanQurban::latest()->get();
        return view('harga-hewan-qurban.index', compact('hargaHewan'));
    }

    public function create()
    {
        return view('harga-hewan-qurban.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'jenis_hewan' => 'required|string',
            'harga' => 'required|numeric',
            'tahun_hijriah' => 'required|numeric',
            'keterangan' => 'nullable|string',
        ]);

        HargaHewanQurban::create([
            'id' => (string) Str::uuid(),
            'jenis_hewan' => $request->jenis_hewan,
            'harga' => $request->harga,
            'tahun_hijriah' => $request->tahun_hijriah,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->route('harga-hewan-qurban.index')
            ->with('success', 'Harga hewan qurban berhasil ditambahkan');
    }

    // ... tambahkan method edit, update, destroy
}
