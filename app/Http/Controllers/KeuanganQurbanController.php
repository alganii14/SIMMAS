<?php

namespace App\Http\Controllers;

use App\Models\KeuanganQurban;
use App\Models\TabunganQurban;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;

class KeuanganQurbanController extends Controller
{
    public function index()
    {
        $saldoTabungan = TabunganQurban::getTotalSaldo();
        $saldoKeuangan = KeuanganQurban::getSaldo();
        $totalSaldo = $saldoTabungan + $saldoKeuangan;
        $transaksi = KeuanganQurban::latest()->get();

        return view('keuangan-qurban.index', compact('saldoTabungan', 'saldoKeuangan', 'totalSaldo', 'transaksi'));
    }

    public function create()
    {
        return view('keuangan-qurban.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'jenis' => 'required|in:Masuk,Keluar',
            'jumlah' => 'required|numeric|min:0',
            'tanggal' => 'required|date',
            'keterangan' => 'nullable|string',
        ]);

        $noTransaksi = KeuanganQurban::generateNoTransaksi($request->jenis);

        KeuanganQurban::create([
            'id' => (string) Str::uuid(),
            'no_transaksi' => $noTransaksi,
            'tanggal' => $request->tanggal,
            'jenis' => $request->jenis,
            'jumlah' => $request->jumlah,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->route('keuangan-qurban.index')
            ->with('success', 'Transaksi berhasil disimpan');
    }

    public function edit($id)
    {
        $keuangan = KeuanganQurban::findOrFail($id);
        return view('keuangan-qurban.edit', compact('keuangan'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'jenis' => 'required|in:Masuk,Keluar',
            'jumlah' => 'required|numeric|min:0',
            'tanggal' => 'required|date',
            'keterangan' => 'nullable|string',
        ]);

        $keuangan = KeuanganQurban::findOrFail($id);
        $keuangan->update([
            'jenis' => $request->jenis,
            'jumlah' => $request->jumlah,
            'tanggal' => $request->tanggal,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->route('keuangan-qurban.index')
            ->with('success', 'Transaksi berhasil diperbarui');
    }

    public function destroy($id)
    {
        $keuangan = KeuanganQurban::findOrFail($id);
        $keuangan->delete();

        return redirect()->route('keuangan-qurban.index')
            ->with('success', 'Transaksi berhasil dihapus');
    }

    public function laporan(Request $request)
    {
        $query = KeuanganQurban::query();

        if ($request->filled(['tanggal_mulai', 'tanggal_akhir'])) {
            $query->whereBetween('tanggal', [
                $request->tanggal_mulai,
                $request->tanggal_akhir
            ]);
        }

        $transaksi = $query->get();
        $totalMasuk = $transaksi->where('jenis', 'Masuk')->sum('jumlah');
        $totalKeluar = $transaksi->where('jenis', 'Keluar')->sum('jumlah');
        $saldoKeuangan = $totalMasuk - $totalKeluar;
        $saldoTabungan = TabunganQurban::getTotalSaldo();
        $totalSaldo = $saldoKeuangan + $saldoTabungan;

        if ($request->type === 'pdf') {
            $pdf = PDF::loadView('keuangan-qurban.laporan-pdf', compact(
                'transaksi',
                'totalMasuk',
                'totalKeluar',
                'saldoKeuangan',
                'saldoTabungan',
                'totalSaldo'
            ));
            return $pdf->download('laporan-keuangan-qurban.pdf');
        }

        return view('keuangan-qurban.laporan', compact(
            'transaksi',
            'totalMasuk',
            'totalKeluar',
            'saldoKeuangan',
            'saldoTabungan',
            'totalSaldo'
        ));
    }
}
