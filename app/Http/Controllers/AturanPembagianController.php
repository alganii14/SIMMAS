<?php

namespace App\Http\Controllers;

use App\Models\AturanPembagian;
use App\Models\PembagianProduk;
use Illuminate\Http\Request;

class AturanPembagianController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $aturanPembagians = AturanPembagian::all();
        $pembagianProduks = PembagianProduk::all();
        return view('aturan-pembagian.index', compact('aturanPembagians', 'pembagianProduks'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'status' => 'required',
            'produk' => 'required|array|min:1',
        ]);

        AturanPembagian::create([
            'status' => $request->status,
            'produk' => implode(', ', $request->produk)
        ]);

        return redirect()->route('aturan-pembagian.index')
            ->with('success', 'Aturan pembagian berhasil ditambahkan');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $aturanPembagian = AturanPembagian::findOrFail($id);
        return view('aturan-pembagian.edit', compact('aturanPembagian'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required',
            'produk' => 'required|array|min:1',
        ]);

        $aturanPembagian = AturanPembagian::findOrFail($id);
        $aturanPembagian->update([
            'status' => $request->status,
            'produk' => implode(', ', $request->produk)
        ]);

        return redirect()->route('aturan-pembagian.index')
            ->with('success', 'Aturan pembagian berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $aturanPembagian = AturanPembagian::findOrFail($id);
        $aturanPembagian->delete();

        return redirect()->route('aturan-pembagian.index')
            ->with('success', 'Aturan pembagian berhasil dihapus');
    }

    /**
     * Store a newly created pembagian produk.
     */
    public function storeProduk(Request $request)
    {
        $validated = $request->validate([
            'produk' => 'required|string',
            'berat' => 'required|numeric|min:0',
            'total_bungkus' => 'required|integer|min:1',
        ]);

        // Hitung berat per produk
        $beratPerproduk = $validated['berat'] / $validated['total_bungkus'];

        PembagianProduk::create([
            'produk' => $validated['produk'],
            'berat' => $validated['berat'],
            'total_bungkus' => $validated['total_bungkus'],
            'berat_perproduk' => $beratPerproduk
        ]);

        return redirect()->route('aturan-pembagian.index')
            ->with('success', 'Data produk berhasil ditambahkan');
    }

    /**
     * Show the form for editing pembagian produk.
     */
    public function editProduk($id)
    {
        $pembagianProduk = PembagianProduk::findOrFail($id);
        return view('aturan-pembagian.edit-produk', compact('pembagianProduk'));
    }

    /**
     * Update pembagian produk in storage.
     */
    public function updateProduk(Request $request, $id)
    {
        $validated = $request->validate([
            'produk' => 'required|string',
            'berat' => 'required|numeric|min:0',
            'total_bungkus' => 'required|integer|min:1',
        ]);

        $pembagianProduk = PembagianProduk::findOrFail($id);

        // Hitung ulang berat per produk
        $beratPerproduk = $validated['berat'] / $validated['total_bungkus'];

        $pembagianProduk->update([
            'produk' => $validated['produk'],
            'berat' => $validated['berat'],
            'total_bungkus' => $validated['total_bungkus'],
            'berat_perproduk' => $beratPerproduk
        ]);

        return redirect()->route('aturan-pembagian.index')
            ->with('success', 'Data produk berhasil diperbarui');
    }

    /**
     * Remove pembagian produk from storage.
     */
    public function destroyProduk($id)
    {
        $pembagianProduk = PembagianProduk::findOrFail($id);
        $pembagianProduk->delete();

        return redirect()->route('aturan-pembagian.index')
            ->with('success', 'Data produk berhasil dihapus');
    }
}
