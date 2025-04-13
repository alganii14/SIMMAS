<?php

namespace App\Http\Controllers;

use App\Models\NasabahQurban;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\HargaHewanQurban;

class NasabahQurbanController extends Controller
{
    public function index()
    {
        $nasabah = NasabahQurban::all();
        return view('nasabah-qurban.index', compact('nasabah'));
    }

    public function create()
    {
        $hargaHewan = HargaHewanQurban::orderBy('tahun_hijriah', 'desc')->get();
        return view('nasabah-qurban.create', compact('hargaHewan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nik' => 'required|string|max:20',
            'nama' => 'required|string|max:50',
            'hp' => 'required|string|max:20',
            'alamat' => 'required|string',
            'target_hewan_id' => 'nullable|exists:harga_hewan_qurban,id',
        ]);

        NasabahQurban::create([
            'id' => (string) Str::uuid(),
            'nik' => $request->nik,
            'nama' => $request->nama,
            'hp' => $request->hp,
            'alamat' => $request->alamat,
            'target_hewan_id' => $request->target_hewan_id,
            'ref_id' => Str::random(8)
        ]);

        return redirect()->route('nasabah-qurban.index')
            ->with('success', 'Data nasabah qurban berhasil ditambahkan');
    }

    public function edit($id)
    {
        $nasabah = NasabahQurban::with(['targetHewan', 'tabungan'])->findOrFail($id);
        $hargaHewan = HargaHewanQurban::orderBy('tahun_hijriah', 'desc')->get();
        return view('nasabah-qurban.edit', compact('nasabah', 'hargaHewan'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nik' => 'required|string|max:20',
            'nama' => 'required|string|max:50',
            'hp' => 'required|string|max:20',
            'alamat' => 'required|string',
            'target_hewan_id' => 'nullable|exists:harga_hewan_qurban,id',
        ]);

        $nasabah = NasabahQurban::findOrFail($id);
        $nasabah->update([
            'nik' => $request->nik,
            'nama' => $request->nama,
            'hp' => $request->hp,
            'alamat' => $request->alamat,
            'target_hewan_id' => $request->target_hewan_id,
        ]);

        return redirect()->route('nasabah-qurban.index')
            ->with('success', 'Data nasabah qurban berhasil diperbarui');
    }

    public function destroy($id)
    {
        $nasabah = NasabahQurban::findOrFail($id);
        $nasabah->delete();

        return redirect()->route('nasabah-qurban.index')
            ->with('success', 'Data nasabah qurban berhasil dihapus');
    }
}
