@extends('layouts.main')
@section('title', 'Detail Penjualan')

@section('content')

<div class="card shadow-sm border-0" style="font-size:13px; border-radius:8px;">

    {{-- HEADER --}}
    <div class="card-header bg-white d-flex justify-content-between align-items-center"
        style="border-bottom:1px solid #e5e7eb;">

        <h6 class="mb-0 fw-semibold" style="color:#111827;">
            Detail Penjualan
        </h6>

        <span style="font-size:12px; color:#6b7280;">
            #{{ $checkout->id }}
        </span>
    </div>

    <div class="card-body p-3">

        {{-- ================= INFO ================= --}}
        <div class="mb-3">
            <table class="table table-sm align-middle mb-0">

                <tbody>

                    <tr>
                        <th width="30%" style="color:#6b7280;">Tanggal</th>
                        <td>
                            {{ \Carbon\Carbon::parse($checkout->tanggal_pemesanan)->format('d-m-Y') }}
                        </td>
                    </tr>

                    <tr>
                        <th style="color:#6b7280;">User</th>
                        <td>{{ $checkout->user->name }}</td>
                    </tr>

                    <tr>
                        <th style="color:#6b7280;">Alamat</th>
                        <td style="white-space: normal;">
                            {{ $checkout->alamat_pengiriman }}
                        </td>
                    </tr>

                    {{-- METODE PEMBAYARAN --}}
                    <tr>
                        <th style="color:#6b7280;">Metode Pembayaran</th>
                        <td>
                            <span style="
                                background:#eef2ff;
                                color:#3730a3;
                                padding:3px 8px;
                                border-radius:4px;
                                font-size:12px;">
                                {{ ucfirst($checkout->metode_pembayaran) }}
                            </span>
                        </td>
                    </tr>

                    {{-- DETAIL TRANSFER --}}
                    @if(strtolower($checkout->metode_pembayaran) === 'transfer')
                    <tr>
                        <th style="color:#6b7280;">Bank</th>
                        <td>Mandiri</td>
                    </tr>
                    <tr>
                        <th style="color:#6b7280;">No Rekening</th>
                        <td class="fw-semibold">1120290091890</td>
                    </tr>
                    @endif

                    <tr>
                        <th style="color:#6b7280;">Total</th>
                        <td class="fw-semibold" style="color:#16a34a;">
                            Rp {{ number_format($checkout->total_harga, 0, ',', '.') }}
                        </td>
                    </tr>

                </tbody>

            </table>
        </div>

        {{-- ================= DETAIL PRODUK ================= --}}
        <div>

            <h6 class="fw-semibold mb-2" style="color:#111827;">
                Detail Produk
            </h6>

            <div class="table-responsive">
                <table class="table table-sm align-middle mb-0">

                    <thead style="background:#f9fafb; font-size:12px; color:#6b7280;">
                        <tr class="text-center">
                            <th width="5%">No</th>
                            <th class="text-start">Produk</th>
                            <th width="10%">Qty</th>
                            <th width="20%">Harga</th>
                            <th width="20%">Total</th>
                        </tr>
                    </thead>

                    <tbody>
                        @php
                            $details = $checkout->produk_details;
                            $subtotal = 0;
                        @endphp

                        @foreach ($details as $index => $detail)
                        @php
                            $totalItem = $detail['jumlah'] * $detail['harga'];
                            $subtotal += $totalItem;
                        @endphp

                        <tr style="border-bottom:1px solid #f1f5f9;">
                            <td class="text-center">{{ $index + 1 }}</td>

                            <td class="text-start">
                                {{ $detail['nama'] }}
                            </td>

                            <td class="text-center">
                                {{ $detail['jumlah'] }}
                            </td>

                            <td class="text-end">
                                Rp {{ number_format($detail['harga'], 0, ',', '.') }}
                            </td>

                            <td class="text-end fw-semibold">
                                Rp {{ number_format($totalItem, 0, ',', '.') }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>

                    {{-- TOTAL --}}
                    <tfoot>

                        <tr>
                            <td colspan="3"></td>
                            <td class="text-end" style="color:#6b7280;">Subtotal</td>
                            <td class="text-end">
                                Rp {{ number_format($subtotal, 0, ',', '.') }}
                            </td>
                        </tr>

                        <tr>
                            <td colspan="3"></td>
                            <td class="text-end" style="color:#2563eb;">Ongkir</td>
                            <td class="text-end" style="color:#2563eb;">
                                Rp {{ number_format($checkout->ongkir ?? 0, 0, ',', '.') }}
                            </td>
                        </tr>

                        <tr style="background:#f3f4f6;">
                            <td colspan="3"></td>
                            <td class="text-end fw-semibold">Total</td>
                            <td class="text-end fw-bold" style="color:#16a34a;">
                                Rp {{ number_format($subtotal + ($checkout->ongkir ?? 0), 0, ',', '.') }}
                            </td>
                        </tr>

                    </tfoot>

                </table>
            </div>

        </div>

    </div>
</div>

@endsection