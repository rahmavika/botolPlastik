@extends('landingpage.layouts.main')

@section('content')

<style>
    body {
        background: #f5f7fa;
    }

    /* CARD */
    .card-clean {
        background: #ffffff;
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
    }

    .table-clean tbody tr:hover {
        background: #f9fafb;
    }

    /* LINK */
    .link-date {
        color: #1d4ed8;
        text-decoration: none;
        font-weight: 500;
    }

    /* STATUS */
    .status {
        font-size: 12px;
        padding: 4px 10px;
        border-radius: 6px;
    }

    .status-menunggu { background: #fef2f2; color: #991b1b; }
    .status-proses   { background: #eff6ff; color: #1d4ed8; }
    .status-kirim    { background: #eef2ff; color: #3730a3; }
    .status-selesai  { background: #ecfdf5; color: #065f46; }

    .status-belum    { background: #fff7ed; color: #9a3412; }
    .status-lunas    { background: #ecfdf5; color: #065f46; }

    /* BUTTON */
    .btn-clean {
        font-size: 12px;
        padding: 5px 12px;
        border-radius: 6px;
        border: 1px solid #d1d5db;
        background: white;
    }

    .btn-primary-clean {
        font-size: 12px;
        padding: 5px 12px;
        border-radius: 6px;
        background: #1d4ed8;
        color: white;
        border: none;
    }

    /* MODAL */
    .modal-custom {
        display: none;
        position: fixed;
        z-index: 9999;
        padding-top: 60px;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0.7);
    }

    .modal-custom img {
        display: block;
        margin: auto;
        max-width: 80%;
        max-height: 80%;
        border-radius: 10px;
    }

    .close-btn {
        position: absolute;
        top: 20px;
        right: 30px;
        font-size: 30px;
        color: white;
        cursor: pointer;
    }
</style>

<section class="py-5">
    <div class="container">

        <div class="card card-clean p-4">

            <h4 class="text-center mb-4 title-clean">
                Riwayat Belanja
            </h4>

            <div class="table-responsive">
                <table class="table table-clean">

                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Total</th>
                            <th>Bukti</th>
                            <th>Status</th>
                            <th>Pembayaran</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($riwayatBelanja as $checkout)
                        <tr>

                            {{-- TANGGAL --}}
                            <td>
                                <a href="{{ route('checkout.detail', $checkout->id) }}" class="link-date">
                                    {{ \Carbon\Carbon::parse($checkout->tanggal_pemesanan)->format('d M Y') }}
                                </a>
                            </td>

                            {{-- TOTAL --}}
                            <td>
                                Rp {{ number_format($checkout->total_harga, 0, ',', '.') }}
                            </td>

                            {{-- BUKTI --}}
                            <td id="button-cell-{{ $checkout->id }}">
                                @if($checkout->bukti_transfer)
                                    <button class="btn-primary-clean"
                                        onclick="showPreview('{{ asset($checkout->bukti_transfer) }}')">
                                        Lihat
                                    </button>
                                @else
                                    <button class="btn-clean"
                                        onclick="document.getElementById('fileInput{{ $checkout->id }}').click()">
                                        Upload
                                    </button>

                                    <input type="file"
                                        id="fileInput{{ $checkout->id }}"
                                        style="display:none;"
                                        onchange="uploadBukti({{ $checkout->id }})">
                                @endif
                            </td>

                            {{-- STATUS --}}
                            <td>
                                @switch($checkout->status)
                                    @case('menunggu_konfirmasi')
                                        <span class="status status-menunggu">Menunggu</span>
                                    @break
                                    @case('diproses')
                                        <span class="status status-proses">Diproses</span>
                                    @break
                                    @case('dikirim')
                                        <span class="status status-kirim">Dikirim</span>
                                    @break
                                    @case('selesai')
                                        <span class="status status-selesai">Selesai</span>
                                    @break
                                @endswitch
                            </td>

                            {{-- PEMBAYARAN --}}
                            <td>
                                @switch($checkout->status_pembayaran)
                                    @case('belum_lunas')
                                        <span class="status status-belum">Belum Bayar</span>
                                    @break
                                    @case('lunas')
                                        <span class="status status-lunas">Lunas</span>
                                    @break
                                @endswitch
                            </td>

                        </tr>
                        @endforeach
                    </tbody>

                </table>
            </div>

            <div class="mt-4 text-center">
                {{ $riwayatBelanja->links('pagination::bootstrap-5') }}
            </div>

        </div>

    </div>
</section>

{{-- MODAL PREVIEW --}}
<div id="previewModal" class="modal-custom">
    <span class="close-btn" onclick="closePreview()">×</span>
    <img id="previewImage">
</div>

<script>
function showPreview(url) {
    document.getElementById('previewImage').src = url;
    document.getElementById('previewModal').style.display = 'block';
}

function closePreview() {
    document.getElementById('previewModal').style.display = 'none';
}

/* klik luar */
window.onclick = function(e) {
    let modal = document.getElementById('previewModal');
    if (e.target === modal) {
        modal.style.display = "none";
    }
}

/* ESC */
document.addEventListener('keydown', function(e) {
    if (e.key === "Escape") {
        closePreview();
    }
});

/* upload */
function uploadBukti(id) {
    let fileInput = document.getElementById('fileInput' + id);
    let formData = new FormData();

    formData.append('bukti_transfer', fileInput.files[0]);
    formData.append('_token', '{{ csrf_token() }}');

    fetch('/upload-bukti/' + id, {
        method: 'POST',
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            alert('Berhasil upload');

            document.getElementById('button-cell-' + id).innerHTML =
                `<button class="btn-primary-clean"
                    onclick="showPreview('${data.bukti_path}')">
                    Lihat
                </button>`;
        }
    });
}
</script>

@endsection