<?php

namespace App\Http\Controllers;

use App\Models\TabunganQurban;
use App\Models\NasabahQurban;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TabunganQurbanController extends Controller
{
    public function index()
    {
        $tabungan = TabunganQurban::with(['nasabah', 'hargaHewan'])->latest()->get();
        return view('tabungan-qurban.index', compact('tabungan'));
    }

    public function create()
    {
        $nasabah = NasabahQurban::with(['targetHewan', 'tabungan'])->get()
            ->map(function ($n) {
                return [
                    'id' => $n->id,
                    'nama' => $n->nama,
                    'target_hewan' => $n->targetHewan ? $n->targetHewan->jenis_hewan : 'Belum ada target',
                    'target_harga' => $n->targetHewan ? $n->targetHewan->harga : 0,
                    'total_tabungan' => $n->total_tabungan,
                    'sisa_tabungan' => $n->sisa_tabungan
                ];
            });

        return view('tabungan-qurban.create', compact('nasabah'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nasabah_id' => 'required|exists:nasabah_qurban,id',
            'jumlah_setoran' => 'required|numeric',
            'tanggal_setor' => 'required|date',
            'keterangan' => 'nullable|string',
        ]);

        $nasabah = NasabahQurban::findOrFail($request->nasabah_id);

        TabunganQurban::create([
            'id' => (string) Str::uuid(),
            'nasabah_id' => $request->nasabah_id,
            'harga_hewan_id' => $nasabah->target_hewan_id,
            'jumlah_setoran' => $request->jumlah_setoran,
            'tanggal_setor' => $request->tanggal_setor,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->route('tabungan-qurban.index')
            ->with('success', 'Setoran tabungan qurban berhasil ditambahkan');
    }

    public function edit($id)
    {
        $tabungan = TabunganQurban::findOrFail($id);
        $nasabah = NasabahQurban::with(['targetHewan', 'tabungan'])->get()
            ->map(function ($n) {
                return [
                    'id' => $n->id,
                    'nama' => $n->nama,
                    'target_hewan' => $n->targetHewan ? $n->targetHewan->jenis_hewan : 'Belum ada target',
                    'target_harga' => $n->targetHewan ? $n->targetHewan->harga : 0,
                    'total_tabungan' => $n->total_tabungan,
                    'sisa_tabungan' => $n->sisa_tabungan
                ];
            });

        return view('tabungan-qurban.edit', compact('tabungan', 'nasabah'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nasabah_id' => 'required|exists:nasabah_qurban,id',
            'jumlah_setoran' => 'required|numeric',
            'tanggal_setor' => 'required|date',
            'keterangan' => 'nullable|string',
        ]);

        $tabungan = TabunganQurban::findOrFail($id);
        $nasabah = NasabahQurban::findOrFail($request->nasabah_id);

        $tabungan->update([
            'nasabah_id' => $request->nasabah_id,
            'harga_hewan_id' => $nasabah->target_hewan_id,
            'jumlah_setoran' => $request->jumlah_setoran,
            'tanggal_setor' => $request->tanggal_setor,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->route('tabungan-qurban.index')
            ->with('success', 'Data tabungan qurban berhasil diperbarui');
    }

    public function destroy($id)
    {
        $tabungan = TabunganQurban::findOrFail($id);
        $tabungan->delete();

        return redirect()->route('tabungan-qurban.index')
            ->with('success', 'Data tabungan qurban berhasil dihapus');
    }
}
