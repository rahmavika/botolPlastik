@extends('landingpage.layouts.main')
@section('content')

<style>
    .hero-section-custom {
        background: linear-gradient(135deg, #cfe7ff, #ffffff);
        padding: 90px 0;
    }
    .hero-title {
        font-weight: 800;
        font-size: 3.2rem;
        color: #1e3f66;
        line-height: 1.2;
    }
    .hero-highlight {
        color: #0077c8;
        font-weight: 900;
    }
    .hero-subtitle {
        font-size: 1.15rem;
        color: #4d648d;
    }
    .glass-card {
        background: rgba(255, 255, 255, 0.78);
        backdrop-filter: blur(14px);
        border-radius: 20px;
        box-shadow: 0 10px 26px rgba(0, 0, 0, 0.07);
        padding: 28px;
        transition: all .3s ease;
    }
    .glass-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 16px 30px rgba(0, 0, 0, 0.1);
    }
    .form-control {
        border-radius: 14px;
        padding: 12px 14px;
    }
    .form-control:focus {
        border-color: #1e3f66 !important;
        box-shadow: 0 0 0 0.2rem rgba(30, 63, 102, .25);
    }
    .faq-title-icon {
        color: #1e3f66;
        margin-right: 6px;
        font-size: 1.4rem;
    }
    .accordion-button {
        background: #eff5ff;
        font-weight: 600;
        border: none;
        border-radius: 10px !important;
        padding: 12px;
        color: #1e3f66;
    }
    .accordion-button:not(.collapsed) {
        background: #d9e9ff;
        color: #1e3f66;
    }
    .accordion-item {
        border: none !important;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        margin-bottom: 8px;
    }
    .btn-custom {
        background-color: #1e3f66;
        color: white;
        border-radius: 50px;
        padding: 10px 26px;
        font-weight: 600;
        transition: .3s ease;
    }
    .btn-custom:hover {
        background-color: #16324d;
    }
</style>

<section class="py-5">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-6">
                <div class="glass-card">
                    <h4 class="fw-bold mb-4 border-bottom pb-2" style="color:#1b2a41;">
                        <i class="bi bi-envelope-fill me-2"></i> Hubungi Kami
                    </h4>
                    @if(session('contact_success'))
                        <div class="alert alert-success">{{ session('contact_success') }}</div>
                    @endif
                    <form action="{{ route('contact_us.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Nama</label>
                            <input type="text" name="nama" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Email</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Pesan</label>
                            <textarea name="pertanyaan" rows="4" class="form-control" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-custom">
                            Kirim Pesan
                        </button>
                    </form>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="glass-card mb-4">
                    <h4 class="fw-bold mb-4 border-bottom pb-2">
                        <i class="bi bi-question-circle-fill"></i> FAQ
                    </h4>
                    @if($faqs->count())
                        <div class="accordion" id="faqAccordion">
                            @foreach ($faqs as $index => $faq)
                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button collapsed" type="button"
                                                data-bs-toggle="collapse"
                                                data-bs-target="#collapse{{ $index }}">
                                            {{ $faq->pertanyaan }}
                                        </button>
                                    </h2>
                                    <div id="collapse{{ $index }}" class="accordion-collapse collapse">
                                        <div class="accordion-body text-muted">
                                            {{ $faq->jawaban ?? '-' }}
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
                <div class="glass-card mb-3">
                    <h5 class="fw-bold mb-3">Info Kontak</h5>
                    <p><i class="bi bi-telephone"></i> 0813-7120-9486</p>
                    <p><i class="bi bi-envelope"></i>  plastikbotol491@gmail.com</p>
                    <p><i class="bi bi-geo-alt"></i> Pekanbaru, Riau</p>
                </div>
                <a href="https://wa.me/6281371209486" target="_blank"
                   class="btn w-100 rounded-pill mb-3"
                   style="background:#1b2a41; color:white;">
                    <i class="bi bi-whatsapp"></i> Chat WhatsApp
                </a>
                <div class="glass-card">
                    <h5 class="fw-bold mb-3">Jam Operasional</h5>
                    <p class="mb-1">Setiap Hari: 10.00 - 22.00</p>
                </div>
            </div>
        </div>
        <div class="text-center mt-5">
            <h5 class="fw-bold">Butuh bantuan cepat?</h5>
            <p class="text-muted">Tim kami siap membantu Anda</p>
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
        </h2>
    </div>
</section>

@endsection