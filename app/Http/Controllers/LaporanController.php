<?php

namespace App\Http\Controllers;

use App\Models\BahanBaku;
use App\Models\MutasiBahan;
use App\Models\Pengemasan;
use App\Models\ProgresPengemasan;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index()
    {
        return view('laporan.index');
    }

    public function pengemasan(Request $request)
    {
        $tanggalAwal = $request->tanggal_awal ?: now()->startOfMonth()->format('Y-m-d');
        $tanggalAkhir = $request->tanggal_akhir ?: now()->format('Y-m-d');

        $pengemasan = Pengemasan::with(['produk', 'kemasan', 'operatorDitugaskan'])
            ->whereBetween('tgl_pengemasan', [$tanggalAwal, $tanggalAkhir])
            ->latest()
            ->get();

        $totalTarget = $pengemasan->sum('target_jumlah');
        $totalHasil = $pengemasan->sum('hasil_pengemasan');
        $totalBatch = $pengemasan->count();

        return view('laporan.pengemasan', compact(
            'pengemasan', 'tanggalAwal', 'tanggalAkhir',
            'totalTarget', 'totalHasil', 'totalBatch'
        ));
    }

    public function exportPengemasan(Request $request)
    {
        $tanggalAwal = $request->tanggal_awal ?: now()->startOfMonth()->format('Y-m-d');
        $tanggalAkhir = $request->tanggal_akhir ?: now()->format('Y-m-d');

        $pengemasan = Pengemasan::with(['produk', 'kemasan', 'operatorDitugaskan'])
            ->whereBetween('tgl_pengemasan', [$tanggalAwal, $tanggalAkhir])
            ->latest()
            ->get();

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="laporan-pengemasan-' . now()->format('Y-m-d') . '.csv"',
        ];

        $callback = function () use ($pengemasan) {
            $file = fopen('php://output', 'w');
            fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF));

            fputcsv($file, ['No', 'Produk', 'Kemasan', 'Tanggal', 'Target', 'Hasil', 'Status', 'Operator']);

            foreach ($pengemasan as $i => $p) {
                fputcsv($file, [
                    $i + 1,
                    $p->produk->nama_produk ?? '-',
                    $p->kemasan->nama_kemasan ?? '-',
                    $p->tgl_pengemasan->format('d/m/Y'),
                    $p->target_jumlah,
                    $p->hasil_pengemasan,
                    $p->status,
                    $p->operatorDitugaskan->nama_lengkap ?? $p->pengguna->nama_lengkap ?? '-',
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function exportPengemasanPdf(Request $request)
    {
        $tanggalAwal = $request->tanggal_awal ?: now()->startOfMonth()->format('Y-m-d');
        $tanggalAkhir = $request->tanggal_akhir ?: now()->format('Y-m-d');

        $pengemasan = Pengemasan::with(['produk', 'kemasan', 'operatorDitugaskan'])
            ->whereBetween('tgl_pengemasan', [$tanggalAwal, $tanggalAkhir])
            ->latest()
            ->get();

        $totalTarget = $pengemasan->sum('target_jumlah');
        $totalHasil = $pengemasan->sum('hasil_pengemasan');
        $totalBatch = $pengemasan->count();

        $pdf = Pdf::loadView('laporan.pdf-pengemasan', compact(
            'pengemasan', 'tanggalAwal', 'tanggalAkhir',
            'totalTarget', 'totalHasil', 'totalBatch'
        ));

        return $pdf->download('laporan-pengemasan-' . now()->format('Y-m-d') . '.pdf');
    }

    public function bahanBaku(Request $request)
    {
        $tanggalAwal = $request->tanggal_awal ?: now()->startOfMonth()->format('Y-m-d');
        $tanggalAkhir = $request->tanggal_akhir ?: now()->format('Y-m-d');

        $mutasi = MutasiBahan::with(['bahan', 'pengguna'])
            ->whereBetween('created_at', [$tanggalAwal . ' 00:00:00', $tanggalAkhir . ' 23:59:59'])
            ->latest('created_at')
            ->get();

        $totalPemakaian = $mutasi->where('jenis', 'pemakaian')->sum('jumlah');
        $totalPenambahan = $mutasi->whereIn('jenis', ['penambahan', 'bahan_baru'])->sum('jumlah');
        $totalMutasi = $mutasi->count();

        return view('laporan.bahan-baku', compact(
            'mutasi', 'tanggalAwal', 'tanggalAkhir',
            'totalPemakaian', 'totalPenambahan', 'totalMutasi'
        ));
    }

    public function exportBahanBaku(Request $request)
    {
        $tanggalAwal = $request->tanggal_awal ?: now()->startOfMonth()->format('Y-m-d');
        $tanggalAkhir = $request->tanggal_akhir ?: now()->format('Y-m-d');

        $mutasi = MutasiBahan::with(['bahan', 'pengguna'])
            ->whereBetween('created_at', [$tanggalAwal . ' 00:00:00', $tanggalAkhir . ' 23:59:59'])
            ->latest('created_at')
            ->get();

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="laporan-bahan-baku-' . now()->format('Y-m-d') . '.csv"',
        ];

        $callback = function () use ($mutasi) {
            $file = fopen('php://output', 'w');
            fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF));

            fputcsv($file, ['No', 'Tanggal', 'Bahan', 'Jenis', 'Jumlah', 'Stok Sebelum', 'Stok Sesudah', 'Harga Sebelum', 'Harga Sesudah', 'Keterangan', 'Oleh']);

            foreach ($mutasi as $i => $m) {
                $labelJenis = match ($m->jenis) {
                    'pemakaian' => 'Pemakaian',
                    'penambahan' => 'Penambahan Stok',
                    'bahan_baru' => 'Bahan Baru',
                    'penyesuaian' => 'Penyesuaian',
                    default => $m->jenis,
                };
                fputcsv($file, [
                    $i + 1,
                    \Carbon\Carbon::parse($m->created_at)->format('d/m/Y H:i'),
                    $m->bahan->nama_bahan ?? '-',
                    $labelJenis,
                    $m->jumlah,
                    $m->stok_sebelum,
                    $m->stok_sesudah,
                    $m->harga_sebelum ? 'Rp ' . number_format($m->harga_sebelum, 2) : '-',
                    $m->harga_sesudah ? 'Rp ' . number_format($m->harga_sesudah, 2) : '-',
                    $m->keterangan ?? '-',
                    $m->pengguna->nama_lengkap ?? '-',
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
