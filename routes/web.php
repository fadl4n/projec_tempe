<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DashboardStokController;
use App\Http\Controllers\DashboardUserController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\DashboardProdukController;
use App\Http\Controllers\DashboardKeuanganController;
use App\Http\Controllers\DashboardPenjualanController;
use App\Http\Controllers\DashboardPengeluaranController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\RiwayatPesananController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\KeranjangController;
use Illuminate\Support\Facades\Auth;

use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/dashboard', function () {
    return view('dashboard.index');
})->middleware('admin');

Route::resource('/dashboard-user', DashboardUserController::class)->middleware('admin');
Route::resource('/dashboard-stok', DashboardStokController::class)->middleware('admin');
Route::resource('/dashboard-keuangan', DashboardKeuanganController::class)->middleware('admin');
Route::get('/dashboard-keuangan-pdf', [DashboardKeuanganController::class, 'generatePDF'])->name('dashboard-keuangan.pdf');


Route::resource('/dashboard-penjualan', DashboardPenjualanController::class);
Route::patch('/dashboard-penjualan/{id}/update-status', [DashboardPenjualanController::class, 'updateStatus'])
    ->name('dashboard-penjualan.update-status');
Route::resource('/dashboard-produk', DashboardProdukController::class)->middleware('admin');
Route::resource('/dashboard-pengeluaran', DashboardPengeluaranController::class)->middleware('admin');
Route::resource('/dashboard-dash-user', PelangganController::class);



Route::group(['middleware' => function ($request, $next) {
    if (Auth::check() && Auth::user()->isAdmin === 0) {
        return $next($request);
    }
    abort(403); // Akses ditolak
}], function () {
    // Keranjang Routes
    Route::get('dashboard-keranjang', [KeranjangController::class, 'index'])->name('dashboard-keranjang.index');
    Route::delete('dashboard-keranjang/{id}', [KeranjangController::class, 'destroy'])->name('dashboard-keranjang.destroy');
    Route::get('dashboard-keranjang/create/{id}', [KeranjangController::class, 'create'])->name('dashboard-keranjang.create');
    Route::post('dashboard-keranjang/store', [KeranjangController::class, 'store'])->name('dashboard-keranjang.store');
    Route::get('dashboard-keranjang/edit/{id}', [KeranjangController::class, 'edit'])->name('dashboard-keranjang.edit');
    Route::put('dashboard-keranjang/edit/{id}', [KeranjangController::class, 'update'])->name('dashboard-keranjang.update');
    Route::post('/keranjang/pilih', [KeranjangController::class, 'pilihKeranjang'])->name('keranjang.pilih');
    Route::get('/keranjang/bayar', [KeranjangController::class, 'bayar'])->name('dashboard-keranjang.bayar');
    Route::post('/keranjang/proses-pembayaran', [KeranjangController::class, 'prosesPembayaran'])->name('dashboard-keranjang.prosesPembayaran');

});


Route::resource('/dashboard', DashboardController::class)->middleware('admin');
Route::get('/login', [AuthController::class, 'login']);
Route::get('/forgot-password', [ForgotPasswordController::class, 'showForgetPasswordForm'])->name('forget.password.get');
Route::post('/forgot-password', [ForgotPasswordController::class, 'submitForgetPasswordForm'])->name('forget.password.post');
Route::get('/resetpassword/{token}', [ForgotPasswordController::class, 'showResetPasswordForm'])->name('password.reset'); // Tambahkan nama 'password.reset' di sini
Route::post('/resetpassword', [ForgotPasswordController::class, 'submitResetPasswordForm'])->name('reset.password.post');

Route::post('/login-action', [AuthController::class, 'loginProses'])->name('login.action');
Route::get('/login', [AuthController::class, 'login'])->name('login');  // Route untuk menampilkan form login
Route::get('/logout', [AuthController::class, 'logout']);
Route::post('/logout', [AuthController::class, 'logout']);
Route::get('/register', [AuthController::class, 'register']);
Route::post('/register-action', [AuthController::class, 'registerProses'])->name('register.proses');



Route::get('/checkout', [CheckoutController::class, 'checkout'])->name('checkout.index');
Route::post('/checkout/process', [CheckoutController::class, 'processCheckout'])->name('checkout.process');
Route::get('/checkout/success', [CheckoutController::class, 'success'])->name('checkout.success');


Route::get('/dashboard-pengeluaran-pdf', [DashboardPengeluaranController::class, 'downloadPdf'])->name('dashboard-pengeluaran.pdf');

Route::get('/dashboard-about', [AboutController::class, 'index'])->name('dashboard-about.index');

Route::get('/riwayat-pesanan', [RiwayatPesananController::class, 'index'])->name('riwayat.pesanan');
Route::put('/riwayat/batal/{id}', [RiwayatPesananController::class, 'batal'])->name('riwayat.batal');

Route::get('/bayar', [PembayaranController::class, 'index'])->name('bayar.index');
Route::post('/bayar/process', [PembayaranCOntroller::class, 'process'])->name('bayar.process');






