@extends('landingpage.layouts.main')
@section('title', 'Beranda')
@section('navAdm', 'active')
@section('content')

<section class="py-5>
    <div class="container">
        <div class="p-5 bg-white rounded-4 shadow-sm text-center">
            <h1 class="fw-bold mb-3" style="font-size: 2rem;">
                Solusi Plastik & Packaging Terpercaya
            </h1>
            <p class="text-muted mb-4" style="max-width: 600px; margin:auto;">
                Menyediakan berbagai kebutuhan plastik dengan kualitas terbaik
                dan harga terjangkau untuk bisnis Anda.
            </p>
            <a href="/semuaproduk" class="btn px-4 py-2 rounded-pill"
               style="background-color: #1b2a41; color: white;">
                Lihat Produk
            </a>
        </div>
    </div>
</section>
<section class="py-5">
    <div class="container">
        <h2 class="text-center fw-bold mb-4">Seputar Toko</h2>
        <div class="row g-4 justify-content-center">
            <div class="col-md-3">
                <div class="card border-0 shadow-sm rounded-4 position-relative h-100">
                    <img src="/storage/packing.jpg" class="card-img-top rounded-top-4">
                    <div class="card-body text-center">
                        <h6 class="fw-semibold">Kegiatan Packing</h6>
                        <p class="text-muted">Proses pengemasan rapi & aman</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm rounded-4 position-relative h-100">
                    <img src="/storage/gudang.jpg" class="card-img-top rounded-top-4">
                    <div class="card-body text-center">
                        <h6 class="fw-semibold">Stok Gudang</h6>
                        <p class="text-muted">Ketersediaan barang siap kirim</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm rounded-4 position-relative h-100">
                    <img src="/storage/kemasan.jpeg" class="card-img-top rounded-top-4">
                    <div class="card-body text-center">
                        <h6 class="fw-semibold">Variasi Packaging</h6>
                        <p class="text-muted">Beragam pilihan kemasan</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm rounded-4 position-relative h-100">
                    <img src="/storage/pengiriman.jpeg" class="card-img-top rounded-top-4">
                    <div class="card-body text-center">
                        <h6 class="fw-semibold">Pengiriman</h6>
                        <p class="text-muted">Siap dikirim ke seluruh daerah</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="py-5">
    <div class="container">
        <h2 class="text-center fw-bold mb-4" style="font-size: 2rem;">Layanan Kami</h2>
        <p class="text-center text-muted mb-5" style="max-width: 600px; margin: 0 auto; font-size: 1rem;">
            Kami menyediakan berbagai layanan untuk mendukung kebutuhan bisnis dan belanja plastik Anda.
        </p>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm p-4 text-center rounded-4 hover-card">
                    <i class="bi bi-truck fs-1 mb-3" style="color: #1b2a41;"></i>
                    <h5 class="fw-semibold mb-2">Pengiriman Cepat</h5>
                    <p class="text-muted" style="font-size: 0.95rem;">
                        Pengiriman aman & cepat langsung ke lokasi Anda.
                    </p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm p-4 text-center rounded-4 hover-card">
                    <i class="bi bi-person-lines-fill fs-1 mb-3" style="color: #1b2a41;"></i>
                    <h5 class="fw-semibold mb-2">Konsultasi Gratis</h5>
                    <p class="text-muted" style="font-size: 0.95rem;">
                        Konsultasikan kebutuhan plastik & packaging Anda dengan tim kami.
                    </p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm p-4 text-center rounded-4 hover-card">
                    <i class="bi bi-credit-card fs-1 mb-3" style="color: #1b2a41;"></i>
                    <h5 class="fw-semibold mb-2">Pembayaran Mudah</h5>
                    <p class="text-muted" style="font-size: 0.95rem;">
                        Banyak metode pembayaran yang fleksibel & aman.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <h2 class="text-center fw-bold mb-4" style="font-size: 2rem;">Lokasi Toko Kami</h2>
        <div class="row align-items-start">
            <div class="col-md-6 mb-3">
                <div class="p-4 shadow-sm rounded-4 bg-white">
                    <h5 class="fw-semibold mb-2">Alamat</h5>
                    <p class="text-muted" style="line-height: 1.6; font-size: 1rem;">
                        Jl. Paus, Tangkerang Tengah, <br>
                        Kec. Marpoyan Damai, Kota Pekanbaru, Riau 28282 <br>
                        <strong>Telp:</strong> 0813-7120-9486
                    </p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="shadow rounded-4 overflow-hidden" style="height: 320px;">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3989.676019660362!2d101.43423387480247!3d0.48391139951135864!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31d5af5e32d63709%3A0xf474b06ffe293fb4!2sBotol%20Plastik%20Riau!5e0!3m2!1sid!2sid!4v1775547929862!5m2!1sid!2sid"
                        width="100%" height="100%" style="border:0;" allowfullscreen loading="lazy">
                    </iframe>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

<style>
    .hover-card {
        transition: transform .25s ease, box-shadow .25s ease;
    }
    .hover-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 6px 20px rgba(0,0,0,0.12);
    }
</style>