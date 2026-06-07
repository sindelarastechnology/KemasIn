<?php

namespace App\Http\Controllers;

use App\Models\BahanBaku;
use App\Models\MutasiBahan;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BahanBakuController extends Controller
{
    public function index()
    {
        $bahanBaku = BahanBaku::paginate(10);
        return view('bahan-baku.index', compact('bahanBaku'));
    }

    public function create()
    {
        return view('bahan-baku.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_bahan' => 'required|max:100',
            'satuan' => 'required',
            'stok_tersedia' => 'numeric|min:0',
            'stok_minimum' => 'required|numeric|min:0',
            'harga_per_satuan' => 'required|numeric|min:0',
            'keterangan' => 'nullable',
        ]);

        $bahan = BahanBaku::create($request->all());

        MutasiBahan::create([
            'id_bahan' => $bahan->id_bahan,
            'jenis' => 'bahan_baru',
            'jumlah' => $bahan->stok_tersedia,
            'stok_sebelum' => 0,
            'stok_sesudah' => $bahan->stok_tersedia,
            'harga_sebelum' => null,
            'harga_sesudah' => $bahan->harga_per_satuan,
            'keterangan' => 'Bahan baku baru: ' . $bahan->nama_bahan,
            'id_pengguna' => auth()->id(),
            'created_at' => Carbon::now(),
        ]);

        return redirect()->route('bahan-baku.index')
            ->with('success', 'Bahan baku berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $bahanBaku = BahanBaku::findOrFail($id);
        return view('bahan-baku.edit', compact('bahanBaku'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_bahan' => 'required|max:100',
            'satuan' => 'required',
            'stok_tersedia' => 'numeric|min:0',
            'stok_minimum' => 'required|numeric|min:0',
            'harga_per_satuan' => 'required|numeric|min:0',
            'keterangan' => 'nullable',
        ]);

        $bahanBaku = BahanBaku::findOrFail($id);
        $bahanBaku->update($request->all());

        return redirect()->route('bahan-baku.index')
            ->with('success', 'Bahan baku berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $bahan = BahanBaku::findOrFail($id);

        $dipakai = MutasiBahan::where('id_bahan', $id)->where('jenis', 'pemakaian')->exists();
        if ($dipakai) {
            return redirect()->route('bahan-baku.index')
                ->with('error', 'Bahan baku tidak bisa dihapus karena sudah pernah dipakai dalam pengemasan.');
        }

        $bahan->delete();

        return redirect()->route('bahan-baku.index')
            ->with('success', 'Bahan baku berhasil dihapus.');
    }

    public function tambahStok($id)
    {
        $bahan = BahanBaku::findOrFail($id);
        return view('bahan-baku.tambah-stok', compact('bahan'));
    }

    public function simpanTambahStok(Request $request, $id)
    {
        $request->validate([
            'jumlah_tambah' => 'required|numeric|min:0.01',
            'harga_per_satuan' => 'nullable|numeric|min:0',
            'keterangan' => 'nullable|string|max:500',
        ]);

        $bahan = BahanBaku::findOrFail($id);
        $stokSebelum = $bahan->stok_tersedia;
        $hargaSebelum = $bahan->harga_per_satuan;

        $bahan->increment('stok_tersedia', $request->jumlah_tambah);

        $hargaSesudah = $hargaSebelum;
        if ($request->filled('harga_per_satuan')) {
            $bahan->update(['harga_per_satuan' => $request->harga_per_satuan]);
            $hargaSesudah = $request->harga_per_satuan;
        }

        MutasiBahan::create([
            'id_bahan' => $bahan->id_bahan,
            'jenis' => 'penambahan',
            'jumlah' => $request->jumlah_tambah,
            'stok_sebelum' => $stokSebelum,
            'stok_sesudah' => $bahan->fresh()->stok_tersedia,
            'harga_sebelum' => $hargaSebelum,
            'harga_sesudah' => $hargaSesudah,
            'keterangan' => $request->keterangan ?: 'Penambahan stok manual',
            'id_pengguna' => auth()->id(),
            'created_at' => Carbon::now(),
        ]);

        return redirect()->route('bahan-baku.index')
            ->with('success', "Stok {$bahan->nama_bahan} berhasil ditambah {$request->jumlah_tambah} {$bahan->satuan}.");
    }

    public function cekStok($id)
    {
        $bahan = BahanBaku::findOrFail($id);

        return response()->json([
            'id_bahan' => $bahan->id_bahan,
            'nama_bahan' => $bahan->nama_bahan,
            'stok_tersedia' => $bahan->stok_tersedia,
            'satuan' => $bahan->satuan,
        ]);
    }
}
