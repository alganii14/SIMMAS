<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Infaq;
use App\Models\User;
use App\Models\Donatur;
use Illuminate\Http\Request;

class InfaqController extends Controller
{
    /**
     * Menampilkan daftar infaq dalam format JSON.
     */
    public function index(Request $request)
    {
        $query = Infaq::with(['petugas', 'donatur']); // Ambil relasi petugas dan donatur

        if ($request->has('search') && $request->search) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('no_penerimaan', 'like', "%$searchTerm%")
                  ->orWhereHas('petugas', function ($q) use ($searchTerm) {
                      $q->where('name', 'like', "%$searchTerm%");
                  })
                  ->orWhereHas('donatur', function ($q) use ($searchTerm) {
                      $q->where('nama', 'like', "%$searchTerm%");
                  })
                  ->orWhere('jenis_penerimaan', 'like', "%$searchTerm%");
            });
        }

        $infaqs = $query->get();

        return response()->json($infaqs);
    }

    /**
     * Menampilkan data untuk form create dalam format JSON.
     */
    public function create()
    {
        $petugas = User::all();
        $donaturs = Donatur::all();

        // Ambil nomor penerimaan terakhir
        $lastInfaq = Infaq::orderBy('id', 'desc')->first();
        $prefix = 'PD.';
        $date = date('dmy');
        $lastNumber = $lastInfaq ? (int) substr($lastInfaq->no_penerimaan, -3) + 1 : 1;
        $no_penerimaan = $prefix . $date . '.' . str_pad($lastNumber, 3, '0', STR_PAD_LEFT);

        return response()->json([
            'petugas' => $petugas,
            'donaturs' => $donaturs,
            'no_penerimaan' => $no_penerimaan,
        ]);
    }

    /**
     * Menampilkan data untuk form edit dalam format JSON.
     */
    public function edit(Infaq $infaq)
    {
        $petugas = User::all();
        $donaturs = Donatur::all();

        $infaq->load(['petugas', 'donatur']); // Muat relasi untuk infaq

        return response()->json([
            'infaq' => $infaq,
            'petugas' => $petugas,
            'donaturs' => $donaturs,
        ]);
    }

    /**
     * Menyimpan data infaq baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'no_penerimaan' => 'required|unique:infaqs',
            'tanggal' => 'required|date',
            'waktu' => 'required',
            'donatur_id' => 'required|exists:donaturs,id',
            'jenis_penerimaan' => 'required|string',
            'jumlah' => 'required|numeric',
        ]);

        if (auth()->check()) {
            $validated['petugas_id'] = auth()->id();
        } else {
            return response()->json(['error' => 'Anda harus login terlebih dahulu.'], 401);
        }

        $infaq = Infaq::create($validated);

        return response()->json($infaq);
    }

    /**
     * Memperbarui data infaq.
     */
    public function update(Request $request, Infaq $infaq)
    {
        $validated = $request->validate([
            'jenis_penerimaan' => 'required|string',
            'jumlah' => 'required|numeric',
        ]);

        if (auth()->check()) {
            $validated['petugas_id'] = auth()->id();
        } else {
            return response()->json(['error' => 'Anda harus login terlebih dahulu.'], 401);
        }

        $infaq->update($validated);

        return response()->json($infaq);
    }

    /**
     * Menghapus data infaq.
     */
    public function destroy(Infaq $infaq)
    {
        $infaq->delete();

        return response()->json(['message' => 'Data infaq berhasil dihapus.']);
    }

    /**
     * Laporan data infaq dalam format JSON.
     */
    public function report(Request $request)
    {
        $query = Infaq::with(['petugas', 'donatur']);

        if ($request->has('start_date') && $request->has('end_date')) {
            $query->whereBetween('tanggal', [$request->start_date, $request->end_date]);
        }

        $infaqs = $query->get();

        return response()->json($infaqs);
    }
}
