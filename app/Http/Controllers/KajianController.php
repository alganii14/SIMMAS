<?php

namespace App\Http\Controllers;

use App\Models\Kajian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class KajianController extends Controller
{
    public function index()
    {
        $kajians = Kajian::all();
        return view('kajian.index', compact('kajians'));
    }

    public function create()
    {
        return view('kajian.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul_kajian' => 'required|string|max:255',
            'nama_ustad' => 'nullable|string|max:255',
            'tanggal_kajian' => 'required|date',
            'deskripsi_kajian' => 'nullable|string',
            'foto_kajian' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'foto_ustad' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle file uploads
        $foto_kajian_path = $request->hasFile('foto_kajian')
            ? $request->file('foto_kajian')->storeAs('kajians', $request->file('foto_kajian')->getClientOriginalName(), 'public')
            : null;

        $foto_ustad_path = $request->hasFile('foto_ustad')
            ? $request->file('foto_ustad')->storeAs('ustads', $request->file('foto_ustad')->getClientOriginalName(), 'public')
            : null;

        Kajian::create([
            'judul_kajian' => $request->judul_kajian,
            'nama_ustad' => $request->nama_ustad ?? null,
            'tanggal_kajian' => $request->tanggal_kajian,
            'deskripsi_kajian' => $request->deskripsi_kajian,
            'foto_kajian' => $foto_kajian_path,
            'foto_ustad' => $foto_ustad_path,
        ]);

        return redirect()->route('kajian.index')->with('success', 'Kajian berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $kajian = Kajian::findOrFail($id);
        return view('kajian.edit', compact('kajian'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'judul_kajian' => 'required|string|max:255',
            'nama_ustad' => 'nullable|string|max:255',
            'tanggal_kajian' => 'required|date',
            'deskripsi_kajian' => 'nullable|string',
            'foto_kajian' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'foto_ustad' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $kajian = Kajian::findOrFail($id);

        // Handle file uploads
        $foto_kajian_path = $kajian->foto_kajian;
        if ($request->hasFile('foto_kajian')) {
            if (File::exists(public_path('storage/' . $kajian->foto_kajian))) {
                File::delete(public_path('storage/' . $kajian->foto_kajian));
            }
            $foto_kajian_path = $request->file('foto_kajian')->storeAs('kajians', $request->file('foto_kajian')->getClientOriginalName(), 'public');
        }

        $foto_ustad_path = $kajian->foto_ustad;
        if ($request->hasFile('foto_ustad')) {
            if (File::exists(public_path('storage/' . $kajian->foto_ustad))) {
                File::delete(public_path('storage/' . $kajian->foto_ustad));
            }
            $foto_ustad_path = $request->file('foto_ustad')->storeAs('ustads', $request->file('foto_ustad')->getClientOriginalName(), 'public');
        }

        $kajian->update([
            'judul_kajian' => $request->judul_kajian,
            'nama_ustad' => $request->nama_ustad ?? null,
            'tanggal_kajian' => $request->tanggal_kajian,
            'deskripsi_kajian' => $request->deskripsi_kajian,
            'foto_kajian' => $foto_kajian_path,
            'foto_ustad' => $foto_ustad_path,
        ]);

        return redirect()->route('kajian.index')->with('success', 'Kajian berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $kajian = Kajian::findOrFail($id);

        // Delete files
        if (File::exists(public_path('storage/' . $kajian->foto_kajian))) {
            File::delete(public_path('storage/' . $kajian->foto_kajian));
        }
        if (File::exists(public_path('storage/' . $kajian->foto_ustad))) {
            File::delete(public_path('storage/' . $kajian->foto_ustad));
        }

        $kajian->delete();

        return redirect()->route('kajian.index')->with('success', 'Kajian berhasil dihapus.');
    }
}
