<?php

namespace App\Http\Controllers;

use App\Models\ShohibulQurban;
use App\Models\ShohibulQurbanDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;

class ShohibulQurbanController extends Controller
{
    public function index(Request $request)
    {
        $query = ShohibulQurban::with('details');

        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama', 'like', "%$search%")
                  ->orWhere('nik', 'like', "%$search%");
            });
        }

        $shohibulQurbans = $query->latest()->get();
        return view('shohibul-qurban.index', compact('shohibulQurbans'));
    }

    public function create()
    {
        return view('shohibul-qurban.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'tahun_hijriah' => 'required',
            'nik' => 'required',
            'nama' => 'required',
            'hp' => 'required',
            'alamat' => 'required',
            'jenis_hewan' => 'required',
            'berat' => 'required|numeric',
            'bagian_diminta' => 'required',
            'tanggal' => 'required|date',
            'atas_nama' => 'required|array|min:1',
            'atas_nama.*.nama' => 'required',
            'atas_nama.*.bin_or_binti' => 'required',
            'atas_nama.*.bin_or_binti_value' => 'required',
        ]);

        // Generate UUID for main record
        $id = (string) Str::uuid();

        $shohibulQurban = ShohibulQurban::create([
            'id' => $id,
            'tahun_hijriah' => $request->tahun_hijriah,
            'nik' => $request->nik,
            'nama' => $request->nama,
            'hp' => $request->hp,
            'alamat' => $request->alamat,
            'jenis_hewan' => $request->jenis_hewan,
            'berat' => $request->berat,
            'bagian_diminta' => $request->bagian_diminta,
            'tanggal' => $request->tanggal,
        ]);

        // Create details with UUID for each
        foreach ($request->atas_nama as $atasNama) {
            ShohibulQurbanDetail::create([
                'id' => (string) Str::uuid(),
                'sq_id' => $id,
                'nama' => $atasNama['nama'],
                'bin_or_binti' => $atasNama['bin_or_binti'],
                'bin_or_binti_value' => $atasNama['bin_or_binti_value'],
            ]);
        }

        return redirect()->route('shohibul-qurban.index')
            ->with('success', 'Data Shohibul Qurban berhasil ditambahkan');
    }

    public function edit(ShohibulQurban $shohibulQurban)
    {
        $shohibulQurban->load('details');
        return view('shohibul-qurban.edit', compact('shohibulQurban'));
    }

    public function update(Request $request, ShohibulQurban $shohibulQurban)
    {
        $request->validate([
            'tahun_hijriah' => 'required',
            'nik' => 'required',
            'nama' => 'required',
            'hp' => 'required',
            'alamat' => 'required',
            'jenis_hewan' => 'required',
            'berat' => 'required|numeric',
            'bagian_diminta' => 'required',
            'tanggal' => 'required|date',
            'atas_nama' => 'required|array|min:1',
            'atas_nama.*.nama' => 'required',
            'atas_nama.*.bin_or_binti' => 'required',
            'atas_nama.*.bin_or_binti_value' => 'required',
        ]);

        // Update main record
        $shohibulQurban->update([
            'tahun_hijriah' => $request->tahun_hijriah,
            'nik' => $request->nik,
            'nama' => $request->nama,
            'hp' => $request->hp,
            'alamat' => $request->alamat,
            'jenis_hewan' => $request->jenis_hewan,
            'berat' => $request->berat,
            'bagian_diminta' => $request->bagian_diminta,
            'tanggal' => $request->tanggal,
        ]);

        // Delete existing details
        $shohibulQurban->details()->delete();

        // Create new details with UUID for each
        foreach ($request->atas_nama as $atasNama) {
            ShohibulQurbanDetail::create([
                'id' => (string) Str::uuid(),
                'sq_id' => $shohibulQurban->id,
                'nama' => $atasNama['nama'],
                'bin_or_binti' => $atasNama['bin_or_binti'],
                'bin_or_binti_value' => $atasNama['bin_or_binti_value'],
            ]);
        }

        return redirect()->route('shohibul-qurban.index')
            ->with('success', 'Data Shohibul Qurban berhasil diperbarui');
    }

    public function destroy(ShohibulQurban $shohibulQurban)
    {
        // Delete details first
        $shohibulQurban->details()->delete();
        // Then delete main record
        $shohibulQurban->delete();

        return redirect()->route('shohibul-qurban.index')
            ->with('success', 'Data Shohibul Qurban berhasil dihapus');
    }

    public function report(Request $request)
    {
        $query = ShohibulQurban::with('details');

        if ($request->tahun_hijriah) {
            $query->where('tahun_hijriah', $request->tahun_hijriah);
        }

        if ($request->start_date && $request->end_date) {
            $query->whereBetween('tanggal', [$request->start_date, $request->end_date]);
        }

        if ($request->jenis_hewan) {
            $query->where('jenis_hewan', $request->jenis_hewan);
        }

        $shohibuls = $query->latest()->get();
        $years = ShohibulQurban::distinct()->pluck('tahun_hijriah');

        return view('shohibul-qurban.report', compact('shohibuls', 'years'));
    }

    public function exportPdf(Request $request)
    {
        $query = ShohibulQurban::with('details');

        if ($request->tahun_hijriah) {
            $query->where('tahun_hijriah', $request->tahun_hijriah);
        }
        if ($request->start_date && $request->end_date) {
            $query->whereBetween('tanggal', [$request->start_date, $request->end_date]);
        }
        if ($request->jenis_hewan) {
            $query->where('jenis_hewan', $request->jenis_hewan);
        }

        $shohibuls = $query->latest()->get();

        $pdf = PDF::loadView('shohibul-qurban.report-pdf', compact('shohibuls'));

        // Set paper size to A4 and landscape orientation
        $pdf->setPaper('A4', 'landscape');

        // Set options for better quality
        $pdf->setOption('enable-local-file-access', true);
        $pdf->setOption('image-quality', 100);
        $pdf->setOption('enable-javascript', true);
        $pdf->setOption('javascript-delay', 1000);

        return $pdf->download('laporan-shohibul-qurban-'.date('Y-m-d').'.pdf');
    }

    public function laporanHewan(Request $request)
{
    $query = ShohibulQurban::with('details');

    if ($request->tahun_hijriah) {
        $query->where('tahun_hijriah', $request->tahun_hijriah);
    }

    if ($request->jenis_hewan) {
        $query->where('jenis_hewan', $request->jenis_hewan);
    }

    $shohibuls = $query->latest()->get();
    $years = ShohibulQurban::distinct()->pluck('tahun_hijriah');

    return view('shohibul-qurban.laporan-hewan', compact('shohibuls', 'years'));
}

    public function laporanHewanPdf(Request $request)
    {
        $query = ShohibulQurban::with('details');

        if ($request->tahun_hijriah) {
            $query->where('tahun_hijriah', $request->tahun_hijriah);
        }

        if ($request->jenis_hewan) {
            $query->where('jenis_hewan', $request->jenis_hewan);
        }

        $shohibuls = $query->latest()->get();

        $pdf = PDF::loadView('shohibul-qurban.laporan-hewan-pdf', compact('shohibuls'));
        $pdf->setPaper('A4', 'portrait');

        return $pdf->download('laporan-hewan-qurban-' . date('Y-m-d') . '.pdf');
    }

    public function nametagHewan(Request $request)
{
    $query = ShohibulQurban::with('details');

    if ($request->tahun_hijriah) {
        $query->where('tahun_hijriah', $request->tahun_hijriah);
    }

    if ($request->jenis_hewan) {
        $query->where('jenis_hewan', $request->jenis_hewan);
    }

    $shohibuls = $query->latest()->get();
    $years = ShohibulQurban::distinct()->pluck('tahun_hijriah');

    return view('shohibul-qurban.nametag-hewan', compact('shohibuls', 'years'));
}

    public function nametagHewanPdf(Request $request)
    {
        $query = ShohibulQurban::with('details');

        if ($request->tahun_hijriah) {
            $query->where('tahun_hijriah', $request->tahun_hijriah);
        }

        if ($request->jenis_hewan) {
            $query->where('jenis_hewan', $request->jenis_hewan);
        }

        $shohibuls = $query->latest()->get();

        $pdf = PDF::loadView('shohibul-qurban.nametag-hewan-pdf', compact('shohibuls'));

        // Set paper size to A4
        $pdf->setPaper('A4', 'portrait');

        // Set better quality options
        $pdf->setOption('enable-local-file-access', true);
        $pdf->setOption('margin-top', 5);
        $pdf->setOption('margin-right', 5);
        $pdf->setOption('margin-bottom', 5);
        $pdf->setOption('margin-left', 5);

        return $pdf->download('nametag-hewan-qurban-' . date('Y-m-d') . '.pdf');
    }
}
