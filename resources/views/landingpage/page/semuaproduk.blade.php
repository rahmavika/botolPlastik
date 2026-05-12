@extends('landingpage.layouts.main')
@section('content')

<style>
    .page-wrapper{
        position: relative;
        padding: 40px 0 60px;
        overflow: hidden;
        z-index: 1;
    }
    .page-wrapper::before{
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
    .page-wrapper::after{
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
    .section-header-advanced {
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-bottom: 1px solid rgba(255,255,255,0.4);
        padding-bottom: 10px;
        margin-bottom: 25px;
    }
    .section-header-advanced .left h4 {
        margin: 0;
        font-weight: 700;
        color: #111827;
        font-size: 22px;
    }
    .section-header-advanced .left span {
        font-size: 13px;
        color: #4b5563;
    }
    .search-modern {
        display: flex;
        align-items: center;
        background: rgba(255,255,255,0.8);
        backdrop-filter: blur(8px);
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
    .product-card-modern {
        background: rgba(255,255,255,0.92);
        backdrop-filter: blur(6px);
        border-radius: 12px;
        border: 1px solid rgba(255,255,255,0.4);
        overflow: hidden;
        transition: 0.25s ease;
        display: flex;
        flex-direction: column;
        height: 100%;
        position: relative;
        box-shadow: 0 8px 24px rgba(0,0,0,0.06);
    }
    .product-card-modern:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 28px rgba(0,0,0,0.10);
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
    .product-img-modern {
        height: 170px;
        background: #f9fafb;
    }
    .product-img-modern img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .product-body-modern {
        padding: 14px;
        display: flex;
        flex-direction: column;
        gap: 5px;
    }
    .product-title-modern {
        font-size: 14px;
        font-weight: 700;
        min-height: 36px;
        color: #111827;
    }
    .product-desc-modern {
        font-size: 12px;
        color: #6b7280;
        height: 32px;
        overflow: hidden;
    }
    .price-modern {
        font-weight: 700;
        color: #072258;
        font-size: 15px;
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
        padding: 4px 7px;
        border-radius: 8px;
    }
    .qty-box-modern button {
        border: none;
        background: transparent;
        font-weight: 700;
        cursor: pointer;
        font-size: 13px;
    }
    .btn-cart-modern {
        background: #072258;
        border: none;
        color: white;
        width: 36px;
        height: 36px;
        border-radius: 8px;
        display: flex;
        justify-content: center;
        align-items: center;
        transition: .3s;
    }
    .btn-cart-modern:hover {
        background: #051a45;
    }
    .modal-info,
    .modal-success {
        border-radius: 12px;
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
        border-radius: 8px;
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
</style>

<div class="page-wrapper">
    <div class="container">
        <div class="section-header-advanced mt-5 mb-4">
            <div class="left">
                <h4>Semua Produk</h4>
                <span>Koleksi terbaik untuk kebutuhan Anda</span>
            </div>
            <div class="right-group">
                <form action="{{ url('/semuaproduk') }}" method="GET" class="search-modern">
                    <i class="bi bi-search search-icon"></i>
                    <input type="text" name="search" class="search-modern-input" placeholder="Cari produk..." value="{{ request('search') }}">
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
                                    Stok:
                                    <span class="fw-semibold text-dark">
                                        {{ $produk->stok->jumlah_stok ?? 0 }}
                                    </span>
                                </small>
                                <div class="price-modern">
                                    Rp {{ number_format($produk->harga, 0, ',', '.') }}
                                </div>
                                <div class="bottom-section">
                                    <div class="qty-box-modern">
                                        <button type="button" class="minus">-</button>
                                        <span class="qty-display" data-id="{{ $produk->id }}">
                                            1
                                        </span>
                                        <button type="button" class="plus" data-max="{{ $produk->stok->jumlah_stok ?? 0 }}">
                                            +
                                        </button>
                                    </div>
                                    <form action="{{ route('keranjangs.store') }}"
                                          method="POST"
                                          id="form-{{ $produk->id }}">
                                        @csrf
                                        <input type="hidden" name="produk_id" value="{{ $produk->id }}">
                                        <input type="hidden" name="jumlah" value="1" class="qty-input" data-id="{{ $produk->id }}">
                                        <button type="submit" onclick="return addToCart(event, {{ $produk->id }})" class="btn-cart-modern">
                                            <i class="bi bi-cart-plus"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <p class="text-center text-danger">
                        Produk tidak tersedia
                    </p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

@endsection