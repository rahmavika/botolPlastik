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