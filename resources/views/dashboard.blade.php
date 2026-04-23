@extends('layouts.main')

@section('content')
@php
    $cards = [
        [
            'title' => 'Jumlah Produk',
            'value' => $jumlahProduk,
            'icon'  => 'fas fa-box',
            'color' => 'linear-gradient(135deg, #f59e0b, #f97316)',
            'route' => route('dashboard-produk.index')
        ],
        [
            'title' => 'Jumlah Pelanggan',
            'value' => $jumlahPelanggan,
            'icon'  => 'fas fa-users',
            'color' => 'linear-gradient(135deg, #3b82f6, #2563eb)',
            'route' => route('dashboard-pengguna.index')
        ],
        [
            'title' => 'Pesanan Masuk',
            'value' => $jumlahPesananMasuk,
            'icon'  => 'fas fa-shopping-bag',
            'color' => 'linear-gradient(135deg, #8b5cf6, #6d28d9)',
            'route' => '#'
        ]
    ];
@endphp

<div class="container-fluid py-4 px-4 dashboard-wrapper">

    {{-- TOP STATISTICS --}}
    <div class="row g-4 mb-4">
        @foreach ($cards as $card)
        <div class="col-lg-4 col-md-6">
            <a href="{{ $card['route'] }}" class="text-decoration-none">
                <div class="dashboard-card stat-card">
                    <div class="stat-icon" style="background: {{ $card['color'] }}">
                        <i class="{{ $card['icon'] }}"></i>
                    </div>
                    <div class="stat-info">
                        <p>{{ $card['title'] }}</p>
                        <h2>{{ $card['value'] }}</h2>
                    </div>
                </div>
            </a>
        </div>
        @endforeach
    </div>

    {{-- MAIN CONTENT --}}
    <div class="row g-4">

        {{-- LEFT: CHART --}}
        <div class="col-lg-8">
            <div class="dashboard-card chart-card">
                <h5 class="card-title">Grafik Penjualan</h5>
                <div class="chart-wrapper">
                    <canvas id="grafikPenjualan"></canvas>
                </div>
            </div>
        </div>

        {{-- RIGHT: SUMMARY --}}
        <div class="col-lg-4">
            <div class="d-flex flex-column gap-4">

                {{-- TOTAL SALES --}}
                <div class="dashboard-card total-sales-card">
                    <p>Total Penjualan</p>
                    <h1>Rp {{ number_format($totalPenjualan, 0, ',', '.') }}</h1>
                    <small>{{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</small>
                </div>

                {{-- CUSTOMER LIST --}}
                <div class="dashboard-card customer-card">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="card-title mb-0">Daftar Pelanggan</h5>

                        @if($semuaPelanggan->count() > 5)
                            <a href="{{ route('dashboard-pengguna.index') }}" class="lihat-semua">
                                Selengkapnya
                            </a>
                        @endif
                    </div>

                    @forelse($semuaPelanggan->take(5) as $p)
                        <div class="customer-item">
                            <div class="avatar">
                                {{ strtoupper(substr($p->name, 0, 1)) }}
                            </div>
                            <span>{{ $p->name }}</span>
                        </div>
                    @empty
                        <small class="text-muted">Belum ada pelanggan</small>
                    @endforelse
                </div>

            </div>
        </div>

    </div>
</div>

<style>
    .lihat-semua {
    font-size: 14px;
    font-weight: 600;
    color: #3b82f6;
    text-decoration: none;
    transition: 0.3s;
    }

    .lihat-semua:hover {
        color: #2563eb;
        text-decoration: underline;
    }
    .dashboard-wrapper {
        min-height: 100vh;
        background: linear-gradient(135deg, #eef2ff, #f8fafc);
    }

    .dashboard-card {
        background: #fff;
        border-radius: 20px;
        padding: 24px;
        box-shadow: 0 8px 24px rgba(0,0,0,0.06);
        transition: all 0.3s ease;
        height: 100%;
        border: none;
    }

    .dashboard-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 30px rgba(0,0,0,0.08);
    }

    /* TOP CARDS */
    .stat-card {
        display: flex;
        align-items: center;
        gap: 18px;
        min-height: 110px;
    }

    .stat-icon {
        width: 60px;
        height: 60px;
        border-radius: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 22px;
        flex-shrink: 0;
    }

    .stat-info p {
        margin: 0;
        color: #6b7280;
        font-size: 15px;
    }

    .stat-info h2 {
        margin: 0;
        font-size: 34px;
        font-weight: 700;
        color: #1f2937;
    }

    /* CHART */
    .chart-card {
        min-height: 420px;
    }

    .chart-wrapper {
        position: relative;
        height: 320px;
    }

    /* TITLE */
    .card-title {
        font-weight: 700;
        margin-bottom: 20px;
        color: #1f2937;
    }

    /* TOTAL SALES */
    .total-sales-card {
    background: linear-gradient(135deg, #1e3a8a, #3b82f6);
    color: white;
    text-align: center;
    min-height: 130px; /* diperkecil */
    padding: 18px; /* lebih kecil */
    display: flex;
    flex-direction: column;
    justify-content: center;
    }

    .total-sales-card p {
        margin-bottom: 6px;
        font-size: 15px;
    }

    .total-sales-card h1 {
        font-size: 28px; /* dari 42 jadi 28 */
        font-weight: 800;
        margin-bottom: 6px;
    }

    .total-sales-card small {
        font-size: 12px;
    }

    /* CUSTOMER */
    .customer-card {
        min-height: 200px;
        padding: 18px;
    }

    .customer-item {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 10px 0;
        border-bottom: 1px solid #f1f5f9;
    }

    .customer-item:last-child {
        border-bottom: none;
    }

    .avatar {
        width: 34px;
        height: 34px;
        font-size: 14px;
        border-radius: 50%;
        background: linear-gradient(135deg, #3b82f6, #6366f1);
        color: white;
        font-weight: 700;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
</style>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const canvas = document.getElementById('grafikPenjualan');

    if (!canvas) return;

    const ctx = canvas.getContext('2d');

    const gradient = ctx.createLinearGradient(0, 0, 0, 300);
    gradient.addColorStop(0, 'rgba(59,130,246,0.4)');
    gradient.addColorStop(1, 'rgba(59,130,246,0)');

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: {!! json_encode($pesananPerHari->pluck('tanggal')) !!},
            datasets: [{
                label: 'Penjualan',
                data: {!! json_encode($pesananPerHari->pluck('total')) !!},
                borderColor: '#3b82f6',
                backgroundColor: gradient,
                fill: true,
                tension: 0.4,
                pointRadius: 4,
                pointBackgroundColor: '#3b82f6',
                borderWidth: 3
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                x: {
                    grid: {
                        display: false
                    }
                },
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(0,0,0,0.05)'
                    }
                }
            }
        }
    });
});
</script>
@endsection