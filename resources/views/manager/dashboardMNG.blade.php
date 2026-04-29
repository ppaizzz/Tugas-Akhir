@extends('layouts.app')
@section('title', 'Dashboard Manager')
@section('header', 'Dashboard Eksekutif')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100 flex items-center">
        <div class="w-14 h-14 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-600 text-2xl mr-4">
            <i class="fa-solid fa-money-bill-wave"></i>
        </div>
        <div>
            <p class="text-slate-500 text-sm font-medium">Pendapatan Hari Ini</p>
            <p class="text-2xl font-bold text-slate-800">Rp {{ number_format($salesToday, 0, ',', '.') }}</p>
        </div>
    </div>
    
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100 flex items-center">
        <div class="w-14 h-14 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 text-2xl mr-4">
            <i class="fa-solid fa-chart-line"></i>
        </div>
        <div>
            <p class="text-slate-500 text-sm font-medium">Pendapatan Bulan Ini</p>
            <p class="text-2xl font-bold text-slate-800">Rp {{ number_format($salesMonth, 0, ',', '.') }}</p>
        </div>
    </div>
    
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100 flex items-center">
        <div class="w-14 h-14 rounded-full bg-amber-100 flex items-center justify-center text-amber-600 text-2xl mr-4">
            <i class="fa-solid fa-clock-rotate-left"></i>
        </div>
        <div>
            <p class="text-slate-500 text-sm font-medium">Menunggu Transfer</p>
            <p class="text-2xl font-bold text-slate-800">{{ $pendingTransactions }} <span class="text-sm font-normal text-slate-500">Transaksi</span></p>
        </div>
    </div>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-8 mb-8">
    <h2 class="text-xl font-bold text-slate-800 mb-6 border-b pb-2">Grafik Penjualan 7 Hari Terakhir</h2>
    <div class="relative h-72 w-full">
        <canvas id="salesChart"></canvas>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('salesChart').getContext('2d');
    
    // Gradient fill for chart
    let gradient = ctx.createLinearGradient(0, 0, 0, 400);
    gradient.addColorStop(0, 'rgba(79, 70, 229, 0.5)'); // Indigo 600
    gradient.addColorStop(1, 'rgba(79, 70, 229, 0.0)');

    const salesChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: {!! json_encode($chartDates) !!},
            datasets: [{
                label: 'Total Penjualan (Rp)',
                data: {!! json_encode($chartData) !!},
                backgroundColor: gradient,
                borderColor: '#4f46e5',
                borderWidth: 3,
                pointBackgroundColor: '#ffffff',
                pointBorderColor: '#4f46e5',
                pointBorderWidth: 2,
                pointRadius: 4,
                fill: true,
                tension: 0.4 // Smooth curves
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: { borderDash: [5, 5], color: '#f1f5f9' },
                    ticks: {
                        callback: function(value) { return 'Rp ' + value.toLocaleString('id-ID'); }
                    }
                },
                x: {
                    grid: { display: false }
                }
            }
        }
    });
</script>
@endpush