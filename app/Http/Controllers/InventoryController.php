<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class InventoryController extends Controller
{
    public function index()
    {
        $inventories = Inventory::all();
        return view('inventories.index', compact('inventories'));
    }

    public function create()
    {
        return view('inventories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'kondisi' => 'required|in:Baik,Rusak,Hilang',
            'gambar' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $gambarPath = $request->file('gambar') ? $request->file('gambar')->store('inventories', 'public') : null;

        Inventory::create([
            'nama' => $request->nama,
            'kondisi' => $request->kondisi,
            'gambar' => $gambarPath
        ]);

        return redirect()->route('inventories.index')->with('success', 'Inventaris berhasil ditambahkan!');
    }

    public function edit(Inventory $inventory)
    {
        return view('inventories.edit', compact('inventory'));
    }

    public function update(Request $request, Inventory $inventory)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'kondisi' => 'required|in:Baik,Rusak,Hilang',
            'gambar' => 'image|mimes:jpeg,png,jpg,gif,heic|max:2048'
        ]);

        if ($request->hasFile('gambar')) {
            if ($inventory->gambar) {
                Storage::disk('public')->delete($inventory->gambar);
            }
            $gambarPath = $request->file('gambar')->store('inventories', 'public');
        } else {
            $gambarPath = $inventory->gambar;
        }

        $inventory->update([
            'nama' => $request->nama,
            'kondisi' => $request->kondisi,
            'gambar' => $gambarPath
        ]);

        return redirect()->route('inventories.index')->with('success', 'Inventaris berhasil diperbarui!');
    }

    public function destroy(Inventory $inventory)
    {
        if ($inventory->gambar) {
            Storage::disk('public')->delete($inventory->gambar);
        }

        $inventory->delete();
        return redirect()->route('inventories.index')->with('success', 'Inventaris berhasil dihapus!');
    }
}
