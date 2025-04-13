<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran Infaq - Masjid Khairul Amal</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .payment-container {
            max-width: 800px;
            margin: 50px auto;
        }
        .card {
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        .card-header {
            background: linear-gradient(135deg, #4CAF50, #2E7D32);
            color: white;
            padding: 20px;
        }
        .btn-primary {
            background: linear-gradient(135deg, #4CAF50, #2E7D32);
            border: none;
            padding: 12px 30px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        .btn-primary:hover {
            background: linear-gradient(135deg, #2E7D32, #1B5E20);
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }
        .logo-container {
            text-align: center;
            margin-bottom: 20px;
        }
        .logo-container img {
            max-width: 100px;
        }
    </style>
</head>
<body>
    <div class="container payment-container">
        <div class="card">
            <div class="card-header">
                <h3 class="mb-0">Pembayaran Infaq</h3>
            </div>
            <div class="card-body p-4">
                <div class="logo-container">
                    <img src="{{ asset('masjid/main_files/assets/img/heading-img.png') }}" alt="icon" class="mb-3 img-fluid">
                    <h4>Masjid Khairul Amal</h4>
                </div>

                <div class="row mb-4">
                    <div class="col-md-6">
                        <p><strong>No. Penerimaan:</strong> {{ $infaq->no_penerimaan }}</p>
                        <p><strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($infaq->tanggal)->format('d M Y') }}</p>
                        <p><strong>Waktu:</strong> {{ \Carbon\Carbon::parse($infaq->waktu)->format('H:i') }}</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Donatur:</strong> {{ $donatur->nama }}</p>
                        <p><strong>Jenis Penerimaan:</strong> {{ $infaq->jenis_penerimaan }}</p>
                        <p><strong>Jumlah:</strong> Rp {{ number_format($infaq->jumlah, 0, ',', '.') }}</p>
                    </div>
                </div>

                <div class="alert alert-info">
                    <p class="mb-0">Silahkan pilih metode pembayaran dengan klik tombol "Bayar Sekarang" di bawah ini.</p>
                </div>

                <div class="text-center mt-4">
                    <button id="pay-button" class="btn btn-primary btn-lg">Bayar Sekarang</button>
                    <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary btn-lg ms-2">Kembali</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Midtrans JS SDK -->
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env('midtrans.client_key') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('pay-button').onclick = function() {
                // Check if snap token exists
                const snapToken = '{{ $infaq->snap_token }}';

                if (!snapToken) {
                    alert('Token pembayaran tidak valid. Silakan coba lagi.');
                    window.location.reload();
                    return;
                }

                // Trigger snap popup
                snap.pay(snapToken, {
                    onSuccess: function(result) {
                        console.log('Payment success:', result);
                        window.location.href = '{{ route("midtrans.finish") }}?' + new URLSearchParams({
                            order_id: result.order_id,
                            transaction_status: result.transaction_status
                        }).toString();
                    },
                    onPending: function(result) {
                        console.log('Payment pending:', result);
                        window.location.href = '{{ route("midtrans.finish") }}?' + new URLSearchParams({
                            order_id: result.order_id,
                            transaction_status: result.transaction_status
                        }).toString();
                    },
                    onError: function(result) {
                        console.log('Payment error:', result);
                        window.location.href = '{{ route("midtrans.finish") }}?' + new URLSearchParams({
                            order_id: result.order_id,
                            transaction_status: 'error'
                        }).toString();
                    },
                    onClose: function() {
                        console.log('Customer closed the popup without finishing the payment');
                        alert('Anda menutup popup tanpa menyelesaikan pembayaran');
                    }
                });
            };
        });
    </script>
</body>
</html>
