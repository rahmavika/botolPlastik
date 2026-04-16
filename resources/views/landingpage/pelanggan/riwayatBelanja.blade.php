@extends('landingpage.layouts.main')

@section('content')
<section class="mt-5">
    <div class="container-fluid">
        <div class="row d-flex justify-content-center align-items-center">
            <div class="col-md-12 col-lg-12 mb-4">
                <div class="card shadow-lg rounded" style="border: none;">

                    <h4 class="mt-3 text-center" style="font-family: 'Poppins', sans-serif; font-weight: 600; color: #4A90E2; font-size: 1.2rem;">
                        Riwayat Belanja
                    </h4>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th class="text-center" style="font-size: 0.875rem;">Tanggal Pemesanan</th>
                                        <th class="text-center" style="font-size: 0.875rem;">Total Harga</th>
                                        <th class="text-center" style="font-size: 0.875rem;">Bukti Transfer</th>
                                        <th class="text-center" style="font-size: 0.875rem;">Status Pesanan</th>
                                        <th class="text-center" style="font-size: 0.875rem;">Status Pembayaran</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($riwayatBelanja as $checkout)
                                    <tr id="row-{{ $checkout->id }}">
                                        <td class="text-center" style="font-size: 0.875rem;">
                                            <a href="{{ route('checkout.detail', $checkout->id) }}"
                                               style="text-decoration: none; color: #0B773D;"
                                               title="Lihat Detail">
                                                {{ \Carbon\Carbon::parse($checkout->tanggal_pemesanan)->format('d F Y') }}
                                            </a>
                                        </td>
                                        <td class="text-center" style="font-size: 0.875rem;">
                                            Rp {{ number_format($checkout->total_harga, 0, ',', '.') }}
                                        </td>
                                        <td id="button-cell-{{ $checkout->id }}" class="text-center" style="font-size: 0.875rem;">
                                            @if($checkout->bukti_transfer)
                                            <button class="btn btn-success"
                                                style="font-size: 13px; padding: 5px 5px;"
                                                title="Lihat Bukti Transfer"
                                                onclick="window.open('{{ asset($checkout->bukti_transfer) }}?v={{ time() }}', '_blank')">
                                            Lihat Bukti
                                        </button>
                                            @else
                                                <button class="btn"
                                                        style="background-color: #db9a44; color: white; font-size: 13px; padding: 5px 5px;"
                                                        title="Upload Bukti Transfer"
                                                        onclick="document.getElementById('fileInput{{ $checkout->id }}').click()">
                                                    Upload Bukti
                                                </button>
                                                <input type="file" id="fileInput{{ $checkout->id }}" name="bukti_transfer"
                                                       style="display: none;"
                                                       onchange="uploadBukti({{ $checkout->id }})">
                                            @endif
                                        </td>
                                        <td class="text-center" style="font-size: 0.875rem;">
                                            @switch($checkout->status)
                                                @case('menunggu_konfirmasi')
                                                    <span class="badge" style="background-color: #a72c28; color: white;">Menunggu Konfirmasi</span>
                                                    @break
                                                @case('diproses')
                                                    <span class="badge" style="background-color: #0c58b4; color: white;">Diproses</span>
                                                    @break
                                                @case('dikirim')
                                                    <span class="badge" style="background-color: #081958; color: white;">Dikirim</span>
                                                    @break
                                                @case('selesai')
                                                    <span class="badge" style="background-color: #0b773d; color: white;">Selesai</span>
                                                    @break
                                            @endswitch
                                        </td>
                                        <td class="text-center" style="font-size: 0.875rem;">
                                            @switch($checkout->status_pembayaran)
                                                @case('belum_lunas')
                                                    <span class="badge" style="background-color: #a72c28; color: white;">Belum Bayar</span>
                                                    @break
                                                @case('lunas')
                                                    <span class="badge" style="background-color: #0b773d; color: white;">Sudah Bayar</span>
                                                    @break
                                                @default
                                                    <span class="badge bg-secondary">Tidak Diketahui</span>
                                            @endswitch
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="d-flex justify-content-center">
                            {{ $riwayatBelanja->links('pagination::bootstrap-5') }}

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
function uploadBukti(checkoutId) {
    var fileInput = document.getElementById('fileInput' + checkoutId);
    var formData = new FormData();
    formData.append('bukti_transfer', fileInput.files[0]);
    formData.append('_token', '{{ csrf_token() }}');

    fetch('/upload-bukti/' + checkoutId, {
        method: 'POST',
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            alert('Bukti transfer berhasil diupload!');
            var buttonCell = document.getElementById('button-cell-' + checkoutId);
            buttonCell.innerHTML = `
                <button class="btn btn-success" onclick="window.open('${data.bukti_path}', '_blank')">
                    Lihat Bukti
                </button>
            `;
        } else {
            alert('Gagal mengupload bukti transfer.');
        }
    })
    .catch(err => {
        console.error(err);
        alert('Terjadi kesalahan.');
    });
}
</script>
@endsection
