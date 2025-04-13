<?php

namespace App\Http\Controllers;

use App\Models\Penyaluran;
use App\Models\PenyaluranPenerima;
use App\Models\Mustahik;
use App\Models\Zakat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PenyaluranController extends Controller
{
    public function index()
    {
        $penyalurans = Penyaluran::with('penerimas')->get();

        // Hitung total per jenis zakat (uang)
        $zakats = Zakat::all();
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

        // Hitung total penyaluran per jenis zakat (uang)
        $penyaluranZakatFitrahUang = Penyaluran::where('jenis_zakat', 'Zakat Fitrah')->sum('total_penyaluran');
        $penyaluranZakatMal = Penyaluran::where('jenis_zakat', 'Zakat Mal')->sum('total_penyaluran');
        $penyaluranZakatFidyah = Penyaluran::where('jenis_zakat', 'Zakat Fidyah')->sum('total_penyaluran');

        // Hitung total penyaluran beras
        // Jika kolom beras_disalurkan belum ada, gunakan perhitungan dari jumlah_terima
        $totalBerasKeluar = 0;

        // Cek apakah kolom beras_disalurkan ada di tabel
        $hasBerasDisalurkanColumn = DB::getSchemaBuilder()->hasColumn('penyalurans', 'beras_disalurkan');

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

        // Total Zakat Fitrah (uang + nilai beras)
        $totalZakatFitrah = $totalZakatFitrahUang + $nilaiBerasZakatFitrah;

        // Kurangi saldo uang dengan penyaluran
        $totalZakatFitrahUang -= $penyaluranZakatFitrahUang;
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

        return view('penyaluran.index', compact(
            'penyalurans',
            'totalSaldo',
            'totalZakatFitrah',
            'totalZakatMal',
            'totalZakatFidyah',
            'totalBeras'
        ));
    }

    public function create()
    {
        // Generate nomor penyaluran otomatis
        $lastPenyaluran = Penyaluran::latest()->first();
        $lastNumber = $lastPenyaluran ? intval(substr($lastPenyaluran->no_penyaluran, -3)) : 0;
        $newNumber = $lastNumber + 1;
        $no_penyaluran = 'PY' . date('dmy') . str_pad($newNumber, 3, '0', STR_PAD_LEFT);

        $mustahiks = Mustahik::all();
        $jenis_zakats = Zakat::distinct()->pluck('jenis_zakat');

        // Hitung saldo per jenis zakat (uang)
        $zakats = Zakat::all();

        // Zakat Fitrah - Uang
        $saldoZakatFitrahUang = $zakats->where('jenis_zakat', 'Zakat Fitrah')
            ->where('jenis_bayar', 'uang')
            ->sum('jumlah_zakat');

        // Zakat Fitrah - Beras (dalam kg)
        $totalBerasMasuk = $zakats->where('jenis_zakat', 'Zakat Fitrah')
            ->where('jenis_bayar', 'beras')
            ->sum('berat_beras');

        // Hitung total penyaluran beras
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
        $saldoZakatFitrahBeras = $totalBerasMasuk - $totalBerasKeluar;
        if ($saldoZakatFitrahBeras < 0) $saldoZakatFitrahBeras = 0;

        // Nilai beras dalam bentuk uang
        $nilaiBerasZakatFitrah = $saldoZakatFitrahBeras * 14000;

        // Zakat Mal (selalu uang)
        $saldoZakatMal = $zakats->where('jenis_zakat', 'Zakat Mal')
            ->sum('jumlah_zakat');

        // Zakat Fidyah (selalu uang)
        $saldoZakatFidyah = $zakats->where('jenis_zakat', 'Zakat Fidyah')
            ->sum('jumlah_zakat');

        // Hitung total penyaluran per jenis zakat (uang)
        $penyaluranZakatFitrah = Penyaluran::where('jenis_zakat', 'Zakat Fitrah')->sum('total_penyaluran');
        $penyaluranZakatMal = Penyaluran::where('jenis_zakat', 'Zakat Mal')->sum('total_penyaluran');
        $penyaluranZakatFidyah = Penyaluran::where('jenis_zakat', 'Zakat Fidyah')->sum('total_penyaluran');

        // Kurangi saldo uang dengan penyaluran
        $saldoZakatFitrahUang -= $penyaluranZakatFitrah;
        if ($saldoZakatFitrahUang < 0) {
            // Jika saldo uang minus, kurangi dari nilai beras
            $nilaiBerasZakatFitrah += $saldoZakatFitrahUang; // Tambahkan nilai negatif
            if ($nilaiBerasZakatFitrah < 0) $nilaiBerasZakatFitrah = 0;
            $saldoZakatFitrahUang = 0;

            // Recalculate beras
            $saldoZakatFitrahBeras = $nilaiBerasZakatFitrah / 14000;
        }

        $saldoZakatMal -= $penyaluranZakatMal;
        if ($saldoZakatMal < 0) $saldoZakatMal = 0;

        $saldoZakatFidyah -= $penyaluranZakatFidyah;
        if ($saldoZakatFidyah < 0) $saldoZakatFidyah = 0;

        // Buat array saldo untuk digunakan di JavaScript
        $saldoPerJenisZakat = [
            'Zakat Fitrah' => [
                'uang' => $saldoZakatFitrahUang,
                'beras' => $saldoZakatFitrahBeras,
                'nilai_beras' => $nilaiBerasZakatFitrah,
                'total' => $saldoZakatFitrahUang + $nilaiBerasZakatFitrah
            ],
            'Zakat Mal' => [
                'uang' => $saldoZakatMal,
                'beras' => 0,
                'nilai_beras' => 0,
                'total' => $saldoZakatMal
            ],
            'Zakat Fidyah' => [
                'uang' => $saldoZakatFidyah,
                'beras' => 0,
                'nilai_beras' => 0,
                'total' => $saldoZakatFidyah
            ]
        ];

        return view('penyaluran.create', compact(
            'no_penyaluran',
            'mustahiks',
            'jenis_zakats',
            'saldoPerJenisZakat'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'no_penyaluran' => 'required|unique:penyalurans',
            'tanggal_penyaluran' => 'required|date',
            'jam_penyaluran' => 'required',
            'jenis_zakat' => 'required',
            'total_penyaluran' => 'required|integer',
            'status_penyaluran' => 'required',
            'penerimas' => 'required|array',
            'penerimas.*.no_mustahik' => 'required|exists:mustahiks,no_mustahik',
            'penerimas.*.jumlah_terima' => 'required|integer',
        ]);

        $jenisZakat = $request->jenis_zakat;
        $totalPenyaluran = $request->total_penyaluran;

        // Hitung saldo tersedia
        $zakats = Zakat::all();
        $saldoZakat = 0;

        if ($jenisZakat === 'Zakat Fitrah') {
            $saldoUang = $zakats->where('jenis_zakat', 'Zakat Fitrah')
                ->where('jenis_bayar', 'uang')
                ->sum('jumlah_zakat');

            // Hitung total beras dari tabel zakat
            $totalBerasMasuk = $zakats->where('jenis_bayar', 'beras')
                ->sum('berat_beras');

            // Hitung total penyaluran beras
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
            $saldoBeras = $totalBerasMasuk - $totalBerasKeluar;
            if ($saldoBeras < 0) $saldoBeras = 0;

            $nilaiBerasSaldo = $saldoBeras * 14000;

            $saldoZakat = $saldoUang + $nilaiBerasSaldo;
        } elseif ($jenisZakat === 'Zakat Mal') {
            $saldoZakat = $zakats->where('jenis_zakat', 'Zakat Mal')
                ->sum('jumlah_zakat');
        } elseif ($jenisZakat === 'Zakat Fidyah') {
            $saldoZakat = $zakats->where('jenis_zakat', 'Zakat Fidyah')
                ->sum('jumlah_zakat');
        }

        // Kurangi dengan penyaluran yang sudah ada
        $penyaluranSebelumnya = Penyaluran::where('jenis_zakat', $jenisZakat)->sum('total_penyaluran');
        $saldoZakat -= $penyaluranSebelumnya;

        // Hitung total yang akan disalurkan (tanpa memperhitungkan sisa 2.5%)
        $totalJumlahTerima = 0;
        foreach ($request->penerimas as $penerima) {
            $totalJumlahTerima += $penerima['jumlah_terima'];
        }

        // Cek saldo mencukupi untuk jumlah yang akan disalurkan
        if ($totalJumlahTerima > $saldoZakat) {
            return back()->with('error', 'Saldo zakat tidak mencukupi untuk penyaluran ini.');
        }

        // Hitung total beras yang akan disalurkan (dalam kg)
        $totalBerasDisalurkan = 0;
        if ($jenisZakat === 'Zakat Fitrah') {
            $totalBerasDisalurkan = $totalJumlahTerima / 14000;
        }

        DB::beginTransaction();
        try {
            // Cek apakah kolom beras_disalurkan ada di tabel
            $hasBerasDisalurkanColumn = DB::getSchemaBuilder()->hasColumn('penyalurans', 'beras_disalurkan');

            // Buat array data penyaluran
            $penyaluranData = [
                'no_penyaluran' => $request->no_penyaluran,
                'tanggal_penyaluran' => $request->tanggal_penyaluran,
                'jam_penyaluran' => $request->jam_penyaluran,
                'petugas_penyaluran' => Auth::user()->name,
                'jenis_zakat' => $request->jenis_zakat,
                'total_penyaluran' => $totalJumlahTerima, // Hanya menyimpan jumlah yang benar-benar disalurkan
                'status_penyaluran' => $request->status_penyaluran,
                'keterangan' => $request->keterangan,
            ];

            // Tambahkan beras_disalurkan jika kolom ada
            if ($hasBerasDisalurkanColumn) {
                $penyaluranData['beras_disalurkan'] = $totalBerasDisalurkan;
            }

            // Buat record penyaluran
            $penyaluran = Penyaluran::create($penyaluranData);

            // Cek apakah kolom beras_terima ada di tabel
            $hasBerasTerimaColumn = DB::getSchemaBuilder()->hasColumn('penyaluran_penerimas', 'beras_terima');

            // Create penerimas
            foreach ($request->penerimas as $penerima) {
                $jumlahTerima = $penerima['jumlah_terima'];
                $berasTerima = $jumlahTerima / 14000; // Konversi ke kg beras

                $penerimaData = [
                    'no_penyaluran' => $penyaluran->no_penyaluran,
                    'no_mustahik' => $penerima['no_mustahik'],
                    'jumlah_terima' => $jumlahTerima,
                    'status_penerima' => 'Diterima'
                ];

                // Tambahkan beras_terima jika kolom ada
                if ($hasBerasTerimaColumn) {
                    $penerimaData['beras_terima'] = $berasTerima;
                }

                PenyaluranPenerima::create($penerimaData);
            }

            DB::commit();
            return redirect()->route('penyaluran.index')
                           ->with('success', 'Data penyaluran zakat berhasil ditambahkan');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage());
        }
    }

    public function edit(Penyaluran $penyaluran)
    {
        $mustahiks = Mustahik::all();
        $jenis_zakats = Zakat::distinct()->pluck('jenis_zakat');
        return view('penyaluran.edit', compact('penyaluran', 'mustahiks', 'jenis_zakats'));
    }

    public function update(Request $request, Penyaluran $penyaluran)
    {
        $request->validate([
            'tanggal_penyaluran' => 'required|date',
            'jam_penyaluran' => 'required',
            'jenis_zakat' => 'required',
            'total_penyaluran' => 'required|integer',
            'status_penyaluran' => 'required',
            'penerimas' => 'required|array',
            'penerimas.*.no_mustahik' => 'required|exists:mustahiks,no_mustahik',
            'penerimas.*.jumlah_terima' => 'required|integer',
        ]);

        // Hitung total yang akan disalurkan (tanpa memperhitungkan sisa 2.5%)
        $totalJumlahTerima = 0;
        foreach ($request->penerimas as $penerima) {
            $totalJumlahTerima += $penerima['jumlah_terima'];
        }

        // Hitung total beras yang akan disalurkan (dalam kg)
        $totalBerasDisalurkan = 0;
        if ($request->jenis_zakat === 'Zakat Fitrah') {
            $totalBerasDisalurkan = $totalJumlahTerima / 14000;
        }

        // Validasi saldo mencukupi jika ada perubahan jumlah atau jenis zakat
        if ($penyaluran->jenis_zakat !== $request->jenis_zakat || $penyaluran->total_penyaluran !== $totalJumlahTerima) {
            $jenisZakat = $request->jenis_zakat;

            // Hitung saldo tersedia
            $zakats = Zakat::all();
            $saldoZakat = 0;

            if ($jenisZakat === 'Zakat Fitrah') {
                $saldoUang = $zakats->where('jenis_zakat', 'Zakat Fitrah')
                    ->where('jenis_bayar', 'uang')
                    ->sum('jumlah_zakat');

                // Hitung total beras dari tabel zakat
                $totalBerasMasuk = $zakats->where('jenis_bayar', 'beras')
                    ->sum('berat_beras');

                // Hitung total penyaluran beras
                $hasBerasDisalurkanColumn = DB::getSchemaBuilder()->hasColumn('penyalurans', 'beras_disalurkan');

                $totalBerasKeluar = 0;
                if ($hasBerasDisalurkanColumn) {
                    $totalBerasKeluar = Penyaluran::where('jenis_zakat', 'Zakat Fitrah')
                        ->where('no_penyaluran', '!=', $penyaluran->no_penyaluran)
                        ->sum('beras_disalurkan');
                } else {
                    // Jika kolom tidak ada, hitung dari jumlah_terima
                    $totalBerasKeluar = DB::table('penyaluran_penerimas')
                        ->join('penyalurans', 'penyaluran_penerimas.no_penyaluran', '=', 'penyalurans.no_penyaluran')
                        ->where('penyalurans.jenis_zakat', 'Zakat Fitrah')
                        ->where('penyalurans.no_penyaluran', '!=', $penyaluran->no_penyaluran)
                        ->sum(DB::raw('penyaluran_penerimas.jumlah_terima / 14000'));
                }

                // Hitung sisa beras
                $saldoBeras = $totalBerasMasuk - $totalBerasKeluar;
                if ($saldoBeras < 0) $saldoBeras = 0;

                $nilaiBerasSaldo = $saldoBeras * 14000;

                $saldoZakat = $saldoUang + $nilaiBerasSaldo;
            } elseif ($jenisZakat === 'Zakat Mal') {
                $saldoZakat = $zakats->where('jenis_zakat', 'Zakat Mal')
                    ->sum('jumlah_zakat');
            } elseif ($jenisZakat === 'Zakat Fidyah') {
                $saldoZakat = $zakats->where('jenis_zakat', 'Zakat Fidyah')
                    ->sum('jumlah_zakat');
            }

            // Kurangi dengan penyaluran yang sudah ada (kecuali penyaluran yang sedang diedit)
            $penyaluranSebelumnya = Penyaluran::where('jenis_zakat', $jenisZakat)
                ->where('no_penyaluran', '!=', $penyaluran->no_penyaluran)
                ->sum('total_penyaluran');
            $saldoZakat -= $penyaluranSebelumnya;

            // Cek saldo mencukupi
            if ($totalJumlahTerima > $saldoZakat) {
                return back()->with('error', 'Saldo zakat tidak mencukupi untuk penyaluran ini.');
            }
        }

        DB::beginTransaction();
        try {
            // Cek apakah kolom beras_disalurkan ada di tabel
            $hasBerasDisalurkanColumn = DB::getSchemaBuilder()->hasColumn('penyalurans', 'beras_disalurkan');

            // Buat array data penyaluran
            $penyaluranData = [
                'tanggal_penyaluran' => $request->tanggal_penyaluran,
                'jam_penyaluran' => $request->jam_penyaluran,
                'jenis_zakat' => $request->jenis_zakat,
                'total_penyaluran' => $totalJumlahTerima,
                'status_penyaluran' => $request->status_penyaluran,
                'keterangan' => $request->keterangan,
            ];

            // Tambahkan beras_disalurkan jika kolom ada
            if ($hasBerasDisalurkanColumn) {
                $penyaluranData['beras_disalurkan'] = $totalBerasDisalurkan;
            }

            // Update record penyaluran
            $penyaluran->update($penyaluranData);

            // Delete existing penerimas
            $penyaluran->penerimas()->delete();

            // Cek apakah kolom beras_terima ada di tabel
            $hasBerasTerimaColumn = DB::getSchemaBuilder()->hasColumn('penyaluran_penerimas', 'beras_terima');

            // Create new penerimas
            foreach ($request->penerimas as $penerima) {
                $jumlahTerima = $penerima['jumlah_terima'];
                $berasTerima = $jumlahTerima / 14000; // Konversi ke kg beras

                $penerimaData = [
                    'no_penyaluran' => $penyaluran->no_penyaluran,
                    'no_mustahik' => $penerima['no_mustahik'],
                    'jumlah_terima' => $jumlahTerima,
                    'status_penerima' => 'Diterima'
                ];

                // Tambahkan beras_terima jika kolom ada
                if ($hasBerasTerimaColumn) {
                    $penerimaData['beras_terima'] = $berasTerima;
                }

                PenyaluranPenerima::create($penerimaData);
            }

            DB::commit();
            return redirect()->route('penyaluran.index')
                           ->with('success', 'Data penyaluran zakat berhasil diperbarui');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Terjadi kesalahan saat memperbarui data: ' . $e->getMessage());
        }
    }

    public function destroy(Penyaluran $penyaluran)
    {
        $penyaluran->delete();
        return redirect()->route('penyaluran.index')
                       ->with('success', 'Data penyaluran zakat berhasil dihapus');
    }
}
