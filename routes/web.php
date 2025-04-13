<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\DonaturController;
use App\Http\Controllers\MustahikController;
use App\Http\Controllers\MuzakkiController;
use App\Http\Controllers\InfaqController;
use App\Http\Controllers\PengeluaranController;
use App\Http\Controllers\ZakatController;
use App\Http\Controllers\PetugasController;
use App\Http\Controllers\PenerimaQurbanController;
use App\Http\Controllers\SholatController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\KajianController;
use App\Http\Controllers\ShohibulQurbanController;
use App\Http\Controllers\AturanPembagianController;
use App\Http\Controllers\NasabahQurbanController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\HargaHewanQurbanController;
use App\Http\Controllers\TabunganQurbanController;
use App\Http\Controllers\KeuanganQurbanController;
use App\Http\Controllers\PenyaluranController;
use App\Http\Controllers\MidtransController;


// Login Routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Register Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::get('/register/create', [RegisterController::class, 'create'])->name('register.create'); // Route for the create form
    Route::post('/register', [RegisterController::class, 'register'])->name('register.store'); // Route for storing the data
    Route::get('/register/{user}/edit', [RegisterController::class, 'edit'])->name('register.edit');
    Route::put('/register/{user}', [RegisterController::class, 'update'])->name('register.update');
    Route::delete('/register/{user}', [RegisterController::class, 'destroy'])->name('register.destroy');
});

// Donatur Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/donatur', [DonaturController::class, 'index'])->name('donatur.index'); // Route untuk list donatur
    Route::get('/donatur/create', [DonaturController::class, 'create'])->name('donatur.create'); // Route untuk form tambah donatur
    Route::post('/donatur', [DonaturController::class, 'store'])->name('donatur.store'); // Route untuk simpan donatur baru
    Route::get('/donatur/{donatur}/edit', [DonaturController::class, 'edit'])->name('donatur.edit'); // Route untuk form edit donatur
    Route::put('/donatur/{donatur}', [DonaturController::class, 'update'])->name('donatur.update'); // Route untuk update donatur
    Route::delete('/donatur/{donatur}', [DonaturController::class, 'destroy'])->name('donatur.destroy'); // Route untuk hapus donatur
});

// Mustahik Routes
Route::middleware(['auth'])->group(function () {
    Route::resource('mustahik', MustahikController::class);
});

// Muzakki Routes
Route::middleware(['auth'])->group(function () {
    Route::resource('muzakki', MuzakkiController::class);
});

// Infaq Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/infaq', [InfaqController::class, 'index'])->name('infaq.index'); // Route untuk list infaq
    Route::get('/infaq/create', [InfaqController::class, 'create'])->name('infaq.create'); // Route untuk form tambah infaq
    Route::post('/infaq', [InfaqController::class, 'store'])->name('infaq.store'); // Route untuk simpan infaq baru
    Route::get('/infaq/{infaq}/edit', [InfaqController::class, 'edit'])->name('infaq.edit'); // Route untuk form edit infaq
    Route::put('/infaq/{infaq}', [InfaqController::class, 'update'])->name('infaq.update'); // Route untuk update infaq
    Route::delete('/infaq/{infaq}', [InfaqController::class, 'destroy'])->name('infaq.destroy'); // Route untuk hapus infaq
    Route::get('/infaq/report', [InfaqController::class, 'report'])->name('infaq.report');
    Route::get('/infaq/report/pdf', [InfaqController::class, 'generatePdfReport'])->name('infaq.report.pdf');
});

// Zakat Routes
Route::middleware(['auth'])->group(function () {
    Route::resource('zakat', ZakatController::class);
    Route::get('zakat-report', [ZakatController::class, 'report'])->name('zakat.report');
    Route::get('zakat-report/pdf', [ZakatController::class, 'generatePdf'])->name('zakat.report.pdf');
});

// Penyaluran Zakat Routes
Route::resource('penyaluran', PenyaluranController::class);

// Pengeluaran Routes
Route::resource('pengeluaran', PengeluaranController::class);

// Petugas Qurban Routes
Route::resource('petugas', PetugasController::class);

