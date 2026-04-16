<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactusController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\StokController;
use App\Http\Controllers\LogstokController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\KeranjangController;

// ALL USERS
Route::get('/', function () {
    return view('landingpage.page.beranda');
});
Route::get('/tentang', function () {
    return view('landingpage.page.tentang');
});
Route::get('/contactus', [ContactUsController::class, 'contactUs'])->name('contact_us.contactUs');
Route::post('/contactus', [ContactUsController::class, 'store'])->name('contact_us.store');
Route::get('/semuaproduk', [FrontendController::class, 'index'])->name('semuaproduk');
Route::get('/semuaproduk/search', [FrontendController::class, 'search'])->name('frontend.search');
Route::get('/register', [RegisterController::class, 'index']);
Route::post('/register', [RegisterController::class, 'store'])->name('register.store');
Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'authenticate']);
Route::post('/logout', [LoginController::class, 'logout']);

// PELANGGAN

Route::get('/detailpelanggan', function () {
    return view('landingpage.pelanggan.detailpelanggan');});
Route::get('/editprofile', function () {
    return view('landingpage.pelanggan.editprofile');});
Route::get('/edit-profile', [UserController::class, 'editUser'])->name('edit-profile');
Route::put('/edit-profile', [UserController::class, 'updateUser'])->name('update-profile');
Route::resource('keranjangs', KeranjangController::class);
Route::post('/keranjang/tambah/{id}', [KeranjangController::class, 'tambah']);
Route::get('/keranjang', [KeranjangController::class, 'show'])->name('keranjang.show');


// ADMIN
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::resource('/dashboard-produk', ProdukController::class);
Route::resource('/dashboard-stok', StokController::class);
Route::post('/stok/tambah/{produk_id}', [StokController::class, 'tambah'])->name('stok.tambah');
Route::post('/stok/kurangi/{produk_id}', [StokController::class, 'kurangi'])->name('stok.kurangi');
Route::get('/dashboard-mutasi', [LogstokController::class, 'index'])->name('logstoks.index');
Route::get('/dashboard-mutasi/cetak', [LogstokController::class, 'cetak'])->name('logstoks.cetak');
Route::get('/dashboard-mutasi/{bulan}/{tahun}', [LogstokController::class, 'show'])->name('logstoks.show');
Route::resource('/dashboard-pengguna', UserController::class);
Route::get('/contact-us', [ContactusController::class, 'index'])->name('contactuses.index');
Route::get('/contact-us/cetak/pdf', [ContactusController::class, 'cetakPDF'])->name('contactuses.cetak_pdf');
Route::get('/contact-us/{id}/edit', [ContactusController::class, 'edit'])->name('contactuses.edit');
Route::get('/contact-us/{id}', [ContactusController::class, 'show'])->name('contactuses.show');
Route::put('/contact-us/{id}', [ContactusController::class, 'update'])->name('contactuses.update');
Route::delete('/contact-us/{id}', [ContactusController::class, 'destroy'])->name('contactuses.destroy');