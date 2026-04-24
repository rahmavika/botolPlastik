@extends('landingpage.layouts.main')

@section('content')

<style>
    body {
        background: #f5f7fa;
    }

    .card-clean {
        background: #fff;
        border-radius: 10px;
        border: 1px solid #e5e7eb;
    }

    .title-clean {
        font-weight: 600;
        color: #111827;
        font-size: 18px;
    }

    /* TABLE */
    .table-clean thead th {
        font-size: 13px;
        text-transform: uppercase;
        background: #f9fafb;
        color: #6b7280;
        text-align: center;
    }

    .table-clean td {
        font-size: 14px;
        color: #374151;
        text-align: center;
        vertical-align: middle;
        border-bottom: 1px solid #f1f5f9;
    }

    .table-clean tbody tr:hover {
        background: #f9fafb;
    }

    .product-img {
        width: 65px;
        height: 65px;
        object-fit: cover;
        border-radius: 8px;
    }

    /* BUTTON */
    .btn-clean {
        border-radius: 6px;
        font-size: 13px;
        padding: 5px 10px;
        border: 1px solid #d1d5db;
        background: white;
    }

    .btn-clean:hover {
        background: #f3f4f6;
    }

    .btn-primary-clean {
        background: #1d4ed8;
        color: white;
        border-radius: 6px;
        padding: 8px 18px;
        border: none;
    }

    .btn-primary-clean:hover {
        background: #1e40af;
    }

    /* CHECKOUT BUTTON (LEBIH KECIL & CLEAN) */
    .btn-checkout-clean {
        background: #1d4ed8;
        color: white;
        border-radius: 6px;
        padding: 6px 16px;
        font-size: 13px;
        border: none;
    }

    .btn-checkout-clean:hover {
        background: #1e40af;
    }

    /* QTY */
    .qty-btn {
        width: 30px;
        height: 30px;
        border-radius: 6px;
        border: 1px solid #d1d5db;
        background: white;
    }

    /* DELETE */
    .btn-delete {
        border-radius: 6px;
        border: 1px solid #fecaca;
        color: #b91c1c;
        background: #fff;
    }

    .btn-delete:hover {
        background: #fee2e2;
    }
</style>

<section class="py-5">
    <div class="container">

        <div class="card card-clean p-4">

            <h4 class="title-clean mb-4">
                Keranjang Belanja
            </h4>

            <div class="table-responsive">
                <table class="table table-clean align-middle">

                    <thead>
                        <tr>
                            <th><input type="checkbox" id="checkAll"></th>
                            <th>Produk</th>
                            <th class="text-center">Jumlah</th>
                            <th class="text-center">Harga</th>
                            <th class="text-center">Total</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>

                        @php $stokKurang = false; @endphp

                        @foreach($keranjangs as $keranjang)
                        @php
                            $stokTersedia = $keranjang->produk->stok->jumlah_stok ?? 0;
                            if($keranjang->jumlah > $stokTersedia) {
                                $stokKurang = true;
                            }
                        @endphp

                        <tr>

                            {{-- CHECKBOX --}}
                            <td>
                                <input type="checkbox"
                                    class="check-item"
                                    name="selected_items[]"
                                    form="checkoutForm"
                                    value="{{ $keranjang->id }}"
                                    data-total="{{ $keranjang->jumlah * $keranjang->harga }}"
                                    {{ $keranjang->jumlah > $stokTersedia ? 'disabled' : '' }}>
                            </td>

                            {{-- PRODUK --}}
                            <td class="text-start">
                                <div class="d-flex align-items-center gap-3">
                                    <img src="{{ asset('storage/' . $keranjang->produk->gambar) }}" class="product-img">

                                    <div>
                                        <div class="fw-semibold">
                                            {{ $keranjang->produk->nama_produk }}
                                        </div>

                                        @if($keranjang->jumlah > $stokTersedia)
                                            <small class="text-danger">
                                                Stok tersisa {{ $stokTersedia }}
                                            </small>
                                        @endif
                                    </div>
                                </div>
                            </td>

                            {{-- JUMLAH --}}
                            <td>
                                <form action="{{ route('keranjangs.update', $keranjang->id) }}"
                                    method="POST"
                                    class="d-flex justify-content-center align-items-center gap-2">
                                    @csrf
                                    @method('PUT')

                                    <button name="action" value="decrease"
                                        class="qty-btn"
                                        {{ $keranjang->jumlah <= 1 ? 'disabled' : '' }}>
                                        -
                                    </button>

                                    <span class="fw-semibold">
                                        {{ $keranjang->jumlah }}
                                    </span>

                                    <button name="action" value="increase"
                                        class="qty-btn"
                                        {{ $keranjang->jumlah >= $stokTersedia ? 'disabled' : '' }}>
                                        +
                                    </button>
                                </form>
                            </td>

                            {{-- HARGA --}}
                            <td>
                                Rp {{ number_format($keranjang->harga, 0, ',', '.') }}
                            </td>

                            {{-- TOTAL --}}
                            <td class="fw-semibold">
                                Rp {{ number_format($keranjang->jumlah * $keranjang->harga, 0, ',', '.') }}
                            </td>

                            {{-- HAPUS --}}
                            <td>
                                <form action="{{ route('keranjangs.destroy', $keranjang->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')

                                    <button type="button"
                                        class="btn-delete btn-delete-trigger">
                                        🗑
                                    </button>
                                </form>
                            </td>

                        </tr>
                        @endforeach

                    </tbody>

                </table>
            </div>

            @if($keranjangs->isEmpty())
                <div class="text-center py-5">
                    <p class="text-muted">Keranjang masih kosong</p>
                    <a href="/semuaproduk" class="btn-primary-clean">Belanja</a>
                </div>
            @else

            <form action="/checkout" method="GET" id="checkoutForm">

                <div class="d-flex justify-content-between align-items-center mt-4 flex-wrap gap-3">

                    <!-- TOTAL (LEBIH KECIL & CLEAN) -->
                    <div style="font-size:14px; color:#6b7280;">
                        Total:
                        <span id="totalHarga" style="font-weight:600; color:#111827;">
                            Rp 0
                        </span>
                    </div>

                    <!-- CHECKOUT BUTTON -->
                    <button type="submit"
                        id="btnCheckout"
                        class="btn-checkout-clean"
                        {{ $stokKurang ? 'disabled' : '' }}>
                        Checkout
                    </button>

                </div>

            </form>

            @endif

        </div>
    </div>
</section>

@endsection

{{-- JS --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const checkAll = document.getElementById('checkAll');
    const items = document.querySelectorAll('.check-item');
    const totalText = document.getElementById('totalHarga');
    const btnCheckout = document.getElementById('btnCheckout');

    function updateTotal() {
        let total = 0;
        let checked = 0;

        items.forEach(item => {
            if (item.checked) {
                total += parseInt(item.dataset.total);
                checked++;
            }
        });

        totalText.innerText = 'Rp ' + total.toLocaleString('id-ID');

        btnCheckout.disabled = checked === 0;
    }

    checkAll.addEventListener('change', function () {
        items.forEach(item => {
            if (!item.disabled) {
                item.checked = this.checked;
            }
        });
        updateTotal();
    });

    items.forEach(item => {
        item.addEventListener('change', updateTotal);
    });

    updateTotal();

    // DELETE ALERT
    document.querySelectorAll('.btn-delete-trigger').forEach(button => {
        button.addEventListener('click', function () {
            let form = this.closest('form');

            Swal.fire({
                title: 'Hapus produk ini?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'OK',
                cancelButtonText: 'Cancel',
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });

});
</script>