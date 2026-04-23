@extends('landingpage.layouts.main')

@section('content')
<section class="py-5" style="background:#f1f5f9; min-height:100vh;">
<div class="container">

<div class="row justify-content-center">
<div class="col-md-10 col-lg-8">

<div class="card border-0 shadow-sm rounded-4" style="background:#ffffff;">
<div class="card-body p-4">

<h4 class="text-center fw-semibold mb-3" style="color:#6383e5;">
    🧾 Checkout
</h4>
<hr>

<!-- DATA USER -->
<div class="mb-4 p-3 rounded-3" style="background:#f8fafc;">
    <h6 class="mb-2" style="color:#6383e5;">Data Pelanggan</h6>
    <p class="mb-1"><strong>Username:</strong> {{ $user->name }}</p>
    <p class="mb-0"><strong>No HP:</strong> {{ $user->phone ?? '-' }}</p>
</div>

<!-- PRODUK -->
<div class="table-responsive mb-4">
<table class="table align-middle text-center">
<thead style="background:#f1f5f9;">
<tr>
    <th>Produk</th>
    <th>Jumlah</th>
    <th>Harga</th>
    <th>Total</th>
</tr>
</thead>
<tbody>
@foreach($keranjangs as $item)
<tr>
    <td class="text-start">{{ $item->produk->nama_produk }}</td>
    <td>{{ $item->jumlah }}</td>
    <td>Rp {{ number_format($item->harga,0,',','.') }}</td>
    <td class="fw-semibold" style="color:#6383e5;">
        Rp {{ number_format($item->jumlah * $item->harga,0,',','.') }}
    </td>
</tr>
@endforeach
</tbody>
</table>
</div>

<form action="{{ route('checkout.store') }}" method="POST">
@csrf

@foreach(request('selected_items') as $id)
<input type="hidden" name="selected_items[]" value="{{ $id }}">
@endforeach

<!-- ALAMAT -->
<div class="mb-4">
    <label class="form-label fw-semibold">Alamat Pengiriman</label>
    <textarea name="alamat_pengiriman"
        class="form-control border-0 shadow-sm"
        style="background:#f8fafc;"
        required
        placeholder="Masukkan alamat lengkap..."></textarea>
</div>

<!-- ONGKIR -->
<div class="mb-4">
    <label class="form-label fw-semibold">Pengiriman</label>

    <select id="provinsi" class="form-control mb-2 shadow-sm border-0" style="background:#f8fafc;">
        <option value="">Pilih Provinsi</option>
    </select>

    <select id="kota" class="form-control mb-2 shadow-sm border-0" style="background:#f8fafc;">
        <option value="">Pilih Kota</option>
    </select>

    <select id="courier" class="form-control mb-2 shadow-sm border-0" style="background:#f8fafc;">
        <option value="">Pilih Kurir</option>
        <option value="jne">JNE</option>
        <option value="pos">POS</option>
        <option value="tiki">TIKI</option>
    </select>

    <div id="statusOngkir" class="mt-2 small text-muted"></div>

    <button type="button" onclick="autoCekOngkir()"
        class="btn btn-outline-success btn-sm mt-2">
        🚚 Cek Ongkir
    </button>

    <div id="hasilOngkir" class="mt-3"></div>
</div>

<!-- HIDDEN -->
<input type="hidden" name="courier" id="courierInput">
<input type="hidden" name="service" id="serviceInput">
<input type="hidden" name="ongkir" id="ongkirInput" value="0">
<input type="hidden" name="total_harga" id="totalHargaInput">
<input type="hidden" name="kota" id="kota_nama">

<!-- PEMBAYARAN -->
<div class="mb-4">
    <label class="form-label fw-semibold">Metode Pembayaran</label>
    <div class="d-flex gap-3">
        <label class="p-3 rounded-3 w-100 text-center border" style="cursor:pointer;">
            <input type="radio" name="metode_pembayaran" value="cod" required>
            COD
        </label>
        <label class="p-3 rounded-3 w-100 text-center border" style="cursor:pointer;">
            <input type="radio" name="metode_pembayaran" value="transfer" required>
            Transfer
        </label>
    </div>
</div>

<!-- TOTAL -->
<div class="mb-4 p-3 rounded-3" style="background:#f8fafc;">
    <p class="mb-1">
        Belanja:
        <b>Rp {{ number_format($totalHargaProduk,0,',','.') }}</b>
    </p>
    <h5 class="mb-0">
        Total Bayar:
        <span id="totalPembayaran" style="color:#6383e5;">
            Rp {{ number_format($totalHargaProduk,0,',','.') }}
        </span>
    </h5>
</div>

<div class="mt-3 text-center">
    <button type="submit" id="btnPesan"
        class="btn w-100 py-2"
        style="background-color: #6383e5; border-color: #6383e5; color: white;">
        Pesan Sekarang
    </button>
</div>

</form>

</div>
</div>

</div>
</div>
</div>
</section>

<style>
.ongkir-flex {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
}

.ongkir-item {
    width: 160px;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    padding: 10px;
    background: #fff;
    transition: 0.2s;
}

