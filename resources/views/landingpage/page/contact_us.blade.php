@extends('landingpage.layouts.main')

@section('content')

<style>
    /* Hero Section */
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

    /* Glass Card */
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

    /* Form */
    .form-control {
        border-radius: 14px;
        padding: 12px 14px;
    }
    .form-control:focus {
        border-color: #1e3f66 !important;
        box-shadow: 0 0 0 0.2rem rgba(30, 63, 102, .25);
    }

    /* FAQ Styles */
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

    /* Buttons */
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
{{-- Contact Form + FAQ --}}
<section class="py-5">
    <div class="container">
        <div class="row g-4">

            <!-- KIRI: FORM -->
            <div class="col-lg-6">
                <div class="glass-card">
                    <h4 class="fw-bold mb-4 border-bottom pb-2" style="color:#1b2a41;">
                        <i class="bi bi-envelope-fill me-2"></i> Hubungi Kami
                    </h4>

                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
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

            <!-- KANAN: FAQ + INFO -->
            <div class="col-lg-6">

                <!-- FAQ -->
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

                <!-- INFO KONTAK -->
                <div class="glass-card mb-3">
                    <h5 class="fw-bold mb-3">Info Kontak</h5>
                    <p><i class="bi bi-telephone"></i> 0813-7120-9486</p>
                    <p><i class="bi bi-envelope"></i>  plastikbotol491@gmail.com</p>
                    <p><i class="bi bi-geo-alt"></i> Pekanbaru, Riau</p>
                </div>

                <!-- WA BUTTON -->
                <a href="https://wa.me/6281371209486" target="_blank"
                   class="btn w-100 rounded-pill mb-3"
                   style="background:#1b2a41; color:white;">
                    <i class="bi bi-whatsapp"></i> Chat WhatsApp
                </a>

                <!-- JAM OPERASIONAL -->
                <div class="glass-card">
                    <h5 class="fw-bold mb-3">Jam Operasional</h5>
                    <p class="mb-1">Setiap Hari: 10.00 - 22.00</p>
                </div>

            </div>

        </div>

        <!-- CTA -->
        <div class="text-center mt-5">
            <h5 class="fw-bold">Butuh bantuan cepat?</h5>
            <p class="text-muted">Tim kami siap membantu Anda</p>
        </div>

    </div>
</section>
@endsection