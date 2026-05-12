@extends('landingpage.layouts.main')
@section('title', 'Tentang Kami')
@section('navTentang', 'active')

@section('content')

<style>
    .about-wrapper{
        position: relative;
        padding: 40px 0 60px;
        overflow: hidden;
        z-index: 1;
    }
    .about-wrapper::before{
        content: '';
        position: absolute;
        inset: 0;
        background-image: url('/storage/image.png');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        background-attachment: fixed;
        z-index: -2;
    }
    .about-wrapper::after{
        content: '';
        position: absolute;
        inset: 0;
        background: rgba(255,255,255,0.70);
        z-index: -1;
    }
    footer{
        position: relative;
        z-index: 5;
    }
    .glass-box{
        background: rgba(255,255,255,0.88);
        backdrop-filter: blur(8px);
        border-radius: 22px;
        box-shadow: 0 8px 24px rgba(0,0,0,0.06);
    }
    .section-title{
        font-weight: 800;
        color: #1b2a41;
    }
    .galeri-card {
        width: 100%;
        height: 250px;
        overflow: hidden;
        border-radius: 18px;
        box-shadow: 0 4px 14px rgba(0,0,0,0.08);
        transition: .3s ease;
        background: white;
    }
    .galeri-card:hover{
        transform: translateY(-5px);
        box-shadow: 0 10px 24px rgba(0,0,0,0.12);
    }
    .galeri-card img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .commit-card{
        background: rgba(255,255,255,0.9);
        backdrop-filter: blur(6px);
        border-radius: 20px;
        transition: .3s ease;
    }
    .commit-card:hover{
        transform: translateY(-5px);
        box-shadow: 0 10px 24px rgba(0,0,0,0.10);
    }
    .map-card{
        background: rgba(255,255,255,0.92);
        backdrop-filter: blur(8px);
        border-radius: 20px;
    }
    .about-image{
        border-radius: 24px;
        box-shadow: 0 10px 24px rgba(0,0,0,0.08);
    }
    ul li{
        margin-bottom: 8px;
    }
</style>

<div class="about-wrapper">
    <section class="py-5">
        <div class="container">
            <div class="glass-box p-4 p-md-5">
                <div class="row align-items-center">
                    <div class="col-md-6 mb-4 mb-md-0">
                        <img src="{{ asset('storage/tentang.jpeg') }}" class="img-fluid about-image" alt="Tentang Kami">
                    </div>
                    <div class="col-md-6">
                        <h3 class="fw-bold mb-3 section-title">
                            Profil Botol Plastik Riau
                        </h3>
                        <p class="text-muted">
                            <strong>Botol Plastik Riau</strong> adalah penyedia berbagai kebutuhan plastik dan packaging
                            yang berlokasi di Riau. Kami menyediakan botol plastik, jar, cup, tutup botol, serta berbagai
                            kemasan berkualitas untuk kebutuhan UMKM, rumah tangga, hingga industri.
                        </p>
                        <ul class="list-unstyled text-muted">
                            <li>✔ Koleksi lengkap botol dan kemasan berbagai ukuran</li>
                            <li>✔ Cocok untuk usaha kuliner, kosmetik, minuman, dan kebutuhan harian</li>
                            <li>✔ Harga kompetitif, tersedia eceran dan grosir</li>
                            <li>✔ Produk berkualitas dan aman digunakan</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="py-5">
        <div class="container">
            <h4 class="fw-bold text-center mb-5 section-title">
                Komitmen Kami
            </h4>
            <div class="row text-center g-4">
                <div class="col-md-4">
                    <div class="p-4 shadow-sm commit-card h-100">
                        <i class="bi bi-shield-check fs-2 mb-3"
                           style="color:#1b2a41;"></i>
                        <p class="mb-0 fw-semibold">
                            Menjaga kualitas produk
                        </p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="p-4 shadow-sm commit-card h-100">
                        <i class="bi bi-emoji-smile fs-2 mb-3"
                           style="color:#1b2a41;"></i>
                        <p class="mb-0 fw-semibold">
                            Memberikan pelayanan terbaik
                        </p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="p-4 shadow-sm commit-card h-100">
                        <i class="bi bi-box-seam fs-2 mb-3"
                           style="color:#1b2a41;"></i>
                        <p class="mb-0 fw-semibold">
                            Menyediakan produk sesuai kebutuhan
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="py-5">
        <div class="container">
            <h3 class="text-center fw-bold mb-5 section-title">
                Visi & Misi Kami
            </h3>
            <div class="row g-4">
                <div class="col-md-6">
                    <div class="glass-box p-4 h-100">
                        <h5 class="fw-semibold mb-3">
                            Visi
                        </h5>
                        <p class="text-muted">
                            Menjadi penyedia kemasan plastik terlengkap dan terpercaya
                            di Sumatera dan seluruh Indonesia.
                        </p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="glass-box p-4 h-100">
                        <h5 class="fw-semibold mb-3">
                            Misi
                        </h5>
                        <ul class="text-muted">
                            <li>✔ Menghadirkan produk plastik berkualitas tinggi dengan harga terbaik</li>
                            <li>✔ Memberikan pelayanan cepat, ramah, dan profesional kepada pelanggan</li>
                            <li>✔ Terus berinovasi dalam variasi produk serta sistem pemesanan online</li>
                            <li>✔ Menjadi mitra terpercaya bagi UMKM dan pelaku usaha di berbagai sektor</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="py-5">
        <div class="container">
            <h4 class="text-center fw-bold mb-5 section-title">
                Galeri Kami
            </h4>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="galeri-card">
                        <img src="/storage/toko1.png">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="galeri-card">
                        <img src="/storage/toko2.png">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="galeri-card">
                        <img src="/storage/toko3.png">
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="py-5">
        <div class="container">
            <h2 class="text-center fw-bold mb-5 section-title" style="font-size: 2rem;">
                Lokasi Toko Kami
            </h2>
            <div class="row align-items-start g-4">
                <div class="col-md-6">
                    <div class="p-4 shadow-sm map-card h-100">
                        <h5 class="fw-semibold mb-3">
                            Alamat
                        </h5>
                        <p class="text-muted" style="line-height: 1.8; font-size: 1rem;">
                            Jl. Paus, Tangkerang Tengah, <br>
                            Kec. Marpoyan Damai, Kota Pekanbaru, Riau 28282 <br>
                            <strong>Telp:</strong> 0813-7120-9486
                        </p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="shadow rounded-4 overflow-hidden"
                         style="height: 320px;">
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3989.676019660362!2d101.43423387480247!3d0.48391139951135864!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31d5af5e32d63709%3A0xf474b06ffe293fb4!2sBotol%20Plastik%20Riau!5e0!3m2!1sid!2sid!4v1775547929862!5m2!1sid!2sid"
                            width="100%"
                            height="100%"
                            style="border:0;"
                            allowfullscreen
                            loading="lazy">
                        </iframe>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

@endsection