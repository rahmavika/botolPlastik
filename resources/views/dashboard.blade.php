@extends('layouts.main')
@section('content')

@php
    $cards = [
        [
            'title' => 'Jumlah Produk',
            'value' => $jumlahProduk,
            'icon'  => 'fas fa-box',
            'color' => 'linear-gradient(135deg,#f59e0b,#f97316)'
        ],
        [
            'title' => 'Jumlah Pelanggan',
            'value' => $jumlahPelanggan,
            'icon'  => 'fas fa-users',
            'color' => 'linear-gradient(135deg,#3b82f6,#2563eb)'
        ],
        [
            'title' => 'Pesanan Masuk',
            'value' => $jumlahPesananMasuk,
            'icon'  => 'fas fa-shopping-bag',
            'color' => 'linear-gradient(135deg,#8b5cf6,#6d28d9)'
        ]
    ];
@endphp

<div class="container-fluid py-4 px-4 dashboard-wrapper">
    <div class="row g-4 mb-4">
        @foreach ($cards as $card)
            <div class="col-lg-4">
                <div class="dashboard-card stat-card">
                    <div class="stat-icon" style="background: {{ $card['color'] }}">
                        <i class="{{ $card['icon'] }}"></i>
                    </div>
                    <div>
                        <p>{{ $card['title'] }}</p>
                        <h2>{{ $card['value'] }}</h2>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <div class="row g-4">
        <div class="col-lg-8">
            <div class="dashboard-card">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="mb-0">Grafik Penjualan</h5>
                    <div class="d-flex gap-2">
                        <a href="{{ request()->fullUrlWithQuery(['bulan' => \Carbon\Carbon::parse($bulan)->subMonth()->format('Y-m')]) }}"
                           class="btn btn-sm btn-outline-secondary">←</a>
                        <form method="GET">
                            <input type="month" name="bulan" value="{{ $bulan }}"
                                   class="form-control form-control-sm"
                                   onchange="this.form.submit()">
                        </form>
                        <a href="{{ request()->fullUrlWithQuery(['bulan' => \Carbon\Carbon::parse($bulan)->addMonth()->format('Y-m')]) }}"
                           class="btn btn-sm btn-outline-secondary">→</a>
                    </div>
                </div>
                <div class="chart-wrapper">
                    <canvas id="grafikPenjualan"></canvas>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="d-flex flex-column gap-4">
                <div class="dashboard-card total-sales-card">
                    <p>Total Penjualan</p>
                    <h2>Rp {{ number_format($totalPenjualan, 0, ',', '.') }}</h2>
                    <small>{{ now()->translatedFormat('d F Y') }}</small>
                </div>
                <div class="dashboard-card">
                    <h5>Transaksi Terbaru</h5>
                    @forelse($transaksiTerbaru as $trx)
                        <div class="d-flex justify-content-between border-bottom py-2">
                            <span>{{ $trx->created_at->format('d M') }}</span>
                            <strong>Rp {{ number_format($trx->total_harga, 0, ',', '.') }}</strong>
                        </div>
                    @empty
                        <small class="text-muted">Belum ada transaksi</small>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
    <div class="row g-4 mt-2">
        <div class="col-lg-12">
            <div class="dashboard-card">
                <h5>Grafik Penjualan Bulanan - {{ $tahun }}</h5>
                <form method="GET" class="mb-3">
                    <select name="tahun" class="form-select form-select-sm w-auto"
                            onchange="this.form.submit()">
                        @for($i = now()->year; $i >= now()->year - 5; $i--)
                            <option value="{{ $i }}" {{ $tahun == $i ? 'selected' : '' }}>
                                {{ $i }}
                            </option>
                        @endfor
                    </select>
                </form>
                <div class="chart-wrapper">
                    <canvas id="grafikBulanan"></canvas>
                </div>
            </div>
        </div>
    </div>
    <div class="row g-4 mt-2">
        <div class="col-lg-6">
            <div class="dashboard-card">
                <h5>Status Pesanan</h5>
                <div class="small-chart">
                    <canvas id="chartStatus"></canvas>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="dashboard-card">
                <h5>Metode Pembayaran (LUNAS)</h5>
                <div class="small-chart">
                    <canvas id="chartPembayaran"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>


<style>
    .dashboard-wrapper {
        background: linear-gradient(135deg, #eef2ff, #f8fafc);
    }
    .dashboard-card {
        background: #fff;
        padding: 20px;
        border-radius: 20px;
        box-shadow: 0 8px 20px rgba(0,0,0,.05);
    }
    .stat-card {
        display: flex;
        gap: 15px;
        align-items: center;
    }
    .stat-icon {
        width: 60px;
        height: 60px;
        border-radius: 15px;
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .chart-wrapper {
        height: 320px;
    }
    .small-chart {
        height: 200px;
    }
    .total-sales-card {
        background: linear-gradient(135deg, #1e3a8a, #3b82f6);
        color: #fff;
        text-align: center;
    }
</style>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        new Chart(document.getElementById('grafikPenjualan'), {
            type: 'line',
            data: {
                labels: {!! json_encode($pesananPerHari->pluck('tanggal')) !!},
                datasets: [{
                    label: 'Penjualan Lunas',
                    data: {!! json_encode($pesananPerHari->pluck('total')) !!},
                    borderColor: '#3b82f6',
                    backgroundColor: 'rgba(59,130,246,0.2)',
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                }
            }
        });
        new Chart(document.getElementById('chartStatus'), {
            type: 'doughnut',
            data: {
                labels: {!! json_encode($statusPesanan->keys()) !!},
                datasets: [{
                    data: {!! json_encode($statusPesanan->values()) !!},
                    backgroundColor: [
                        '#9ca3af',
                        '#facc15',
                        '#14b8a6',
                        '#22c55e'
                    ],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });
        new Chart(document.getElementById('chartPembayaran'), {
            type: 'doughnut',
            data: {
                labels: {!! json_encode($metodePembayaran->keys()) !!},
                datasets: [{
                    data: {!! json_encode($metodePembayaran->values()) !!}
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function () {

        const ctx = document.getElementById('grafikBulanan').getContext('2d');

        // ✅ Gradient
        const gradient = ctx.createLinearGradient(0, 0, 0, 300);
        gradient.addColorStop(0, '#6366f1');
        gradient.addColorStop(1, '#a5b4fc');

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($penjualanPerBulan->pluck('nama_bulan')) !!},
                datasets: [{
                    data: {!! json_encode($penjualanPerBulan->pluck('total')) !!},
                    backgroundColor: gradient,
                    borderRadius: 12,
                    barThickness: 40
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#1e293b',
                        titleColor: '#fff',
                        bodyColor: '#fff',
                        padding: 10,
                        displayColors: false,
                        callbacks: {
                            label: function(context) {
                                return 'Rp ' + context.raw.toLocaleString('id-ID');
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        grid: { display: false }
                    },
                    y: {
                        grid: {
                            color: 'rgba(0,0,0,0.05)'
                        },
                        ticks: {
                            callback: function(value) {
                                return 'Rp ' + value.toLocaleString('id-ID');
                            }
                        }
                    }
                }
            }
        });

    });
    </script>

@endsection