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
use App\Http\Controllers\DetailController;
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
Route::resource('/dashboard-penjualan', DashboardPenjualanController::class)->middleware('admin');
Route::resource('/dashboard-keuangan', DashboardKeuanganController::class)->middleware('admin');
Route::resource('/dashboard-produk', DashboardProdukController::class)->middleware('admin');
Route::resource('/dashboard-pengeluaran', DashboardPengeluaranController::class)->middleware('admin');
Route::resource('/dashboard-dash-user', PelangganController::class)->middleware('isAdmin');
Route::group(['middleware' => function ($request, $next) {
    if (Auth::check() && Auth::user()->isAdmin === 0) {
        return $next($request);
    }
    abort(403); // Akses ditolak
}], function () {
    Route::resource('/dashboard-dash-user', PelangganController::class);
});




Route::group(['middleware' => function ($request, $next) {
    if (Auth::check() && Auth::user()->isAdmin === 0) {
        return $next($request);
    }
    abort(403); // Akses ditolak
}], function () {
    // Definisikan rute untuk DetailController
    Route::get('/dashboard-detail/{id}', [DetailController::class, 'index'])->name('dashboard-detail.show');
});

Route::group(['middleware' => function ($request, $next) {
    if (Auth::check() && Auth::user()->isAdmin === 0) {
        return $next($request);
    }
    abort(403); // Akses ditolak
}], function () {
    // Definisikan rute untuk DetailController
    Route::get('dashboard-keranjang', [KeranjangController::class, 'index'])->name('dashboard-keranjang.index');

    // Route untuk menghapus item keranjang
    Route::delete('dashboard-keranjang/{id}', [KeranjangController::class, 'destroy'])->name('dashboard-keranjang.destroy');
    Route::get('dashboard-keranjang/create/{id}', [KeranjangController::class, 'create'])->name('dashboard-keranjang.create');
    Route::post('dashboard-keranjang/store/{id}', [KeranjangController::class, 'store'])->name('dashboard-keranjang.store');
// Route untuk halaman edit keranjang
Route::get('dashboard-keranjang/edit/{id}', [KeranjangController::class, 'edit'])->name('dashboard-keranjang.edit');

// Route untuk update data keranjang
Route::put('dashboard-keranjang/{id}', [KeranjangController::class, 'update'])->name('dashboard-keranjang.update');
});




Route::resource('/dashboard', DashboardController::class)->middleware('admin');





Route::get('/login', [AuthController::class, 'login']);
Route::get('/forgot-password', [ForgotPasswordController::class, 'showForgetPasswordForm'])->name('forget.password.get');
Route::post('/forgot-password', [ForgotPasswordController::class, 'submitForgetPasswordForm'])->name('forget.password.post');
Route::get('/resetpassword/{token}', [ForgotPasswordController::class, 'showResetPasswordForm'])->name('password.reset'); // Tambahkan nama 'password.reset' di sini
Route::post('/resetpassword', [ForgotPasswordController::class, 'submitResetPasswordForm'])->name('reset.password.post');

Route::post('/login-action', [AuthController::class, 'loginProses'])->name('login.action');
Route::get('/logout', [AuthController::class, 'logout']);
Route::post('/logout', [AuthController::class, 'logout']);
Route::get('/register', [AuthController::class, 'register']);
Route::post('/register-action', [AuthController::class, 'registerProses'])->name('register.proses');












