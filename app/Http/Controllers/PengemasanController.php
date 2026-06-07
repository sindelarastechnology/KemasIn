<?php

namespace App\Http\Controllers;

use App\Models\BahanBaku;
use App\Models\Kemasan;
use App\Models\MutasiBahan;
use App\Models\Pengemasan;
use App\Models\PengemasanBahan;
use App\Models\ProgresPengemasan;
use App\Models\Produk;
use App\Models\Pengguna;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PengemasanController extends Controller
{
    public function index()
    {
        $pengemasan = Pengemasan::with(['produk', 'kemasan', 'operatorDitugaskan'])
            ->latest()
            ->paginate(10);

        return view('pengemasan.index', compact('pengemasan'));
    }

    public function create()
    {
        $produk = Produk::all();
        $kemasan = Kemasan::with('bahan.bahanBaku')->get();
        $operator = Pengguna::where('role', 'operator')->get();

        return view('pengemasan.create', compact('produk', 'kemasan', 'operator'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_produk' => 'required|exists:tbl_produk,id_produk',
            'id_kemasan' => 'required|exists:tbl_kemasan,id_kemasan',
            'tgl_pengemasan' => 'required|date',
            'target_jumlah' => 'required|integer|min:1',
            'expired_date' => 'required|date|after:tgl_pengemasan',
            'id_operator_ditugaskan' => 'nullable|array',
            'id_operator_ditugaskan.*' => 'exists:tbl_pengguna,id_pengguna',
        ]);

        $kemasan = Kemasan::with('bahan.bahanBaku')->findOrFail($request->id_kemasan);

        if ($kemasan->bahan->isEmpty()) {
            return redirect()->back()->with('error', 'Kemasan ini belum memiliki komposisi bahan baku.')->withInput();
        }

        foreach ($kemasan->bahan as $b) {
            $kebutuhan = $b->jumlah_per_unit * $request->target_jumlah;
            if ($b->bahanBaku->stok_tersedia < $kebutuhan) {
                return redirect()->back()
                    ->with('error', "Stok {$b->bahanBaku->nama_bahan} tidak mencukupi untuk target ini (butuh {$kebutuhan}, tersedia {$b->bahanBaku->stok_tersedia}).")
                    ->withInput();
            }
        }

        $pengemasan = Pengemasan::create([
            'id_produk' => $request->id_produk,
            'id_produksi' => null,
            'id_kemasan' => $request->id_kemasan,
            'tgl_pengemasan' => $request->tgl_pengemasan,
            'target_jumlah' => $request->target_jumlah,
            'hasil_pengemasan' => 0,
            'expired_date' => $request->expired_date,
            'id_pengguna' => auth()->user()->id_pengguna,
            'status' => 'direncanakan',
        ]);

        if ($request->filled('id_operator_ditugaskan')) {
            $pengemasan->operatorDitugaskan()->sync($request->id_operator_ditugaskan);
        }

        foreach ($kemasan->bahan as $b) {
            PengemasanBahan::create([
                'id_pengemasan' => $pengemasan->id_pengemasan,
                'id_bahan' => $b->id_bahan,
                'jumlah_per_unit' => $b->jumlah_per_unit,
                'total_terealisasi' => 0,
            ]);
        }

        return redirect()->route('pengemasan.index')
            ->with('success', 'Target pengemasan berhasil dibuat.');
    }

    public function show($id)
    {
        $pengemasan = Pengemasan::with([
            'produk',
            'kemasan',
            'pengguna',
            'operatorDitugaskan',
            'progresPengemasan.pengguna',
            'pengemasanBahan.bahanBaku',
        ])->findOrFail($id);

        $operator = Pengguna::where('role', 'operator')->get();

        return view('pengemasan.show', compact('pengemasan', 'operator'));
    }

    public function edit($id)
    {
        $pengemasan = Pengemasan::with(['pengemasanBahan.bahanBaku', 'operatorDitugaskan'])->findOrFail($id);
        $produk = Produk::all();
        $kemasan = Kemasan::with('bahan.bahanBaku')->get();
        $operator = Pengguna::where('role', 'operator')->get();

        return view('pengemasan.edit', compact('pengemasan', 'produk', 'kemasan', 'operator'));
    }

    public function update(Request $request, $id)
    {
        $pengemasan = Pengemasan::findOrFail($id);

        if ($pengemasan->status === 'selesai' || $pengemasan->status === 'dibatalkan') {
            return redirect()->back()->with('error', 'Tidak bisa mengubah target yang sudah selesai/dibatalkan.');
        }

        if ($pengemasan->progresPengemasan()->exists()) {
            return redirect()->back()->with('error', 'Tidak bisa mengubah target karena sudah ada progres pengemasan.');
        }

        $request->validate([
            'id_produk' => 'required|exists:tbl_produk,id_produk',
            'id_kemasan' => 'required|exists:tbl_kemasan,id_kemasan',
            'tgl_pengemasan' => 'required|date',
            'target_jumlah' => 'required|integer|min:1',
            'expired_date' => 'required|date|after:tgl_pengemasan',
            'id_operator_ditugaskan' => 'nullable|array',
            'id_operator_ditugaskan.*' => 'exists:tbl_pengguna,id_pengguna',
        ]);

        $pengemasan->update($request->only([
            'id_produk', 'id_kemasan', 'tgl_pengemasan', 'target_jumlah',
            'expired_date',
        ]));

        if ($request->filled('id_operator_ditugaskan')) {
            $pengemasan->operatorDitugaskan()->sync($request->id_operator_ditugaskan);
        } else {
            $pengemasan->operatorDitugaskan()->detach();
        }

        $kemasan = Kemasan::with('bahan.bahanBaku')->findOrFail($request->id_kemasan);

        $pengemasan->pengemasanBahan()->delete();

        foreach ($kemasan->bahan as $b) {
            PengemasanBahan::create([
                'id_pengemasan' => $pengemasan->id_pengemasan,
                'id_bahan' => $b->id_bahan,
                'jumlah_per_unit' => $b->jumlah_per_unit,
                'total_terealisasi' => 0,
            ]);
        }

        return redirect()->route('pengemasan.index')
            ->with('success', 'Target pengemasan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $pengemasan = Pengemasan::findOrFail($id);

        if ($pengemasan->progresPengemasan()->exists()) {
            return redirect()->back()->with('error', 'Tidak bisa hapus karena sudah ada progres.');
        }

        $pengemasan->delete();

        return redirect()->route('pengemasan.index')
            ->with('success', 'Target pengemasan berhasil dihapus.');
    }

    public function tambahProgres(Request $request, $id)
    {
        $request->validate([
            'jumlah_dikemas' => 'required|integer|min:1',
            'keterangan' => 'nullable|string|max:500',
        ]);

        $pengemasan = Pengemasan::with(['pengemasanBahan.bahanBaku', 'operatorDitugaskan'])->findOrFail($id);

        if ($pengemasan->status === 'selesai' || $pengemasan->status === 'dibatalkan') {
            return redirect()->back()->with('error', 'Pengemasan sudah selesai/dibatalkan.');
        }

        $user = auth()->user();

        if ($user->role !== 'admin' && $pengemasan->operatorDitugaskan->isNotEmpty()) {
            $assignedIds = $pengemasan->operatorDitugaskan->pluck('id_pengguna')->toArray();
            if (!in_array($user->id_pengguna, $assignedIds)) {
                return redirect()->back()->with('error', 'Anda tidak ditugaskan untuk target ini.');
            }
        }

        $sudahDikemas = (int) $pengemasan->progresPengemasan()->sum('jumlah_dikemas');
        $sisaTarget = $pengemasan->target_jumlah - $sudahDikemas;

        if ($request->jumlah_dikemas > $sisaTarget) {
            return redirect()->back()->with('error', "Jumlah melebihi sisa target ($sisaTarget).");
        }

        DB::beginTransaction();
        try {
            foreach ($pengemasan->pengemasanBahan as $detail) {
                $bahan = BahanBaku::where('id_bahan', $detail->id_bahan)->lockForUpdate()->first();
                $pengurangan = $detail->jumlah_per_unit * $request->jumlah_dikemas;

                if ($bahan->stok_tersedia < $pengurangan) {
                    DB::rollBack();
                    return redirect()->back()->with('error', "Stok {$bahan->nama_bahan} tidak mencukupi (tersedia: {$bahan->stok_tersedia}, dibutuhkan: {$pengurangan}).");
                }
            }

            ProgresPengemasan::create([
                'id_pengemasan' => $pengemasan->id_pengemasan,
                'id_pengguna' => $user->id_pengguna,
                'jumlah_dikemas' => $request->jumlah_dikemas,
                'keterangan' => $request->keterangan,
                'waktu_diproses' => Carbon::now(),
            ]);

            $pengemasan->increment('hasil_pengemasan', $request->jumlah_dikemas);

            foreach ($pengemasan->pengemasanBahan as $detail) {
                $pengurangan = $detail->jumlah_per_unit * $request->jumlah_dikemas;

                $detail->increment('total_terealisasi', $pengurangan);

                $bahan = BahanBaku::where('id_bahan', $detail->id_bahan)->first();
                $stokSebelum = $bahan->stok_tersedia;
                $bahan->decrement('stok_tersedia', $pengurangan);

                MutasiBahan::create([
                    'id_bahan' => $detail->id_bahan,
                    'jenis' => 'pemakaian',
                    'jumlah' => -$pengurangan,
                    'stok_sebelum' => $stokSebelum,
                    'stok_sesudah' => $bahan->fresh()->stok_tersedia,
                    'harga_sebelum' => $bahan->harga_per_satuan,
                    'harga_sesudah' => $bahan->harga_per_satuan,
                    'keterangan' => 'Pemakaian untuk pengemasan #' . $pengemasan->id_pengemasan,
                    'id_pengguna' => $user->id_pengguna,
                    'created_at' => Carbon::now(),
                ]);
            }

            if ($pengemasan->id_produk) {
                $produk = Produk::where('id_produk', $pengemasan->id_produk)->lockForUpdate()->first();

                if ($produk->stok_tersedia < $request->jumlah_dikemas) {
                    DB::rollBack();
                    return redirect()->back()->with('error', "Stok produk belum dikemas tidak mencukupi (tersedia: {$produk->stok_tersedia}, dibutuhkan: {$request->jumlah_dikemas}).");
                }

                $produk->decrement('stok_tersedia', $request->jumlah_dikemas);
                $produk->increment('stok_sudah_dikemas', $request->jumlah_dikemas);
            }

            $totalBaru = $pengemasan->fresh()->hasil_pengemasan;
            if ($totalBaru >= $pengemasan->target_jumlah) {
                $pengemasan->update(['status' => 'selesai']);
            } else {
                $pengemasan->update(['status' => 'proses']);
            }

            DB::commit();

            return redirect()->back()
                ->with('success', "Progres pengemasan berhasil dicatat: {$request->jumlah_dikemas} unit dikemas.");
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function batalkan($id)
    {
        $pengemasan = Pengemasan::with('pengemasanBahan')->findOrFail($id);

        if ($pengemasan->status === 'selesai' || $pengemasan->status === 'dibatalkan') {
            return redirect()->back()->with('error', 'Pengemasan sudah selesai/dibatalkan.');
        }

        DB::beginTransaction();
        try {
            $totalDikemas = (int) $pengemasan->progresPengemasan()->sum('jumlah_dikemas');

            if ($totalDikemas > 0) {
                foreach ($pengemasan->pengemasanBahan as $detail) {
                    if ($detail->total_terealisasi > 0) {
                        BahanBaku::where('id_bahan', $detail->id_bahan)
                            ->lockForUpdate()
                            ->increment('stok_tersedia', $detail->total_terealisasi);
                    }
                }

                if ($pengemasan->id_produk && $totalDikemas > 0) {
                    $produk = Produk::where('id_produk', $pengemasan->id_produk)
                        ->lockForUpdate()
                        ->first();

                    $produk->decrement('stok_sudah_dikemas', $totalDikemas);
                    $produk->increment('stok_tersedia', $totalDikemas);
                }
            }

            $pengemasan->update(['status' => 'dibatalkan']);

            DB::commit();

            return redirect()->route('pengemasan.index')
                ->with('success', 'Target pengemasan dibatalkan. Stok bahan baku dan produk sudah dikembalikan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Gagal membatalkan: ' . $e->getMessage());
        }
    }

    public function riwayatProgres($id)
    {
        $progres = ProgresPengemasan::with('pengguna')
            ->where('id_pengemasan', $id)
            ->orderBy('waktu_diproses')
            ->get();

        return response()->json($progres);
    }
}
