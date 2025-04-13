<?php

namespace App\Services;

use App\Models\Infaq;
use Illuminate\Support\Facades\Log;

class MidtransService
{
    protected $serverKey;
    protected $isProduction;
    protected $isSanitized;
    protected $is3ds;

    public function __construct()
    {
        $this->serverKey = config('midtrans.server_key');
        $this->isProduction = config('midtrans.is_production', false);
        $this->isSanitized = config('midtrans.is_sanitized', true);
        $this->is3ds = config('midtrans.is_3ds', true);

        // Set Midtrans configuration
        \Midtrans\Config::$serverKey = $this->serverKey;
        \Midtrans\Config::$isProduction = $this->isProduction;
        \Midtrans\Config::$isSanitized = $this->isSanitized;
        \Midtrans\Config::$is3ds = $this->is3ds;
    }

    /**
     * Create Snap Payment Page URL for donation
     */
    public function createSnapUrl(Infaq $infaq, $donatur)
    {
        $orderId = $infaq->no_penerimaan;
        $amount = $infaq->jumlah;

        $transactionDetails = [
            'order_id' => $orderId,
            'gross_amount' => (int) $amount,
        ];

        $customerDetails = [
            'first_name' => $donatur->nama,
            'email' => $donatur->email ?? 'donatur@masjidkhairulamal.com',
            'phone' => $donatur->no_telepon ?? '',
        ];

        $itemDetails = [
            [
                'id' => 'INFAQ-1',
                'price' => (int) $amount,
                'quantity' => 1,
                'name' => 'Infaq Masjid Khairul Amal',
            ]
        ];

        $transactionData = [
            'transaction_details' => $transactionDetails,
            'customer_details' => $customerDetails,
            'item_details' => $itemDetails,
        ];

        try {
            $snapToken = \Midtrans\Snap::getSnapToken($transactionData);
            $snapUrl = \Midtrans\Snap::getSnapUrl($transactionData);

            return [
                'token' => $snapToken,
                'redirect_url' => $snapUrl
            ];
        } catch (\Exception $e) {
            Log::error('Midtrans Error: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Handle notification from Midtrans
     */
    public function handleNotification($notificationData)
    {
        $notificationBody = json_decode($notificationData, true);
        $orderId = $notificationBody['order_id'];
        $statusCode = $notificationBody['status_code'];
        $transactionStatus = $notificationBody['transaction_status'];
        $fraudStatus = $notificationBody['fraud_status'] ?? null;

        $infaq = Infaq::where('no_penerimaan', $orderId)->first();

        if (!$infaq) {
            Log::error('Infaq not found for order ID: ' . $orderId);
            return false;
        }

        if ($statusCode == '200') {
            if ($transactionStatus == 'capture') {
                if ($fraudStatus == 'challenge') {
                    $infaq->status = 'challenge';
                } else if ($fraudStatus == 'accept') {
                    $infaq->status = 'success';
                }
            } else if ($transactionStatus == 'settlement') {
                $infaq->status = 'success';
            } else if ($transactionStatus == 'cancel' || $transactionStatus == 'deny' || $transactionStatus == 'expire') {
                $infaq->status = 'failed';
            } else if ($transactionStatus == 'pending') {
                $infaq->status = 'pending';
            }

            $infaq->payment_type = $notificationBody['payment_type'] ?? null;
            $infaq->transaction_id = $notificationBody['transaction_id'] ?? null;
            $infaq->transaction_time = $notificationBody['transaction_time'] ?? null;
            $infaq->transaction_status = $transactionStatus;
            $infaq->save();

            return true;
        }

        return false;
    }
}
