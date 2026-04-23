@extends('landingpage.layouts.main')

@section('content')
<section class="py-5" style="background:#f5f7fb;">
    <div class="container">

        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-4">

                <!-- TITLE -->
                <h4 class="fw-semibold mb-4" style="color:#1e3f66;">
                    🛒 Keranjang Belanja
                </h4>

                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead class="text-muted" style="font-size: 0.85rem;">
                            <tr>
                                <th class="text-center">
                                    <input type="checkbox" id="checkAll">
                                </th>
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

                            <tr class="border-top">
                                <!-- CHECKBOX -->
                                <td class="text-center">
                                    <input type="checkbox"
                                           class="check-item"
                                           name="selected_items[]"
                                           form="checkoutForm"
                                           value="{{ $keranjang->id }}"
                                           data-total="{{ $keranjang->jumlah * $keranjang->harga }}"
                                           {{ $keranjang->jumlah > $stokTersedia ? 'disabled' : '' }}>
                                </td>

                                <!-- PRODUK -->
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="{{ asset('storage/' . $keranjang->produk->gambar) }}"
                                             class="rounded-3 shadow-sm"
                                             style="width:70px; height:70px; object-fit:cover;">

                                        <div class="ms-3">
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

                                <!-- JUMLAH -->
                                <td class="text-center">
                                    <form action="{{ route('keranjangs.update', $keranjang->id) }}"
                                          method="POST"
                                          class="d-flex justify-content-center align-items-center gap-2">
                                        @csrf
                                        @method('PUT')

                                        <button name="action" value="decrease"
                                            class="btn btn-light border rounded-circle"
                                            style="width:32px; height:32px;"
                                            {{ $keranjang->jumlah <= 1 ? 'disabled' : '' }}>
                                            -
                                        </button>

                                        <span class="fw-semibold">
                                            {{ $keranjang->jumlah }}
                                        </span>

                                        <button name="action" value="increase"
                                            class="btn btn-light border rounded-circle"
                                            style="width:32px; height:32px;"
                                            {{ $keranjang->jumlah >= $stokTersedia ? 'disabled' : '' }}>
                                            +
                                        </button>
                                    </form>
                                </td>

                                <!-- HARGA -->
                                <td class="text-center text-muted">
                                    Rp {{ number_format($keranjang->harga, 0, ',', '.') }}
                                </td>

                                <!-- TOTAL -->
                                <td class="text-center fw-semibold">
                                    Rp {{ number_format($keranjang->jumlah * $keranjang->harga, 0, ',', '.') }}
                                </td>

                                <!-- HAPUS -->
                                <td class="text-center">
                                    <form action="{{ route('keranjangs.destroy', $keranjang->id) }}"
                                          method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button"
                                                class="btn btn-sm btn-outline-danger rounded-circle btn-delete"
                                                data-id="{{ $keranjang->id }}">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>

                <!-- EMPTY STATE -->
                @if($keranjangs->isEmpty())
                    <div class="text-center py-5">
                        <i class="bi bi-cart-x" style="font-size: 40px; color:#ccc;"></i>
                        <p class="mt-3 text-muted">Keranjang masih kosong</p>

                        <a href="/semuaproduk" class="btn btn-primary px-4">
                            Belanja Sekarang
                        </a>
                    </div>
                @else

                <!-- FORM CHECKOUT (DIPINDAH KE SINI) -->
                <form action="/checkout" method="GET" id="checkoutForm">

                    <div class="d-flex justify-content-between align-items-center mt-4 flex-wrap gap-3">

                        <h5 class="fw-bold mb-0">
                            Total:
                            <span id="totalHarga" style="color:#0d6efd;">
                                Rp 0
                            </span>
                        </h5>

                        <button type="submit"
                           id="btnCheckout"
                           class="btn px-4 py-2 {{ $stokKurang ? 'disabled' : '' }}"
                           style="background:#0d6efd; color:#fff; border-radius:10px;"
                           disabled>
                            Checkout
                        </button>

                    </div>

                </form>

                @endif

            </div>
        </div>

    </div>
</section>
@endsection
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {

    // DELETE
    document.querySelectorAll('.btn-delete').forEach(button => {
        button.addEventListener('click', function () {
            let form = this.closest('form');

            Swal.fire({
                title: 'Hapus produk ini?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'OK',
                cancelButtonText: 'Cancel',
                customClass: {
                    popup: 'custom-card-shape',
                    title: 'fs-6',
                    confirmButton: 'btn btn-primary btn-sm px-3',
                    cancelButton: 'btn btn-secondary btn-sm px-3'
                },
                buttonsStyling: false
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });

    // CHECKBOX LOGIC
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

});
</script>

<style>
.custom-card-shape {
    border-radius: 14px !important;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15) !important;
    padding: 20px !important;
}

.custom-card-shape .swal2-actions {
    justify-content: flex-end;
    gap: 10px;
}
</style>