.ongkir-item:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 10px rgba(0,0,0,0.1);
}


.form-control:focus {
    box-shadow: 0 0 0 2px rgba(11,119,61,0.2);
    border-color: #6383e5;
}

#hasilOngkir .border {
    background:#ffffff;
    border:1px solid #e2e8f0 !important;
}

#hasilOngkir button {
    background:#6383e5;
    border:none;
}
.table-bordered {
        border: 1.5px solid #dee2e6 !important;
    }
    .table-bordered th, .table-bordered td {
        border: 1.5px solid #dee2e6 !important;
    }
    .table-bordered th {
        background-color: #f8f9fa;
        color: #6383e5;
    }
    .table-bordered td {
        background-color: #fff;
    }
    .form-control,
    textarea.form-control,
    select.form-select {
        border: 1.5px solid #6383e5 !important;
        border-radius: 5px;
        box-shadow: none;
        font-size: 0.875rem;
    }

    .form-control:focus,
    textarea.form-control:focus,
    select.form-select:focus {
        border-color:#6383e5 !important;
        box-shadow: 0 0 4px rgba(11, 119, 61, 0.5);
    }

    label {
        font-weight: 500;
        color: #6383e5;
    }

    .custom-radio {
        width: 18px;
        height: 18px;
        border: 1.5px solid #6383e5;
        accent-color: #6383e5;
        cursor: pointer;
    }
    .custom-radio:focus {
        outline: 1.5px solid #6383e5;
        outline-offset: 2px;
    }
</style>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.getElementById('btnPesan').addEventListener('click', function(e) {
        e.preventDefault();

        Swal.fire({
            text: 'Yakin ingin membuat pesanan?',
            width: 260,
            padding: '1.2em',
            showCancelButton: true,
            confirmButtonText: 'Ya',
            cancelButtonText: 'Batal',
            buttonsStyling: false,
            customClass: {
                popup: 'rounded-3',
                htmlContainer: 'small text-dark text-center',
                actions: 'd-flex justify-content-center gap-2 mt-3',
                confirmButton: 'btn btn-sm btn-dark',
                cancelButton: 'btn btn-sm btn-outline-secondary'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                this.closest('form').submit();
            }
        });
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        fetch('/provinsi')
        .then(res => res.json())
        .then(data => {
            let prov = document.getElementById('provinsi');
            data.data.forEach(p => {
                prov.innerHTML += `<option value="${p.id}">${p.name}</option>`;
            });
        });
        document.getElementById('provinsi').addEventListener('change', function() {

            fetch('/kota/' + this.value)
            .then(res => res.json())
            .then(data => {

                let kota = document.getElementById('kota');
                kota.innerHTML = '<option value="">Pilih Kota</option>';

                data.data.forEach(k => {
                    kota.innerHTML += `<option value="${k.id}">${k.name}</option>`;
                });

            });
        });
        document.getElementById('kota').addEventListener('change', function(){
            let text = this.options[this.selectedIndex].text;
            document.getElementById('kota_nama').value = text;
        });
        window.autoCekOngkir = function () {

            let courier = document.getElementById('courier').value;
            let destination = document.getElementById('kota').value;

            let status = document.getElementById('statusOngkir');
            let hasil = document.getElementById('hasilOngkir');

            if (!courier || !destination) {
                status.innerHTML = "⚠️ Pilih kota & kurir dulu";
                return;
            }

            status.innerHTML = "⏳ Mengecek ongkir...";
            hasil.innerHTML = "";

            fetch('/cek-ongkir', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    courier: courier,
                    destination: destination,
                    weight: 1000
                })
            })
            .then(res => res.json())
            .then(data => {

                console.log("DATA ONGKIR:", data);

                let html = `<div class="ongkir-flex">`;

                data.data.forEach(item => {
                    html += `
                        <div class="ongkir-item">
                            <b>${item.service}</b><br>
                            Rp ${item.cost.toLocaleString('id-ID')}<br>
                            <small>Estimasi: ${item.etd} hari</small>

                            <button type="button"
                                onclick="pilihOngkir('${courier}','${item.service}',${item.cost})"
                                class="btn btn-success btn-sm mt-2 w-100">
                                Pilih
                            </button>
                        </div>
                    `;
                });

                html += `</div>`;

                hasil.innerHTML = html;
            })
            .catch(err => {
                console.log(err);
                status.innerHTML = "❌ Gagal ambil ongkir";
            });
        }

        document.getElementById('kota').addEventListener('change', autoCekOngkir);
        document.getElementById('courier').addEventListener('change', autoCekOngkir);
        window.pilihOngkir = function(courier, service, cost) {

            document.getElementById('courierInput').value = courier;
            document.getElementById('serviceInput').value = service;
            document.getElementById('ongkirInput').value = cost;

            let totalProduk = {{ $totalHargaProduk }};
            let total = totalProduk + cost;

            document.getElementById('totalPembayaran').innerHTML =
                'Rp ' + total.toLocaleString('id-ID');

            document.getElementById('totalHargaInput').value = total;
        }

    });
</script>
@endsection

