<?php

namespace App\Http\Controllers;

use App\Models\PenerimaQurban;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class PenerimaQurbanController extends Controller
{
    public function index(Request $request)
    {
        $query = PenerimaQurban::query();

        if ($request->filled('rt')) {
            $query->where('rt', 'like', '%' . $request->rt . '%');
        }

        if ($request->filled('rw')) {
            $query->where('rw', 'like', '%' . $request->rw . '%');
        }

        $penerima = $query->get();
        return view('penerima-qurban.index', compact('penerima'));
    }

    public function create()
    {
        return view('penerima-qurban.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nik' => 'required',
            'nama' => 'required',
            'tahun_hijriah' => 'required',
            'status' => 'required|in:Personal,Yayasan',
            'alamat' => 'required',
            'rt' => 'required',
            'rw' => 'required',
        ]);

        $validated['role'] = 'qurban';

        PenerimaQurban::create($validated);

        return redirect()->route('penerima-qurban.index')
            ->with('success', 'Data penerima qurban berhasil ditambahkan');
    }

    public function edit(PenerimaQurban $penerima_qurban)
    {
        return view('penerima-qurban.edit', compact('penerima_qurban'));
    }

    public function update(Request $request, PenerimaQurban $penerima_qurban)
    {
        $validated = $request->validate([
            'nik' => 'required',
            'nama' => 'required',
            'tahun_hijriah' => 'required',
            'status' => 'required|in:Personal,Yayasan',
            'alamat' => 'required',
            'rt' => 'required',
            'rw' => 'required',
        ]);

        $penerima_qurban->update($validated);

        return redirect()->route('penerima-qurban.index')
            ->with('success', 'Data penerima qurban berhasil diperbarui');
    }

    public function destroy(PenerimaQurban $penerima_qurban)
    {
        $penerima_qurban->delete();
        return redirect()->route('penerima-qurban.index')
            ->with('success', 'Data penerima qurban berhasil dihapus');
    }

    public function report(Request $request)
{
    $query = PenerimaQurban::query();

    // Apply filters
    if ($request->filled('rt')) {
        $query->where('rt', $request->rt);
    }
    if ($request->filled('rw')) {
        $query->where('rw', $request->rw);
    }
    if ($request->filled('tahun_hijriah')) {
        $query->where('tahun_hijriah', $request->tahun_hijriah);
    }
    if ($request->filled('status')) {
        $query->where('status', $request->status);
    }

    // Get unique values for filters
    $years = PenerimaQurban::distinct()->pluck('tahun_hijriah');
    $rts = PenerimaQurban::distinct()->pluck('rt');
    $rws = PenerimaQurban::distinct()->pluck('rw');

    // Get data grouped by RT/RW
    $penerimas = $query->orderBy('rw')->orderBy('rt')->get();

    return view('penerima-qurban.report', compact('penerimas', 'years', 'rts', 'rws'));
}

    public function exportPdf(Request $request)
    {
        $query = PenerimaQurban::query();

        // Apply filters
        if ($request->filled('rt')) {
            $query->where('rt', $request->rt);
        }
        if ($request->filled('rw')) {
            $query->where('rw', $request->rw);
        }
        if ($request->filled('tahun_hijriah')) {
            $query->where('tahun_hijriah', $request->tahun_hijriah);
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $penerimas = $query->orderBy('rw')->orderBy('rt')->get();

        $pdf = PDF::loadView('penerima-qurban.report-pdf', compact('penerimas'));

        // Set paper size to A4 and landscape orientation
        $pdf->setPaper('A4', 'landscape');

        // Set options for better quality
        $pdf->setOption('enable-local-file-access', true);

        return $pdf->download('laporan-distribusi-qurban-' . date('Y-m-d') . '.pdf');
    }
}

