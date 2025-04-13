<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Zakat;
use App\Models\Muzakki;
use App\Models\Penyaluran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ZakatController extends Controller
{
/**
 * Display a listing of the resource.
 */
public function index(Request $request)
{
    $query = zakat::query();

    if ($request->has('search')) {
        $search = $request->search;
        $query->where(function ($q) use ($search) {
            $q->where('no_zakat', 'like', "%$search%")
                ->orWhere('petugas_penerima', 'like', "%$search%")
                ->orWhereHas('muzakki', function ($q) use ($search) {
                    $q->where('nama_muzakki', 'like', "%$search%");
                });
        });
    }

    $zakats = $query->get();

    // Hitung total per jenis zakat (uang)
    $totalZakatFitrahUang = $zakats->where('jenis_zakat', 'Zakat Fitrah')
        ->where('jenis_bayar', 'uang')
        ->sum('jumlah_zakat');

    $totalZakatMal = $zakats->where('jenis_zakat', 'Zakat Mal')
        ->sum('jumlah_zakat');

    $totalZakatFidyah = $zakats->where('jenis_zakat', 'Zakat Fidyah')
        ->sum('jumlah_zakat');

    // Hitung total beras dari tabel zakat
    $totalBerasMasuk = $zakats->where('jenis_bayar', 'beras')
        ->sum('berat_beras');

    // Hitung total penyaluran beras
    // Cek apakah kolom beras_disalurkan ada di tabel
    $hasBerasDisalurkanColumn = DB::getSchemaBuilder()->hasColumn('penyalurans', 'beras_disalurkan');

    $totalBerasKeluar = 0;
    if ($hasBerasDisalurkanColumn) {
        $totalBerasKeluar = Penyaluran::where('jenis_zakat', 'Zakat Fitrah')->sum('beras_disalurkan');
    } else {
        // Jika kolom tidak ada, hitung dari jumlah_terima
        $totalBerasKeluar = DB::table('penyaluran_penerimas')
            ->join('penyalurans', 'penyaluran_penerimas.no_penyaluran', '=', 'penyalurans.no_penyaluran')
            ->where('penyalurans.jenis_zakat', 'Zakat Fitrah')
            ->sum(DB::raw('penyaluran_penerimas.jumlah_terima / 14000'));
    }

    // Hitung sisa beras
    $totalBeras = $totalBerasMasuk - $totalBerasKeluar;
    if ($totalBeras < 0) $totalBeras = 0;

    // Nilai beras dalam bentuk uang
    $nilaiBerasZakatFitrah = $totalBeras * 14000;

    // Hitung total penyaluran per jenis zakat (uang)
    $penyaluranZakatFitrah = Penyaluran::where('jenis_zakat', 'Zakat Fitrah')->sum('total_penyaluran');
    $penyaluranZakatMal = Penyaluran::where('jenis_zakat', 'Zakat Mal')->sum('total_penyaluran');
    $penyaluranZakatFidyah = Penyaluran::where('jenis_zakat', 'Zakat Fidyah')->sum('total_penyaluran');

    // Total Zakat Fitrah (uang + nilai beras)
    $totalZakatFitrah = $totalZakatFitrahUang + $nilaiBerasZakatFitrah;

    // Kurangi saldo uang dengan penyaluran
    $totalZakatFitrahUang -= $penyaluranZakatFitrah;
    if ($totalZakatFitrahUang < 0) {
        // Jika saldo uang minus, kurangi dari nilai beras
        $nilaiBerasZakatFitrah += $totalZakatFitrahUang; // Tambahkan nilai negatif
        $totalZakatFitrahUang = 0;
    }

    // Recalculate total zakat fitrah
    $totalZakatFitrah = $totalZakatFitrahUang + $nilaiBerasZakatFitrah;
    if ($totalZakatFitrah < 0) $totalZakatFitrah = 0;

    $totalZakatMal -= $penyaluranZakatMal;
    if ($totalZakatMal < 0) $totalZakatMal = 0;

    $totalZakatFidyah -= $penyaluranZakatFidyah;
    if ($totalZakatFidyah < 0) $totalZakatFidyah = 0;

    // Total saldo keseluruhan setelah dikurangi penyaluran
    $totalSaldo = $totalZakatFitrah + $totalZakatMal + $totalZakatFidyah;

    return view('zakat.index', compact(
        'zakats',
        'totalSaldo',
        'totalZakatFitrah',
        'totalZakatMal',
        'totalZakatFidyah',
        'totalBeras'
    ));
}

// Metode lainnya tetap sama
/**
 * Show the form for creating a new resource.
 */
public function create()
{
    // Generate nomor zakat otomatis
    $lastZakat = Zakat::latest()->first();
    $lastNumber = $lastZakat ? intval(substr($lastZakat->no_zakat, -3)) : 0;
    $newNumber = $lastNumber + 1;
    $no_zakat = 'ZK' . date('dmy') . str_pad($newNumber, 3, '0', STR_PAD_LEFT);

    $muzakkis = Muzakki::all();
    return view('zakat.create', compact('no_zakat', 'muzakkis'));
}

/**
 * Store a newly created resource in storage.
 */
public function store(Request $request)
{
    $request->validate([
        'no_zakat' => 'required|unique:zakats',
        'tanggal_zakat' => 'required|date',
        'jam_zakat' => 'required',
        'no_muzakki' => 'required|exists:muzakkis,no_muzakki',
        'jenis_zakat' => 'required',
        'jumlah_zakat' => 'required|numeric',
        'jenis_bayar' => 'required|in:uang,beras'
    ]);

    $data = $request->all();
    $data['petugas_penerima'] = Auth::user()->name;

    // Calculate berat_beras if jenis_bayar is beras
    if ($request->jenis_bayar === 'beras') {
        // Convert amount to kg (14000 per kg)
        $data['berat_beras'] = $request->jumlah_zakat / 14000;
    }

    Zakat::create($data);
    return redirect()->route('zakat.index')->with('success', 'Data zakat berhasil ditambahkan');
}

/**
 * Display the specified resource.
 */
public function show(zakat $zakat)
{
    //
}

/**
 * Show the form for editing the specified resource.
 */
public function edit(Zakat $zakat)
{
    $muzakkis = Muzakki::all();
    return view('zakat.edit', compact('zakat', 'muzakkis'));
}

/**
 * Update the specified resource in storage.
 */
public function update(Request $request, Zakat $zakat)
{
    $request->validate([
        'jenis_zakat' => 'required',
        'jumlah_zakat' => 'required|integer'
    ]);

    $zakat->update($request->only(['jenis_zakat', 'jumlah_zakat']));
    return redirect()->route('zakat.index')->with('success', 'Data zakat berhasil diperbarui');
}

/**
 * Remove the specified resource from storage.
 */
public function destroy(Zakat $zakat)
{
    $zakat->delete();
    return redirect()->route('zakat.index')->with('success', 'Data zakat berhasil dihapus');
}

public function report(Request $request)
{
    $query = Zakat::query();

    if ($request->has(['start_date', 'end_date'])) {
        $query->whereBetween('tanggal_zakat', [$request->start_date, $request->end_date]);
    }

    $zakats = $query->get();
    return view('zakat.report', compact('zakats'));
}

public function generatePdf(Request $request)
{
    $query = Zakat::query();

    if ($request->has(['start_date', 'end_date'])) {
        $query->whereBetween('tanggal_zakat', [$request->start_date, $request->end_date]);
    }

    $zakats = $query->get();
    $pdf = PDF::loadView('zakat.pdf_report', compact('zakats'));
    return $pdf->download('laporan_zakat.pdf');
}
}