// Penerima Qurban Routes
Route::prefix('penerima-qurban')->group(function () {
    Route::get('/', [PenerimaQurbanController::class, 'index'])->name('penerima-qurban.index');
    Route::get('/create', [PenerimaQurbanController::class, 'create'])->name('penerima-qurban.create');
    Route::post('/', [PenerimaQurbanController::class, 'store'])->name('penerima-qurban.store');
    Route::get('/{penerima_qurban}/edit', [PenerimaQurbanController::class, 'edit'])->name('penerima-qurban.edit');
    Route::put('/{penerima_qurban}', [PenerimaQurbanController::class, 'update'])->name('penerima-qurban.update');
    Route::delete('/{penerima_qurban}', [PenerimaQurbanController::class, 'destroy'])->name('penerima-qurban.destroy');
    Route::get('/report', [PenerimaQurbanController::class, 'report'])->name('penerima-qurban.report');
    Route::get('/export-pdf', [PenerimaQurbanController::class, 'exportPdf'])->name('penerima-qurban.export-pdf');
});

// Keuangan Qurban
Route::middleware(['auth'])->prefix('keuangan-qurban')->group(function () {
    Route::get('/', [KeuanganQurbanController::class, 'index'])->name('keuangan-qurban.index');
    Route::get('/create', [KeuanganQurbanController::class, 'create'])->name('keuangan-qurban.create');
    Route::post('/', [KeuanganQurbanController::class, 'store'])->name('keuangan-qurban.store');
    Route::get('/{id}/edit', [KeuanganQurbanController::class, 'edit'])->name('keuangan-qurban.edit');
    Route::put('/{id}', [KeuanganQurbanController::class, 'update'])->name('keuangan-qurban.update');
    Route::delete('/{id}', [KeuanganQurbanController::class, 'destroy'])->name('keuangan-qurban.destroy');
    Route::get('/laporan', [KeuanganQurbanController::class, 'laporan'])->name('keuangan-qurban.laporan');
    Route::get('/laporan/pdf', [KeuanganQurbanController::class, 'laporan'])->name('keuangan-qurban.laporan.pdf');
});

// Sholat
Route::resource('sholat', SholatController::class);
// Kajian
Route::resource('kajian', KajianController::class);

// Shohibul Qurban
// Replace the resource route with explicit routes
Route::prefix('shohibul-qurban')->group(function () {
    Route::get('/', [ShohibulQurbanController::class, 'index'])->name('shohibul-qurban.index');
    Route::get('/create', [ShohibulQurbanController::class, 'create'])->name('shohibul-qurban.create');
    Route::post('/', [ShohibulQurbanController::class, 'store'])->name('shohibul-qurban.store');
    Route::get('/{shohibulQurban}/edit', [ShohibulQurbanController::class, 'edit'])->name('shohibul-qurban.edit');
    Route::put('/{shohibulQurban}', [ShohibulQurbanController::class, 'update'])->name('shohibul-qurban.update');
    Route::delete('/{shohibulQurban}', [ShohibulQurbanController::class, 'destroy'])->name('shohibul-qurban.destroy');
    Route::get('/report', [ShohibulQurbanController::class, 'report'])->name('shohibul-qurban.report');
    Route::get('/export-pdf', [ShohibulQurbanController::class, 'exportPdf'])->name('shohibul-qurban.export-pdf');
    Route::get('/laporan-hewan', [ShohibulQurbanController::class, 'laporanHewan'])->name('shohibul-qurban.laporan-hewan');
    Route::get('/laporan-hewan/pdf', [ShohibulQurbanController::class, 'laporanHewanPdf'])->name('shohibul-qurban.laporan-hewan.pdf');
    Route::get('/nametag-hewan', [ShohibulQurbanController::class, 'nametagHewan'])->name('shohibul-qurban.nametag-hewan');
    Route::get('/nametag-hewan/pdf', [ShohibulQurbanController::class, 'nametagHewanPdf'])->name('shohibul-qurban.nametag-hewan.pdf');
});

