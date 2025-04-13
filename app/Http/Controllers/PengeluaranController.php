<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengeluaran;
use App\Models\Infaq; // Untuk mendapatkan sisa saldo infaq
use Illuminate\Support\Facades\Auth;

class PengeluaranController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Ambil semua data pengeluaran
        $pengeluarans = Pengeluaran::all();

        // Kirim data pengeluaran ke view
        return view('pengeluaran.index', compact('pengeluarans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Hitung sisa saldo dari model Infaq
        $sisaSaldo = Infaq::sum('jumlah');

        // Generate nomor pengajuan otomatis
        $lastPengajuan = Pengeluaran::latest()->first();
        $tanggal = now()->format('dmy'); // Format: hari-bulan-tahun (e.g., 251224)
        $urutan = $lastPengajuan ? (int)substr($lastPengajuan->no_pengajuan, -3) + 1 : 1;
        $noPengajuan = 'PL.' . $tanggal . '.' . str_pad($urutan, 3, '0', STR_PAD_LEFT);

        return view('pengeluaran.create', compact('sisaSaldo', 'noPengajuan'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'no_pengajuan' => 'required',
            'nama_koordinator' => 'required',
            'koordinator_bidang' => 'required',
            'jenis_pengeluaran' => 'required',
            'jumlah' => 'required|numeric',
            'keterangan' => 'required',
        ]);

        // Menentukan user_id yang terhubung dengan user yang sedang login
        $user_id = Auth::id();  // Mengambil ID user yang sedang login

        // Menyimpan data pengeluaran
        $pengeluaran = Pengeluaran::create([
            'no_pengajuan' => $request->no_pengajuan,
            'user_id' => $user_id, // Menyimpan user_id yang terhubung
            'nama_koordinator' => $request->nama_koordinator,
            'koordinator_bidang' => $request->koordinator_bidang,
            'jenis_pengeluaran' => $request->jenis_pengeluaran,
            'jumlah' => $request->jumlah,
            'keterangan' => $request->keterangan,
            'tanggal' => $request->tanggal ?? now(),  // Gunakan tanggal sekarang jika kosong
        ]);

        // Update saldo Infaq dengan mengurangi jumlah yang baru saja diajukan
        $sisaSaldo = Infaq::sum('jumlah'); // Mengambil total saldo Infaq
        $jumlahPengeluaran = $request->jumlah;

        if ($sisaSaldo >= $jumlahPengeluaran) {
            // Kurangi saldo infaq jika cukup
            Infaq::first()->decrement('jumlah', $jumlahPengeluaran);
        } else {
            return redirect()->back()->with('error', 'Saldo Infaq tidak cukup.');
        }

        return redirect()->route('pengeluaran.index')->with('success', 'Pengeluaran berhasil disimpan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        // Retrieve the Pengeluaran entry by its ID
        $pengeluaran = Pengeluaran::findOrFail($id);

        // Example options for dropdowns, these can come from a config or database
        $koordinatorBidangOptions = [
            'Koordinator Bidang Dakwah & Ibadah',
            'Koordinator Bidang Sosial Kemasyarakatan',
            'Koordinator Bidang Pendidikan',
            'Koordinator Bidang Pemberdayaan Ziswaf',
            'Koordinator Bidang Kerumah Tanggaan',
            'Koordinator Bidang Muslimah',
        ];

        $jenisPengeluaranOptions = [
            'Pengeluaran DKM',
            'Tagihan Bulanan',
            'Kegiatan',
            'Pembelian Barang',
            'Lainnya',
        ];

        $sisaSaldo = Infaq::sum('jumlah');

        // Generate nomor pengajuan otomatis
        $lastPengajuan = Pengeluaran::latest()->first();
        $tanggal = now()->format('dmy'); // Format: hari-bulan-tahun (e.g., 251224)
        $urutan = $lastPengajuan ? (int)substr($lastPengajuan->no_pengajuan, -3) + 1 : 1;
        $noPengajuan = 'PL.' . $tanggal . '.' . str_pad($urutan, 3, '0', STR_PAD_LEFT);

        // Pass data to the edit view
        return view('pengeluaran.edit', compact('pengeluaran', 'sisaSaldo', 'koordinatorBidangOptions', 'jenisPengeluaranOptions'));
    }

    /**
     * Update the specified Pengeluaran in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Pengeluaran  $pengeluaran
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'nama_koordinator' => 'required|string|max:255',
            'koordinator_bidang' => 'required|string',
            'jenis_pengeluaran' => 'required|string',
            'jumlah' => 'required|numeric',
            'keterangan' => 'required|string',
        ]);

        // Retrieve the Pengeluaran entry by its ID
        $pengeluaran = Pengeluaran::findOrFail($id);
        $previousJumlah = $pengeluaran->jumlah;  // Get the previous amount from the record
        $sisaSaldo = Infaq::sum('jumlah'); // Get the total current saldo from Infaq

        // First, we add the previous amount back to the Infaq saldo
        Infaq::first()->increment('jumlah', $previousJumlah);

        // Then, check if the new amount can be deducted from the saldo
        $newJumlah = $request->jumlah;

        if ($sisaSaldo >= $newJumlah) {
            // Subtract the new amount from the saldo if sufficient funds are available
            Infaq::first()->decrement('jumlah', $newJumlah);

            // Update the Pengeluaran with the new validated data
            $pengeluaran->update($validatedData);

            return redirect()->route('pengeluaran.index')->with('success', 'Pengeluaran berhasil diperbarui.');
        } else {
            return redirect()->back()->with('error', 'Saldo Infaq tidak cukup untuk pengeluaran yang baru.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
{
    // Retrieve the pengeluaran record to be deleted
    $pengeluaran = Pengeluaran::findOrFail($id);

    // Get the amount that was deducted from the saldo when the pengeluaran was added
    $jumlahPengeluaran = $pengeluaran->jumlah;

    // Restore the saldo by adding the deleted pengeluaran amount back
    Infaq::first()->increment('jumlah', $jumlahPengeluaran);

    // Delete the pengeluaran record
    $pengeluaran->delete();

    return redirect()->route('pengeluaran.index')->with('success', 'Pengeluaran berhasil dihapus dan saldo telah dikembalikan.');
}
}
