<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\HomeCustomerController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\PembayaranCustomerController;
use App\Http\Controllers\PenggunaanController;
use App\Http\Controllers\TagihanController;
use App\Http\Controllers\TagihanCustomerController;
use App\Http\Controllers\TarifController;


;

Route::get('/', function () {
    return view('auth.login');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/dashboard', [TagihanCustomerController::class, 'showDashboard'])->middleware(['auth', 'verified','auth.customer'])->name('dashboard');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';



Route::middleware('auth','admin')->group(function () {
    Route::get('admin/dashboard', [HomeController::class,'index'])->name('home.index');
});


Route::middleware('auth','auth.customer')->group(function () {

    Route::get('/dashboard/cektagihan', [TagihanCustomerController::class, 'cekTagihan'])->name('cek.tagihan');
    Route::get('/pembayaran/{tagihan}', [PembayaranCustomerController::class, 'create'])->name('pembayaran.create');
    Route::post('/pembayaran', [PembayaranCustomerController::class, 'store'])->name('pembayaran.store');
});




Route::get('/tarif', [TarifController::class, 'index'])->name('tarif.index');
Route::post('/tarif', [TarifController::class, 'store'])->name('tarif.store');
Route::delete('/tarif/{id}', [TarifController::class, 'destroy'])->name('tarif.destroy')->middleware('auth.user');
Route::put('/tarif/{id}', [TarifController::class, 'update'])->name('tarif.update')->middleware('auth.user');



Route::get('/pelanggan', [PelangganController::class, 'index'])->name('pelanggan.index')->middleware('auth.user');
Route::post('/pelanggan', [PelangganController::class, 'store'])->name('pelanggan.store')->middleware('auth.user');
Route::delete('/pelanggan/{id}', [PelangganController::class, 'destroy'])->name('pelanggan.destroy')->middleware('auth.user');
Route::put('/pelanggan/{id}', [PelangganController::class, 'update'])->name('pelanggan.update')->middleware('auth.user');


Route::get('/penggunaan', [PenggunaanController::class, 'index'])->middleware('auth.user');
Route::post('/penggunaan', [PenggunaanController::class, 'store'])->middleware('auth.user');
Route::delete('/penggunaan/{id}', [PenggunaanController::class, 'destroy'])->name('penggunaan.destroy')->middleware('auth.user');


Route::middleware('auth.user')->group(function () {
Route::get('/tagihan', [TagihanController::class, 'index'])->name('tagihan.index');
Route::get('/tagihan/search', [TagihanController::class, 'search'])->name('tagihan.search');
Route::post('/tagihan/store', [TagihanController::class, 'store'])->name('tagihan.store');
Route::put('/tagihan/{id}', [TagihanController::class, 'update'])->name('tagihan.update');
Route::delete('/tagihan/{id}', [TagihanController::class, 'destroy'])->name('tagihan.destroy');


});



Route::get('/pembayaran', [PembayaranController::class, 'index'])->middleware('auth.user');
Route::delete('/pembayaran/{id}', [PembayaranController::class, 'destroy'])->name('pembayaran.destroy')->middleware('auth.user');
Route::patch('/pembayaran/confirm/{id}', [PembayaranController::class, 'confirm'])->name('pembayaran.confirm')->middleware('auth.user');
Route::get('/customer', [CustomerController::class, 'index'])->middleware('auth.user');