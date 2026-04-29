<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Sale;
use App\Models\Branch;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanController extends Controller
{
    public function dashboard()
    {
        $today = Carbon::today();
        
        $salesToday = Sale::whereDate('created_at', $today)->where('status_bayar', 'lunas')->sum('total');
        
        $salesMonth = Sale::whereMonth('created_at', $today->month)
                          ->whereYear('created_at', $today->year)
                          ->where('status_bayar', 'lunas')
                          ->sum('total');
        
        $pendingTransactions = Sale::where('status_bayar', 'pending')->count();

        $chartDates = [];
        $chartData = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $chartDates[] = $date->translatedFormat('d M');
            $dailyTotal = Sale::whereDate('created_at', $date)->where('status_bayar', 'lunas')->sum('total');
            $chartData[] = $dailyTotal;
        }

        return view('manager.dashboardMNG', compact('salesToday', 'salesMonth', 'pendingTransactions', 'chartDates', 'chartData'));
    }

    public function index(Request $request)
    {
        $branches = Branch::all();
        $query = Sale::with('cabang', 'kasir', 'pelanggan')->where('status_bayar', 'lunas');

        if ($request->filled('cabang_id')) {
            $query->where('cabang_id', $request->cabang_id);
        }

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('created_at', [$request->start_date . ' 00:00:00', $request->end_date . ' 23:59:59']);
        }

        $sales = $query->latest()->get();
        $totalRevenue = $sales->sum('total');

        return view('manager.laporan.index', compact('sales', 'branches', 'totalRevenue'));
    }

    public function exportPdf(Request $request)
    {
        $query = Sale::with('cabang', 'kasir', 'pelanggan')->where('status_bayar', 'lunas');

        $namaCabang = 'Semua Cabang';
        if ($request->filled('cabang_id')) {
            $query->where('cabang_id', $request->cabang_id);
            $namaCabang = Branch::find($request->cabang_id)->nama ?? 'Semua Cabang';
        }

        $periode = 'Semua Tanggal';
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('created_at', [$request->start_date . ' 00:00:00', $request->end_date . ' 23:59:59']);
            $periode = $request->start_date . ' s/d ' . $request->end_date;
        }

        $sales = $query->latest()->get();
        $totalRevenue = $sales->sum('total');

        $pdf = Pdf::loadView('manager.laporan.pdf', [
            'sales' => $sales,
            'totalRevenue' => $totalRevenue,
            'namaCabang' => $namaCabang,
            'periode' => $periode,
        ])->setPaper('a4', 'landscape');
        
        return $pdf->stream('Laporan_Penjualan_' . date('Ymd_His') . '.pdf');
    }
}
