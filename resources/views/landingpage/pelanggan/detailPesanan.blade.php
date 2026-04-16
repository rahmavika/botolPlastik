<!-- BUTTON TRIGGER -->
<button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#invoiceModal">
    🧾 Lihat Invoice
</button>

<!-- MODAL -->
<div class="modal fade" id="invoiceModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content rounded-4">

            <div class="modal-header">
                <h5 class="modal-title">Invoice</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

                <!-- INVOICE -->
                <div id="invoiceArea" class="invoice-box">

                    <div class="d-flex justify-content-between align-items-start mb-4">
                        <div>
                            <h3 class="fw-bold text-success m-0">TB AW Karya Bangunan</h3>
                            <small>
                                Jl. Mesjid, Sungai Pua <br>
                                Kabupaten Agam <br>
                                Telp: (0752) 123456
                            </small>
                        </div>
                        <div class="text-end">
                            <h5 class="fw-bold m-0">INVOICE</h5>
                            <small>
                                No: {{ $checkout->id }} <br>
                                Tanggal: {{ \Carbon\Carbon::parse($checkout->tanggal_pemesanan)->format('d F Y') }}
                            </small>
                        </div>
                    </div>

                    <hr>

                    <table class="table table-borderless small mb-4">
                        <tr>
                            <th>Nama</th>
                            <td>{{ $checkout->user->name ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>No. HP</th>
                            <td>{{ $checkout->user->phone ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Alamat</th>
                            <td>{{ $checkout->alamat_pengiriman }}</td>
                        </tr>
                    </table>

                    <table class="table table-bordered small">
                        <thead>
                            <tr>
                                <th>Produk</th>
                                <th class="text-center">Jumlah</th>
                                <th class="text-end">Harga</th>
                                <th class="text-end">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($produkDetails as $produk)
                            <tr>
                                <td>{{ $produk['nama'] }}</td>
                                <td class="text-center">{{ $produk['jumlah'] }}</td>
                                <td class="text-end">Rp {{ number_format($produk['harga'], 0, ',', '.') }}</td>
                                <td class="text-end">Rp {{ number_format($produk['total'], 0, ',', '.') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="text-end">
                        <strong>Total: Rp {{ number_format(($totalHargaAkhir + ($checkout->ongkir ?? 0)), 0, ',', '.') }}</strong>
                    </div>

                </div>

            </div>

            <div class="modal-footer">
                <button onclick="printInvoice()" class="btn btn-success">
                    🖨 Cetak
                </button>
                <button class="btn btn-secondary" data-bs-dismiss="modal">
                    Tutup
                </button>
            </div>

        </div>
    </div>
</div>
<script>
    function printInvoice() {
        var printContents = document.getElementById('invoiceArea').innerHTML;
        var originalContents = document.body.innerHTML;

        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;
        location.reload();
    }
    </script>

<style>
    .modal-body {
    max-height: 70vh;
    overflow-y: auto;
}
</style>