// Aturan Pembagian
Route::prefix('aturan-pembagian')->group(function () {
    // Routes untuk Aturan Pembagian
    Route::get('/', [AturanPembagianController::class, 'index'])->name('aturan-pembagian.index');
    Route::post('/', [AturanPembagianController::class, 'store'])->name('aturan-pembagian.store');
    Route::get('/{id}/edit', [AturanPembagianController::class, 'edit'])->name('aturan-pembagian.edit');
    Route::put('/{id}', [AturanPembagianController::class, 'update'])->name('aturan-pembagian.update');
    Route::delete('/{id}', [AturanPembagianController::class, 'destroy'])->name('aturan-pembagian.destroy');

    // Routes untuk Pembagian Produk
    Route::post('/produk', [AturanPembagianController::class, 'storeProduk'])->name('aturan-pembagian.produk.store');
    Route::get('/produk/{id}/edit', [AturanPembagianController::class, 'editProduk'])->name('aturan-pembagian.produk.edit');
    Route::put('/produk/{id}', [AturanPembagianController::class, 'updateProduk'])->name('aturan-pembagian.produk.update');
    Route::delete('/produk/{id}', [AturanPembagianController::class, 'destroyProduk'])->name('aturan-pembagian.produk.destroy');
});

// Nasabah Qurban
Route::resource('nasabah-qurban', NasabahQurbanController::class);

Route::prefix('harga-hewan-qurban')->group(function () {
    Route::get('/', [HargaHewanQurbanController::class, 'index'])->name('harga-hewan-qurban.index');
    Route::get('/create', [HargaHewanQurbanController::class, 'create'])->name('harga-hewan-qurban.create');
    Route::post('/', [HargaHewanQurbanController::class, 'store'])->name('harga-hewan-qurban.store');
    Route::get('/{id}/edit', [HargaHewanQurbanController::class, 'edit'])->name('harga-hewan-qurban.edit');
    Route::put('/{id}', [HargaHewanQurbanController::class, 'update'])->name('harga-hewan-qurban.update');
    Route::delete('/{id}', [HargaHewanQurbanController::class, 'destroy'])->name('harga-hewan-qurban.destroy');
});

Route::prefix('tabungan-qurban')->group(function () {
    Route::get('/', [TabunganQurbanController::class, 'index'])->name('tabungan-qurban.index');
    Route::get('/create', [TabunganQurbanController::class, 'create'])->name('tabungan-qurban.create');
    Route::post('/', [TabunganQurbanController::class, 'store'])->name('tabungan-qurban.store');
    Route::get('/{id}/edit', [TabunganQurbanController::class, 'edit'])->name('tabungan-qurban.edit');
    Route::put('/{id}', [TabunganQurbanController::class, 'update'])->name('tabungan-qurban.update');
    Route::delete('/{id}', [TabunganQurbanController::class, 'destroy'])->name('tabungan-qurban.destroy');
});


// Midtrans routes
Route::post('/midtrans/create-transaction', [App\Http\Controllers\MidtransController::class, 'createTransaction'])->name('midtrans.create');
Route::get('/midtrans/payment/{id}', [App\Http\Controllers\MidtransController::class, 'showPaymentPage'])->name('midtrans.payment');
Route::post('/midtrans/notification', [App\Http\Controllers\MidtransController::class, 'handleNotification'])->name('midtrans.notification');
Route::get('/midtrans/finish', [App\Http\Controllers\MidtransController::class, 'handleFinish'])->name('midtrans.finish');

Route::post('/donatur/store-ajax', [App\Http\Controllers\DonaturController::class, 'storeAjax'])->name('donatur.store.ajax');

Route::resource('inventories', InventoryController::class);

// Dashboard Route (No login required)
Route::get('/', [FrontendController::class, 'index'])->name('dashboard');

Route::post('/', [FrontendController::class, 'storeInfaq'])->name('frontend.storeInfaq');

// Welcome Route (Only accessible by authenticated users)
Route::middleware(['auth'])->group(function () {
    Route::get('/welcome', function () {
        return view('welcome'); // Display the welcome page for authenticated users
    })->name('welcome');
});
