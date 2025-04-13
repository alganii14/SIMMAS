<?php

namespace App\Http\Controllers;

use App\Models\Donatur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DonaturController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $donaturs = Donatur::all();
        return view('donatur.index', compact('donaturs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Mengambil nomor donatur terakhir dan generate nomor berikutnya
        $lastDonatur = Donatur::latest()->first();
        $lastNoDonatur = $lastDonatur ? $lastDonatur->no_donatur : null;
        $newNoDonatur = $this->generateNoDonatur($lastNoDonatur);

        return view('donatur.create', compact('newNoDonatur'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|max:255',
            'no_telepon' => 'required|max:15',
            'pekerjaan' => 'nullable|max:255',
            'alamat' => 'nullable|max:500',
            'email' => 'nullable|email|max:255',
            'anonim' => 'nullable|in:ya,tidak',
            'pesan_doa' => 'nullable|max:500',
        ]);

        // Generate nomor donatur otomatis
        $lastDonatur = Donatur::latest()->first(); // Mengambil donatur terakhir
        $lastNoDonatur = $lastDonatur ? $lastDonatur->no_donatur : null;
        $newNoDonatur = $this->generateNoDonatur($lastNoDonatur);

        // Simpan data donatur baru
        Donatur::create([
            'no_donatur' => $newNoDonatur,
            'nama' => $request->nama,
            'no_telepon' => $request->no_telepon,
            'pekerjaan' => $request->pekerjaan,
            'alamat' => $request->alamat,
            'email' => $request->email,
            'anonim' => $request->anonim ?? 'tidak',
            'pesan_doa' => $request->pesan_doa,
        ]);

        return redirect()->route('donatur.index')->with('success', 'Donatur berhasil ditambahkan.');
    }

    /**
     * Store a new donatur via AJAX for the infaq form.
     */
    public function storeAjax(Request $request)
{
    // Validasi input
    $validator = Validator::make($request->all(), [
        'nama' => 'required|max:255',
        'no_telepon' => 'required|max:15',
        'email' => 'nullable|email|max:255',
        'pesan' => 'nullable|max:500',
        'sapaan' => 'required|in:Bpk.,Ibu,Kak.',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'status' => 'error',
            'errors' => $validator->errors()
        ], 422);
    }

    // Tentukan status anonim
    $anonim = $request->has('sembunyikan_nama') ? 'ya' : 'tidak';
    
    // Simpan nama asli, tetapi tandai sebagai anonim jika dipilih
    $namaLengkap = $request->sapaan . ' ' . $request->nama;

    // Cek apakah donatur dengan nomor telepon ini sudah ada
    $existingDonatur = Donatur::where('no_telepon', $request->no_telepon)->first();
    
    if ($existingDonatur) {
        // Update data donatur yang sudah ada
        $existingDonatur->nama = $namaLengkap; // Simpan nama asli
        $existingDonatur->email = $request->email;
        $existingDonatur->anonim = $anonim; // Update status anonim
        
        // Simpan pesan ke kolom pesan_doa, bukan ke alamat
        if ($request->pesan) {
            $existingDonatur->pesan_doa = $request->pesan;
        }
        $existingDonatur->save();
        
        return response()->json([
            'status' => 'success',
            'message' => 'Data donatur berhasil diperbarui',
            'donatur_id' => $existingDonatur->id
        ]);
    }
    
    // Generate nomor donatur otomatis
    $lastDonatur = Donatur::latest()->first();
    $lastNoDonatur = $lastDonatur ? $lastDonatur->no_donatur : null;
    $newNoDonatur = $this->generateNoDonatur($lastNoDonatur);

    // Buat donatur baru
    $donatur = Donatur::create([
        'no_donatur' => $newNoDonatur,
        'nama' => $namaLengkap, // Simpan nama asli
        'no_telepon' => $request->no_telepon,
        'email' => $request->email,
        'pesan_doa' => $request->pesan, // Simpan pesan ke kolom pesan_doa
        'alamat' => null, // Alamat bisa diisi nanti jika diperlukan
        'pekerjaan' => null, // Bisa ditambahkan di form jika diperlukan
        'anonim' => $anonim, // Simpan status anonim
    ]);

    return response()->json([
        'status' => 'success',
        'message' => 'Data donatur berhasil disimpan',
        'donatur_id' => $donatur->id
    ]);
}

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $donatur = Donatur::findOrFail($id);
        return view('donatur.show', compact('donatur'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $donatur = Donatur::findOrFail($id);
        return view('donatur.edit', compact('donatur'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|max:255',
            'no_telepon' => 'required|max:15',
            'pekerjaan' => 'nullable|max:255',
            'alamat' => 'nullable|max:500',
            'email' => 'nullable|email|max:255',
            'anonim' => 'nullable|in:ya,tidak',
            'pesan_doa' => 'nullable|max:500',
        ]);

        $donatur = Donatur::findOrFail($id);
        $donatur->update($request->except('no_donatur')); // Exclude no_donatur from being updated
        return redirect()->route('donatur.index')->with('success', 'Donatur berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $donatur = Donatur::findOrFail($id);
        $donatur->delete();
        return redirect()->route('donatur.index')->with('success', 'Donatur berhasil dihapus.');
    }

    /**
     * Generate nomor donatur otomatis.
     */
    private function generateNoDonatur($lastNoDonatur)
    {
        if ($lastNoDonatur) {
            $number = (int) substr($lastNoDonatur, 2); // Ambil angka terakhir
            $number++;
            return 'Dt' . str_pad($number, 3, '0', STR_PAD_LEFT); // Tambahkan padding
        }
        return 'Dt001'; // Nomor pertama jika belum ada donatur
    }
}