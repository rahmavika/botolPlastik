@extends('landingpage.layouts.main')
@section('content')

<div class="section-header-advanced mt-5 mb-4">
    <div class="left">
        <h4>Semua Produk</h4>
        <span>Koleksi terbaik untuk kebutuhan Anda</span>
    </div>
    <div class="right-group">
        <form action="{{ url('/semuaproduk') }}" method="GET" class="search-modern">
            <i class="bi bi-search search-icon"></i>

            <input type="text"
                name="search"
                class="search-modern-input"
                placeholder="Cari produk..."
                value="{{ request('search') }}">
            <button type="submit" class="search-modern-btn">
                Cari
            </button>
        </form>
    </div>
</div>

<div class="tab-content">
    <div class="tab-pane fade show active">
        <div class="row row-cols-2 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-5 g-4">
        @forelse($produks as $produk)
        <div class="col">
            <div class="product-card-modern">
                @if(!isset($produk->stok) || $produk->stok->jumlah_stok == 0)
                    <span class="badge-habis">Habis</span>
                @endif
                <div class="product-img-modern">
                    <img src="{{ asset('storage/' . $produk->gambar) }}">
                </div>
                <div class="product-body-modern">
                    <h6 class="product-title-modern">
                        {{ $produk->nama_produk }}
                    </h6>
                    <small class="text-muted">
                        {{ $produk->satuan->satuan ?? '-' }}
                    </small>
                    <p class="product-desc-modern">
                        {{ $produk->keterangan }}
                    </p>
                    <small class="text-muted d-block">
                        Stok: <span class="fw-semibold text-dark">
                            {{ $produk->stok->jumlah_stok ?? 0 }}
                        </span>
                    </small>
                    <div class="price-modern">
                        Rp {{ number_format($produk->harga, 0, ',', '.') }}
                    </div>
                    <div class="bottom-section">
                        <div class="qty-box-modern">
                            <button type="button" class="minus"
                                @if(!Auth::check()) data-bs-toggle="modal" data-bs-target="#loginModalInfo" @endif>-</button>
                            <span class="qty-display" data-id="{{ $produk->id }}">1</span>
                            <button type="button" class="plus"
                                data-max="{{ $produk->stok->jumlah_stok ?? 0 }}"
                                @if(!Auth::check()) data-bs-toggle="modal" data-bs-target="#loginModalInfo" @endif>+</button>
                        </div>
                        <form action="{{ route('keranjangs.store') }}" method="POST" id="form-{{ $produk->id }}">
                            @csrf
                            <input type="hidden" name="produk_id" value="{{ $produk->id }}">
                            <input type="hidden" name="jumlah" value="1" class="qty-input" data-id="{{ $produk->id }}">
                            <button type="submit"
                                onclick="return addToCart(event, {{ $produk->id }})"
                                class="btn-cart-modern"
                                @if(!Auth::check() || (isset($produk->stok) && $produk->stok->jumlah_stok == 0))
                                    data-bs-toggle="modal" data-bs-target="#loginModalInfo"
                                @endif>
                                <i class="bi bi-cart-plus"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @empty
            <p class="text-center text-danger">Produk tidak tersedia</p>
        @endforelse
        </div>
    </div>
</div>

<div class="modal fade" id="loginModalInfo" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content modal-info">
            <div class="modal-body text-center p-4">
                <div class="icon-box mb-3">
                    <i class="bi bi-exclamation-circle"></i>
                </div>
                <h5 class="fw-semibold mb-2">Akses Dibatasi</h5>
                <p class="text-muted small mb-4">
                    Silakan login terlebih dahulu untuk melanjutkan
                </p>
                <div class="d-flex justify-content-center">
                    <button class="btn-login"
                        data-bs-toggle="modal"
                        data-bs-target="#loginModal"
                        data-bs-dismiss="modal">
                        Login Sekarang
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="confirmModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content modal-success">
            <div class="modal-body text-center p-4">
                <div class="success-icon mb-3">
                    <i class="bi bi-check-circle-fill"></i>
                </div>
                <h5 class="fw-bold mb-2">Berhasil!</h5>
                <p class="text-muted small mb-4">
                    Produk berhasil ditambahkan ke keranjang
                </p>
                <div class="d-flex gap-2">
                    <button class="btn btn-outline-dark w-50"
                            data-bs-dismiss="modal">
                        Lanjut Belanja
                    </button>
                    <a href="/keranjang" class="btn btn-dark w-50">
                        Lihat Keranjang
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function addToCart(e, id) {
        @if(!Auth::check())
            e.preventDefault();
            return false;
        @endif
        e.preventDefault();
        let form = document.getElementById('form-' + id);
        fetch(form.action, {
            method: 'POST',
            body: new FormData(form),
            headers: {
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
            }
        })
        .then(res => {
            if (res.ok) {
                new bootstrap.Modal(document.getElementById('confirmModal')).show();
            }
        });
    }
    document.querySelectorAll('.minus').forEach(btn => {
        btn.addEventListener('click', function () {
            let parent = btn.closest('.product-card-modern');
            let display = parent.querySelector('.qty-display');
            let id = display.dataset.id;
            let input = parent.querySelector(`.qty-input[data-id="${id}"]`);
            let val = parseInt(display.innerText);
            if (val > 1) {
                val--;
                display.innerText = val;
                input.value = val;
            }
        });
    });
    document.querySelectorAll('.plus').forEach(btn => {
        btn.addEventListener('click', function () {
            let parent = btn.closest('.product-card-modern');
            let display = parent.querySelector('.qty-display');
            let id = display.dataset.id;
            let input = parent.querySelector(`.qty-input[data-id="${id}"]`);
            let val = parseInt(display.innerText);
            let max = parseInt(btn.getAttribute('data-max'));
            if (val < max) {
                val++;
                display.innerText = val;
                input.value = val;
            }
        });
    });
