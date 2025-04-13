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
     * Menampilkan daftar infaq.
     */
    public function index(Request $request)
    {
        $query = Infaq::query();

        if ($request->has('search') && $request->search) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('no_penerimaan', 'like', "%$searchTerm%")
                  ->orWhereHas('petugas', function($q) use ($searchTerm) {
                      $q->where('name', 'like', "%$searchTerm%");
                  })
                  ->orWhereHas('donatur', function($q) use ($searchTerm) {
                      $q->where('nama', 'like', "%$searchTerm%");
                  })
                  ->orWhere('jenis_penerimaan', 'like', "%$searchTerm%");
            });
        }

        // Filter berdasarkan status jika diperlukan
        if ($request->has('status') && $request->status != 'all') {
            $query->where('status', $request->status);
        }

        $infaqs = $query->get();

        // Hitung total infaq dengan status success ONLY
        $totalInfaq = Infaq::where('status', 'success')->sum('jumlah');

        // Hitung jumlah dan total berdasarkan status
        $statusSummary = [
            'success' => [
                'count' => Infaq::where('status', 'success')->count(),
                'total' => Infaq::where('status', 'success')->sum('jumlah')
            ],
            'pending' => [
                'count' => Infaq::where('status', 'pending')->count(),
                'total' => Infaq::where('status', 'pending')->sum('jumlah')
            ],
            'failed' => [
                'count' => Infaq::whereIn('status', ['failed', 'denied', 'expired', 'canceled'])->count(),
                'total' => Infaq::whereIn('status', ['failed', 'denied', 'expired', 'canceled'])->sum('jumlah')
            ]
        ];

        return view('infaq.index', compact('infaqs', 'totalInfaq', 'statusSummary'));
    }


    /**
     * Menampilkan form untuk menambah data infaq.
     */
    public function create()
    {
        // Ambil data petugas dan donatur
        $petugas = User::all();
        $donaturs = Donatur::all();

        // Ambil nomor penerimaan terakhir
        $lastInfaq = Infaq::orderBy('id', 'desc')->first();

        // Tentukan nomor penerimaan otomatis
        $prefix = 'PD.';
        $date = date('dmy'); // Format tanggal: ddmmYY
        $lastNumber = 1; // Default jika tidak ada data sebelumnya

        if ($lastInfaq) {
            // Ambil nomor terakhir dan ekstrak angka urutnya
            $lastNumber = (int) substr($lastInfaq->no_penerimaan, -3) + 1;
        }

        // Format nomor penerimaan dengan menambahkan 3 digit angka urut
        $no_penerimaan = $prefix . $date . '.' . str_pad($lastNumber, 3, '0', STR_PAD_LEFT);

        return view('infaq.create', compact('petugas', 'donaturs', 'no_penerimaan'));
    }

    /**
     * Menyimpan data infaq.
     */
    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'no_penerimaan' => 'required|unique:infaqs',
            'tanggal' => 'required|date',
            'waktu' => 'required',
            'donatur_id' => 'required|exists:donaturs,id',
            'jenis_penerimaan' => 'required|string',
            'jumlah' => 'required|numeric',
            'status' => 'nullable|string',
        ]);

        // Pastikan user sudah login
        if (auth()->check()) {
            $validated['petugas_id'] = auth()->id(); // ID petugas yang login
        } else {
            return redirect()->route('login')->with('error', 'Anda harus login terlebih dahulu.');
        }

        // Set status default jika tidak ada
        if (!isset($validated['status'])) {
            $validated['status'] = 'success'; // Default status untuk input manual
        }

        // Simpan data infaq baru
        Infaq::create($validated);

        return redirect()->route('infaq.index')->with('success', 'Data infaq berhasil ditambahkan.');
    }

    /**
     * Menampilkan form untuk mengedit data infaq.
     */
    public function edit(Infaq $infaq)
    {
        // Ambil data petugas dan donatur
        $petugas = User::all();
        $donaturs = Donatur::all();

        return view('infaq.edit', compact('infaq', 'petugas', 'donaturs'));
    }

    /**
     * Mengupdate data infaq.
     */
    public function update(Request $request, Infaq $infaq)
    {
        // Validasi input, hanya memperbolehkan field tertentu untuk diubah
        $validated = $request->validate([
            'jenis_penerimaan' => 'required|string',
            'jumlah' => 'required|numeric',
            'status' => 'nullable|string', // Tambahkan status sebagai field yang dapat diubah
        ]);

        // Pastikan user sudah login
        if (auth()->check()) {
            $validated['petugas_id'] = auth()->id(); // ID petugas yang login
        } else {
            return redirect()->route('login')->with('error', 'Anda harus login terlebih dahulu.');
        }

        // Update infaq
        $infaq->update($validated);

        // Redirect dengan pesan sukses
        return redirect()->route('infaq.index')->with('success', 'Data infaq berhasil diupdate.');
    }

    /**
     * Menghapus data infaq.
     */
    public function destroy(Infaq $infaq)
    {
        // Hapus data infaq
        $infaq->delete();

        // Redirect dengan pesan sukses
        return redirect()->route('infaq.index')->with('success', 'Data infaq berhasil dihapus.');
    }

    /**
     * Halaman laporan infaq.
     */
    public function report(Request $request)
    {
        $query = Infaq::query();

        // Apply date range filter
        if ($request->has('start_date') && $request->has('end_date')) {
            $startDate = $request->start_date;
            $endDate = $request->end_date;
            $query->whereBetween('tanggal', [$startDate, $endDate]);
        }

        // Filter berdasarkan status
        if ($request->has('status') && $request->status != 'all') {
            $query->where('status', $request->status);
        } else {
            // Default hanya tampilkan yang status success untuk laporan
            $query->where('status', 'success');
        }

        $infaqs = $query->get();

        // Hitung total untuk infaq dengan status success saja
        $totalAmount = $query->sum('jumlah');

        return view('infaq.report', compact('infaqs', 'totalAmount'));
    }

    /**
     * Generate laporan PDF.
     */
    public function generatePdfReport(Request $request)
    {
        $query = Infaq::query();

        // Filter berdasarkan tanggal
        if ($request->has('start_date') && $request->has('end_date')) {
            $query->whereBetween('tanggal', [$request->start_date, $request->end_date]);
        }

        // Filter berdasarkan jenis penerimaan
        if ($request->has('jenis_penerimaan') && $request->jenis_penerimaan != 'all') {
            $query->where('jenis_penerimaan', $request->jenis_penerimaan);
        }

        // Filter berdasarkan status
        if ($request->has('status') && $request->status != 'all') {
            $query->where('status', $request->status);
        } else {
            // Default hanya tampilkan yang status success untuk laporan
            $query->where('status', 'success');
        }

        $infaqs = $query->get();

        // Generate PDF
        $pdf = PDF::loadView('infaq.pdf_report', compact('infaqs'));
        return $pdf->download('laporan_infaq.pdf');
    }

    /**
     * Mendapatkan total infaq berdasarkan status (untuk frontend).
     */
    public function getTotalInfaq()
    {
        // Menghitung total infaq dengan status 'success' saja
        return Infaq::where('status', 'success')->sum('jumlah');
    }

    /**
     * Dashboard status infaq.
     */
    public function dashboard()
    {
        // Ringkasan jumlah dan total berdasarkan status
        $successTotal = Infaq::where('status', 'success')->sum('jumlah');
        $successCount = Infaq::where('status', 'success')->count();

        $pendingTotal = Infaq::where('status', 'pending')->sum('jumlah');
        $pendingCount = Infaq::where('status', 'pending')->count();

        $failedTotal = Infaq::whereIn('status', ['failed', 'denied', 'expired', 'canceled'])->sum('jumlah');
        $failedCount = Infaq::whereIn('status', ['failed', 'denied', 'expired', 'canceled'])->count();

        // Infaq terbaru
        $recentInfaqs = Infaq::with('donatur')
                            ->orderBy('created_at', 'desc')
                            ->limit(10)
                            ->get();

        return view('infaq.dashboard', compact(
            'successTotal', 'successCount',
            'pendingTotal', 'pendingCount',
            'failedTotal', 'failedCount',
            'recentInfaqs'
        ));
    }
}
