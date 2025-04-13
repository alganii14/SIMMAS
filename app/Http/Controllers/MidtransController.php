<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Infaq;
use App\Models\Donatur;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class MidtransController extends Controller
{
    /**
     * Create a new Midtrans transaction
     */
    public function createTransaction(Request $request)
    {
        // Validate input
        $validated = $request->validate([
            'donatur_id' => 'required|exists:donaturs,id',
            'jumlah' => 'required|numeric|min:1000',
            'jenis_penerimaan' => 'required|string',
        ]);

        // Get donatur data
        $donatur = Donatur::findOrFail($validated['donatur_id']);

        // Generate nomor penerimaan yang lebih unik
        $prefix = 'PD.';
        $date = date('dmy'); // Format tanggal: ddmmYY

        // Tambahkan timestamp dan random string untuk memastikan keunikan
        $uniqueId = time() . Str::random(3);
        $lastNumber = substr($uniqueId, -6); // Ambil 6 digit terakhir

        $no_penerimaan = $prefix . $date . '.' . $lastNumber;

        // Pastikan order_id benar-benar unik dengan melakukan pengecekan
        while (Infaq::where('no_penerimaan', $no_penerimaan)->exists()) {
            $uniqueId = time() . Str::random(3);
            $lastNumber = substr($uniqueId, -6);
            $no_penerimaan = $prefix . $date . '.' . $lastNumber;
        }

        // Set your Merchant Server Key
        \Midtrans\Config::$serverKey = config('midtrans.server_key');
        // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
        \Midtrans\Config::$isProduction = config('midtrans.is_production');
        // Set sanitization on (default)
        \Midtrans\Config::$isSanitized = config('midtrans.is_sanitized');
        // Set 3DS transaction for credit card to true
        \Midtrans\Config::$is3ds = config('midtrans.is_3ds');

        // Create transaction parameters
        $params = [
            'transaction_details' => [
                'order_id' => $no_penerimaan,
                'gross_amount' => (int)$validated['jumlah'],
            ],
            'customer_details' => [
                'first_name' => $donatur->nama,
                'email' => $donatur->email ?? 'infaq@masjidkhairulamal.com',
                'phone' => $donatur->no_telepon ?? '',
            ],
            'item_details' => [
                [
                    'id' => 'infaq-1',
                    'price' => (int)$validated['jumlah'],
                    'quantity' => 1,
                    'name' => 'Infaq Masjid Khairul Amal',
                ],
            ],
            // Add callbacks
            'callbacks' => [
                'finish' => route('midtrans.finish'),
            ],
        ];

        try {
            // Get Snap Payment Page URL
            $snapToken = \Midtrans\Snap::getSnapToken($params);

            // Save transaction to database with pending status
            $infaq = new Infaq();
            $infaq->no_penerimaan = $no_penerimaan;
            $infaq->tanggal = date('Y-m-d');
            $infaq->waktu = date('H:i:s');
            $infaq->donatur_id = $validated['donatur_id'];
            $infaq->jenis_penerimaan = $validated['jenis_penerimaan'];
            $infaq->jumlah = $validated['jumlah'];
            $infaq->status = 'pending'; // Always set initial status to pending
            $infaq->snap_token = $snapToken;
            $infaq->save();

            // Log the successful token generation
            Log::info('Snap Token generated successfully: ' . $snapToken . ' for order: ' . $no_penerimaan);

            return response()->json([
                'status' => 'success',
                'snap_token' => $snapToken,
                'redirect_url' => route('midtrans.payment', ['id' => $infaq->id])
            ]);
        } catch (\Exception $e) {
            Log::error('Midtrans Error: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat memproses pembayaran: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Show payment page
     */
    public function showPaymentPage($id)
    {
        $infaq = Infaq::findOrFail($id);
        $donatur = Donatur::findOrFail($infaq->donatur_id);

        // Check if the snap token is still valid
        if (!$infaq->snap_token) {
            // If no token, regenerate it
            try {
                // Set your Merchant Server Key
                \Midtrans\Config::$serverKey = config('midtrans.server_key');
                \Midtrans\Config::$isProduction = config('midtrans.is_production');
                \Midtrans\Config::$isSanitized = config('midtrans.is_sanitized');
                \Midtrans\Config::$is3ds = config('midtrans.is_3ds');

                $params = [
                    'transaction_details' => [
                        'order_id' => $infaq->no_penerimaan,
                        'gross_amount' => (int)$infaq->jumlah,
                    ],
                    'customer_details' => [
                        'first_name' => $donatur->nama,
                        'email' => $donatur->email ?? 'infaq@masjidkhairulamal.com',
                        'phone' => $donatur->no_telepon ?? '',
                    ],
                    'item_details' => [
                        [
                            'id' => 'infaq-1',
                            'price' => (int)$infaq->jumlah,
                            'quantity' => 1,
                            'name' => 'Infaq Masjid Khairul Amal',
                        ],
                    ],
                    // Add callbacks
                    'callbacks' => [
                        'finish' => route('midtrans.finish'),
                    ],
                ];

                $snapToken = \Midtrans\Snap::getSnapToken($params);
                $infaq->snap_token = $snapToken;
                $infaq->save();

                Log::info('Snap Token regenerated: ' . $snapToken . ' for order: ' . $infaq->no_penerimaan);
            } catch (\Exception $e) {
                Log::error('Error regenerating token: ' . $e->getMessage());
                return redirect()->route('dashboard')->with('error', 'Terjadi kesalahan saat memproses pembayaran. Silakan coba lagi.');
            }
        }

        return view('payment', compact('infaq', 'donatur'));
    }

    /**
     * Handle notification from Midtrans
     */
    public function handleNotification(Request $request)
    {
        // Log the raw notification
        Log::info('Midtrans notification received: ' . $request->getContent());

        // Set your Merchant Server Key
        \Midtrans\Config::$serverKey = config('midtrans.server_key');
        \Midtrans\Config::$isProduction = config('midtrans.is_production');

        try {
            $notification = new \Midtrans\Notification();

            $transaction = $notification->transaction_status;
            $type = $notification->payment_type;
            $order_id = $notification->order_id;
            $fraud = $notification->fraud_status ?? null;

            Log::info('Notification processed: status=' . $transaction . ', order_id=' . $order_id);

            $infaq = Infaq::where('no_penerimaan', $order_id)->first();

            if (!$infaq) {
                Log::error('Infaq not found for order_id: ' . $order_id);
                return response()->json(['status' => 'error', 'message' => 'Infaq not found'], 404);
            }

            if ($transaction == 'capture') {
                if ($type == 'credit_card') {
                    if ($fraud == 'challenge') {
                        $infaq->status = 'challenge';
                    } else {
                        $infaq->status = 'success';
                    }
                }
            } else if ($transaction == 'settlement') {
                $infaq->status = 'success';
            } else if ($transaction == 'pending') {
                $infaq->status = 'pending';
            } else if ($transaction == 'deny') {
                $infaq->status = 'denied';
            } else if ($transaction == 'expire') {
                $infaq->status = 'expired';
            } else if ($transaction == 'cancel') {
                $infaq->status = 'canceled';
            }

            $infaq->payment_type = $type;
            $infaq->transaction_id = $notification->transaction_id ?? null;
            $infaq->transaction_time = $notification->transaction_time ?? null;
            $infaq->transaction_status = $transaction;
            $infaq->save();

            Log::info('Infaq status updated to: ' . $infaq->status);

            return response()->json(['status' => 'success']);
        } catch (\Exception $e) {
            Log::error('Error processing notification: ' . $e->getMessage());
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Handle finish redirect from Midtrans
     */
    public function handleFinish(Request $request)
    {
        Log::info('Finish callback received: ' . json_encode($request->all()));

        $order_id = $request->order_id;
        $infaq = Infaq::where('no_penerimaan', $order_id)->first();

        if (!$infaq) {
            Log::error('Infaq not found for order_id: ' . $order_id);
            return redirect()->route('dashboard')->with('error', 'Infaq tidak ditemukan');
        }

        if ($request->transaction_status == 'settlement' || $request->transaction_status == 'capture') {
            $infaq->status = 'success';
            $infaq->transaction_status = $request->transaction_status;
            $infaq->save();
            return redirect()->route('dashboard')->with('success', 'Terima kasih atas infaq Anda. Pembayaran berhasil.');
        } else if ($request->transaction_status == 'pending') {
            $infaq->transaction_status = 'pending';
            $infaq->save();
            return redirect()->route('dashboard')->with('info', 'Pembayaran infaq Anda sedang diproses.');
        } else {
            $infaq->status = 'failed';
            $infaq->transaction_status = $request->transaction_status ?? 'failed';
            $infaq->save();
            return redirect()->route('dashboard')->with('error', 'Pembayaran infaq gagal atau dibatalkan.');
        }
    }
}