</script>

<style>
    body {
        background: #f5f7fa;
    }
    .section-header-advanced {
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-bottom: 1px solid #e5e7eb;
        padding-bottom: 10px;
    }
    .section-header-advanced .left h4 {
        margin: 0;
        font-weight: 600;
        color: #111827;
        font-size: 18px;
    }
    .section-header-advanced .left span {
        font-size: 12px;
        color: #6b7280;
    }
    .search-modern {
        display: flex;
        align-items: center;
        background: #f5f5f5;
        border-radius: 50px;
        padding: 5px;
        width: 100%;
        max-width: 420px;
        border: 1px solid #e5e7eb;
        transition: 0.3s;
    }
    .search-modern:focus-within {
        background: #fff;
        border-color: #072258;
        box-shadow: 0 0 0 4px rgba(7, 34, 88, 0.08);
    }
    .search-modern {
        display: flex;
        align-items: center;
        background: #f5f5f5;
        border-radius: 40px;
        padding: 2px 4px;
        width: 100%;
        max-width: 280px;
        border: 1px solid #e5e7eb;
        transition: 0.3s;
    }
    .search-modern:focus-within {
        background: #fff;
        border-color: #072258;
        box-shadow: 0 0 0 3px rgba(7, 34, 88, 0.08);
    }
    .search-icon {
        color: #9ca3af;
        font-size: 12px;
        margin-left: 10px;
        margin-right: 5px;
    }
    .search-modern-input {
        flex: 1;
        border: none;
        background: transparent;
        outline: none;
        font-size: 12px;
        padding: 6px 0;
        color: #111827;
    }
    .search-modern-input::placeholder {
        color: #9ca3af;
    }
    .search-modern-btn {
        border: none;
        background: #072258;
        color: white;
        border-radius: 30px;
        padding: 6px 12px;
        font-size: 11px;
        font-weight: 500;
        transition: 0.3s;
    }
    .search-modern-btn:hover {
        background: #0a2f78;
    }
    @media (max-width: 576px) {
        .search-modern {
            max-width: 220px;
        }
        .search-modern-btn {
            padding: 5px 10px;
            font-size: 10px;
        }
        .search-modern-input {
            font-size: 11px;
        }
    }
    .product-card-modern {
        background: #fff;
        border-radius: 10px; /* 🔥 lebih formal */
        border: 1px solid #e5e7eb;
        overflow: hidden;
        transition: 0.2s;
        display: flex;
        flex-direction: column;
        height: 100%;
        position: relative;
    }
    .badge-habis {
        position: absolute;
        top: 10px;
        left: 10px;
        z-index: 5;
        background: #dc2626;
        color: #fff;
        font-size: 11px;
        padding: 4px 8px;
        border-radius: 6px;
    }
    .product-card-modern:hover {
        transform: translateY(-3px);
    }
    .product-img-modern {
        height: 160px;
        background: #f9fafb;
    }
    .product-img-modern img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 0; /* 🔥 hilangkan lengkung */
    }
    .product-body-modern {
        padding: 12px;
        display: flex;
        flex-direction: column;
        gap: 5px;
    }
    .product-title-modern {
        font-size: 14px;
        font-weight: 600;
        min-height: 34px;
        color: #111827;
    }
    .product-desc-modern {
        font-size: 12px;
        color: #6b7280;
        height: 28px;
        overflow: hidden;
    }
    .price-modern {
        font-weight: 600;
        color: #072258;
        font-size: 14px;
    }
    .bottom-section {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: auto;
    }
    .qty-box-modern {
        display: flex;
        align-items: center;
        gap: 6px;
        background: #f3f4f6;
        padding: 3px 6px;
        border-radius: 6px; /* 🔥 lebih kecil */
    }
    .qty-box-modern button {
        border: none;
        background: transparent;
        font-weight: 600;
        cursor: pointer;
        font-size: 13px;
    }
    .btn-cart-modern {
        background: #072258;
        border: none;
        color: white;
        width: 34px;
        height: 34px;
        border-radius: 6px; /* 🔥 dari bulat jadi kotak soft */
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .btn-cart-modern:hover {
        background: #051a45;
    }
    .badge-habis {
        position: absolute;
        top: 8px;
        left: 8px;
        background: #dc2626;
        color: #fff;
        font-size: 11px;
        padding: 3px 6px;
        border-radius: 4px; /* 🔥 kecil */
    }
    .modal-info,
    .modal-success {
        border-radius: 10px;
        border: none;
    }
    .icon-box i {
        font-size: 28px;
        color: #f59e0b;
    }
    .success-icon i {
        font-size: 32px;
        color: #16a34a;
    }
    .btn-login {
        background: #072258;
        color: white;
        border: none;
        padding: 8px 16px;
        border-radius: 6px;
    }
    .btn-login:hover {
        background: #051a45;
    }
    .product-card-modern:has(.badge-habis) {
        pointer-events: none;
        opacity: 0.7;
    }
    .product-card-modern:has(.badge-habis) .badge-habis {
        pointer-events: auto;
    }
</style>
@endsection