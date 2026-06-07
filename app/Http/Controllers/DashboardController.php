<?php

namespace App\Http\Controllers;

use App\Models\BahanBaku;
use App\Models\Pengemasan;
use App\Models\Produk;
use App\Models\ProgresPengemasan;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $now = Carbon::now();
        $bulanIni = $now->month;
        $tahunIni = $now->year;

        $totalPengemasan = ProgresPengemasan::whereHas('pengemasan', function ($q) use ($bulanIni, $tahunIni) {
                $q->whereMonth('tgl_pengemasan', $bulanIni)
                  ->whereYear('tgl_pengemasan', $tahunIni);
            })
            ->sum('jumlah_dikemas');

        $bahanKritis = BahanBaku::whereColumn('stok_tersedia', '<=', 'stok_minimum')->count();

        $produkBelumDikemasKritis = Produk::whereColumn('stok_tersedia', '<=', 'stok_minimum')->count();

        $tanggal7Hari = [];
        $dataPengemasanGrafik = [];

        for ($i = 6; $i >= 0; $i--) {
            $tgl = Carbon::now()->subDays($i)->format('Y-m-d');
            $tanggal7Hari[] = Carbon::now()->subDays($i)->format('d/m');

            $peng = ProgresPengemasan::whereHas('pengemasan', function ($q) use ($tgl) {
                    $q->where('tgl_pengemasan', $tgl);
                })
                ->sum('jumlah_dikemas');
            $dataPengemasanGrafik[] = (int) $peng;
        }

        $pengemasanTerbaru = Pengemasan::with('produk', 'kemasan')
            ->latest()
            ->take(5)
            ->get();

        $totalStokBelumDikemas = Produk::sum('stok_tersedia');
        $totalStokSudahDikemas = Produk::sum('stok_sudah_dikemas');

        return view('dashboard.index', compact(
            'totalPengemasan',
            'bahanKritis',
            'produkBelumDikemasKritis',
            'tanggal7Hari',
            'dataPengemasanGrafik',
            'pengemasanTerbaru',
            'totalStokBelumDikemas',
            'totalStokSudahDikemas',
        ));
    }
}
