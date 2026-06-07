<?php

namespace App\Http\Controllers;

use App\Models\BahanBaku;
use App\Models\Kemasan;
use App\Models\KemasanBahan;
use Illuminate\Http\Request;

class KemasanController extends Controller
{
    public function index()
    {
        $kemasan = Kemasan::with('bahan.bahanBaku')->latest()->paginate(10);
        return view('kemasan.index', compact('kemasan'));
    }

    public function create()
    {
        $bahanBaku = BahanBaku::all();
        return view('kemasan.create', compact('bahanBaku'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kemasan' => 'required|max:100',
            'ukuran' => 'required|max:50',
            'bahan' => 'required|array|min:1',
            'bahan.*.id_bahan' => 'required|exists:tbl_bahan_baku,id_bahan',
            'bahan.*.jumlah_per_unit' => 'required|numeric|min:0.01',
        ]);

        $totalHarga = $this->hitungHargaDariBahan($request->bahan);

        $kemasan = Kemasan::create([
            'nama_kemasan' => $request->nama_kemasan,
            'ukuran' => $request->ukuran,
            'harga_kemasan' => $totalHarga,
        ]);

        foreach ($request->bahan as $b) {
            KemasanBahan::create([
                'id_kemasan' => $kemasan->id_kemasan,
                'id_bahan' => $b['id_bahan'],
                'jumlah_per_unit' => $b['jumlah_per_unit'],
            ]);
        }

        return redirect()->route('kemasan.index')
            ->with('success', 'Kemasan berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $kemasan = Kemasan::with('bahan.bahanBaku')->findOrFail($id);
        $bahanBaku = BahanBaku::all();
        return view('kemasan.edit', compact('kemasan', 'bahanBaku'));
    }

    public function update(Request $request, $id)
    {
        $kemasan = Kemasan::findOrFail($id);

        $request->validate([
            'nama_kemasan' => 'required|max:100',
            'ukuran' => 'required|max:50',
            'bahan' => 'required|array|min:1',
            'bahan.*.id_bahan' => 'required|exists:tbl_bahan_baku,id_bahan',
            'bahan.*.jumlah_per_unit' => 'required|numeric|min:0.01',
        ]);

        $totalHarga = $this->hitungHargaDariBahan($request->bahan);

        $kemasan->update([
            'nama_kemasan' => $request->nama_kemasan,
            'ukuran' => $request->ukuran,
            'harga_kemasan' => $totalHarga,
        ]);

        $kemasan->bahan()->delete();

        foreach ($request->bahan as $b) {
            KemasanBahan::create([
                'id_kemasan' => $kemasan->id_kemasan,
                'id_bahan' => $b['id_bahan'],
                'jumlah_per_unit' => $b['jumlah_per_unit'],
            ]);
        }

        return redirect()->route('kemasan.index')
            ->with('success', 'Kemasan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $kemasan = Kemasan::findOrFail($id);

        if ($kemasan->pengemasan()->exists()) {
            return redirect()->back()->with('error', 'Kemasan tidak bisa dihapus karena sudah digunakan di pengemasan.');
        }

        $kemasan->delete();

        return redirect()->route('kemasan.index')
            ->with('success', 'Kemasan berhasil dihapus.');
    }

    public function getBahan($id)
    {
        $kemasan = Kemasan::with('bahan.bahanBaku')->findOrFail($id);

        return response()->json([
            'bahan' => $kemasan->bahan->map(function ($b) {
                return [
                    'id_bahan' => $b->id_bahan,
                    'nama_bahan' => $b->bahanBaku->nama_bahan,
                    'satuan' => $b->bahanBaku->satuan,
                    'stok_tersedia' => $b->bahanBaku->stok_tersedia,
                    'jumlah_per_unit' => $b->jumlah_per_unit,
                ];
            }),
            'harga_kemasan' => $kemasan->harga_kemasan,
        ]);
    }

    private function hitungHargaDariBahan(array $bahan): float
    {
        $total = 0;
        $ids = collect($bahan)->pluck('id_bahan')->unique();
        $bahanModels = BahanBaku::whereIn('id_bahan', $ids)->get()->keyBy('id_bahan');

        foreach ($bahan as $b) {
            $bahanModel = $bahanModels->get($b['id_bahan']);
            if ($bahanModel) {
                $total += $bahanModel->harga_per_satuan * $b['jumlah_per_unit'];
            }
        }

        return $total;
    }
}
