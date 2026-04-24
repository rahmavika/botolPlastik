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
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\RiwayatBelanjaController;
use App\Http\Controllers\PenjualanController;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

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
Route::get('/checkout', [CheckoutController::class, 'show'])->name('checkout.show');
Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
Route::get('/checkout/{id}/detail', [CheckoutController::class, 'detail'])->name('checkout.detail');

Route::get('/provinsi', function () {
    return Http::withHeaders([
        'key' => env('KOMERCE_KEY')
    ])->get('https://rajaongkir.komerce.id/api/v1/destination/province')->json();
});
Route::get('/kota/{id}', function ($id) {
    return Http::withHeaders([
        'key' => env('KOMERCE_KEY')
    ])->get("https://rajaongkir.komerce.id/api/v1/destination/city/$id")->json();
});
Route::post('/cek-ongkir', function (Request $request) {

    $response = Http::withHeaders([
        'key' => env('KOMERCE_KEY')
    ])
    ->asForm()
    ->post('https://rajaongkir.komerce.id/api/v1/calculate/district/domestic-cost', [
        'origin' => 501,
        'destination' => $request->destination,
        'weight' => $request->weight,
        'courier' => $request->courier
    ]);

    if ($response->failed()) {
        return response()->json([
            'error' => true,
            'message' => $response->body()
        ]);
    }

    return response()->json($response->json());

})->withoutMiddleware([\Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class]);

Route::post('/riwayat-belanja/{id}/ulasan', [RiwayatBelanjaController::class, 'simpanUlasan'])->name('riwayatBelanja.simpanUlasan');
Route::get('/riwayat-belanja', [RiwayatBelanjaController::class, 'index'])->name('riwayat-belanja');
Route::post('/upload-bukti/{id}', [RiwayatBelanjaController::class, 'uploadBukti'])->name('upload.bukti');


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
Route::delete('/contact-us/{id}', [ContactusController::class, 'destroy'])->name('contactuses.destroy');Route::get('/dashboard-pesanan', [CheckoutController::class, 'showPesanan'])->name('checkouts.pesanan');
Route::get('/dashboard-pesanan/{id}', [CheckoutController::class, 'show'])->name('checkouts.show');
Route::post('/dashboard-pesanan/{id}/confirm', [CheckoutController::class, 'confirm'])->name('checkouts.confirm');
Route::put('/checkouts/{id}/update-status', [CheckoutController::class, 'updateStatus'])->name('checkouts.updateStatus');
Route::put('/checkouts/{id}/update-pembayaran', [CheckoutController::class, 'updatePembayaran'])->name('checkouts.updatePembayaran');
Route::resource('/dashboard-penjualan', PenjualanController::class);
Route::get('/cetak-pdf/penjualan', [PenjualanController::class, 'cetakPdf'])->name('penjualan.cetak_pdf');
Route::post('/input-resi/{id}', [CheckoutController::class, 'inputResi']);