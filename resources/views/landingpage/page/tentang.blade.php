@extends('landingpage.layouts.main')
@section('title', 'Tentang Kami')
@section('navTentang', 'active')
@section('content')

<!-- PROFIL -->
<section class="py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6 mb-4 mb-md-0">
                <img src="{{ asset('storage/tentang.jpeg') }}" class="img-fluid rounded-4" alt="Tentang Kami">
            </div>
            <div class="col-md-6">
                <h3 class="fw-bold mb-3">Profil Botol Plastik Riau</h3>
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
</section>

<section class="py-5">
    <div class="container">
        <h4 class="fw-bold text-center mb-4">Komitmen Kami</h4>

        <div class="row text-center">
            <div class="col-md-4">
                <div class="p-4 shadow-sm rounded-4 h-100 bg-white">
                    <i class="bi bi-shield-check fs-2 mb-2" style="color:#1b2a41;"></i>
                    <p class="mb-0">Menjaga kualitas produk</p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="p-4 shadow-sm rounded-4 h-100 bg-white">
                    <i class="bi bi-emoji-smile fs-2 mb-2" style="color:#1b2a41;"></i>
                    <p class="mb-0">Memberikan pelayanan terbaik</p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="p-4 shadow-sm rounded-4 h-100 bg-white">
                    <i class="bi bi-box-seam fs-2 mb-2" style="color:#1b2a41;"></i>
                    <p class="mb-0">Menyediakan produk sesuai kebutuhan</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- VISI MISI -->
<section>
    <div class="container">
        <h3 class="text-center fw-bold mb-4">Visi & Misi Kami</h3>
        <div class="row">
            <div class="col-md-6 mb-4 mb-md-0">
                <div class="p-4 bg-white rounded-4 shadow-sm h-100">
                    <h5 class="fw-semibold mb-2">Visi</h5>
                    <p class="text-muted">
                        Menjadi penyedia kemasan plastik terlengkap dan terpercaya di Sumatera dan seluruh Indonesia.
                    </p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="p-4 bg-white rounded-4 shadow-sm h-100">
                    <h5 class="fw-semibold mb-2">Misi</h5>
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

<!-- GALERI -->
<section class="py-5">
    <div class="container">
        <h4 class="text-center fw-bold mb-4">Galeri Kami</h4>
        <div class="row g-3">
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
    .back-btn-clean {
    display: inline-block;
    background-color: #0D1321; /* warna yang kamu kirim */
    color: #ffffff;
    padding: 12px 28px;
    border-radius: 8px;
    font-size: 16px;
    font-weight: 500;
    text-decoration: none;
    transition: 0.25s ease;
}

.back-btn-clean:hover {
    background-color: #162036;
    transform: translateY(-2px);
}
.galeri-card {
    width: 100%;
    height: 250px; /* tinggi sama semua */
    overflow: hidden;
    border-radius: 16px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.08);
}

.galeri-card img {
    width: 100%;
    height: 100%;
    object-fit: cover; /* ini kunci biar rapi */
}
</style>