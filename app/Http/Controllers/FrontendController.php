<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sholat;
use App\Models\Kajian;
use App\Models\Inventory;
use App\Models\Donatur;
use App\Models\Infaq;

class FrontendController extends Controller
{
    /**
     * Menampilkan jadwal sholat, kajian, dan form infaq di halaman frontend.
     */
    public function index()
    {
        // Ambil semua data jadwal sholat dari database
        $sholats = Sholat::orderBy('id', 'asc')->get();

        // Ambil semua data kajian dari database
        $kajians = Kajian::orderBy('tanggal_kajian', 'desc')->get();

        // Ambil semua data inventory
        $inventories = Inventory::all();

        // Ambil semua data donatur untuk dropdown di form infaq
        $donaturs = Donatur::all();

        // Calculate total infaq balance - ONLY count successful payments
        $totalInfaq = Infaq::where('status', 'success')->sum('jumlah');

        // Generate nomor penerimaan otomatis untuk form infaq
        $lastInfaq = Infaq::orderBy('id', 'desc')->first();
        $prefix = 'PD.';
        $date = date('dmy'); // Format tanggal: ddmmYY
        $lastNumber = 1; // Default jika tidak ada data sebelumnya

        if ($lastInfaq) {
            // Ambil nomor terakhir dan ekstrak angka urutnya
            $lastNumber = (int) substr($lastInfaq->no_penerimaan, -3) + 1;
        }

        // Format nomor penerimaan dengan menambahkan 3 digit angka urut
        $no_penerimaan = $prefix . $date . '.' . str_pad($lastNumber, 3, '0', STR_PAD_LEFT);

        // Set Midtrans client key for frontend
        $midtransClientKey = config('midtrans.client_key');

        // Kirim data ke view
        return view('dashboard', compact('sholats', 'kajians', 'inventories', 'donaturs', 'no_penerimaan', 'totalInfaq', 'midtransClientKey'));
    }

    /**
     * Menyimpan data infaq dari form di halaman frontend.
     */
    public function storeInfaq(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'no_penerimaan' => 'required|unique:infaqs',
            'tanggal' => 'required|date',
            'waktu' => 'required',
            'donatur_id' => 'required|exists:donaturs,id',
            'jenis_penerimaan' => 'required|string',
            'jumlah' => 'required|numeric',
        ]);

        // For manual entries (not through payment gateway), set status to success
        // For online payments, this should be handled by the payment gateway callback
        if ($validated['jenis_penerimaan'] === 'Online') {
            // For online payments, set initial status to pending
            $status = 'pending';
        } else {
            // For manual entries (cash, etc.), set status to success
            $status = 'success';
        }

        // Simpan data infaq baru
        Infaq::create(array_merge($validated, ['status' => $status]));

        return redirect()->route('dashboard')->with('success', 'Terima kasih atas infaq Anda. Data infaq berhasil disimpan.');
    }
}
