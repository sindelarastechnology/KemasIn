<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;

class ProdukController extends Controller
{
    public function index()
    {
        $produk = Produk::orderBy('nama_produk')->paginate(10);
        return view('produk.index', compact('produk'));
    }

    public function create()
    {
        return view('produk.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_produk' => 'required|max:100',
            'stok_tersedia' => 'required|integer|min:0',
            'stok_sudah_dikemas' => 'integer|min:0',
            'stok_minimum' => 'required|integer|min:0',
            'harga_produk' => 'required|numeric|min:0',
            'keterangan' => 'nullable|string|max:1000',
        ]);

        Produk::create($request->all());

        return redirect()->route('produk.index')
            ->with('success', 'Produk berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $produk = Produk::findOrFail($id);
        return view('produk.edit', compact('produk'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_produk' => 'required|max:100',
            'stok_tersedia' => 'required|integer|min:0',
            'stok_sudah_dikemas' => 'integer|min:0',
            'stok_minimum' => 'required|integer|min:0',
            'harga_produk' => 'required|numeric|min:0',
            'keterangan' => 'nullable|string|max:1000',
        ]);

        Produk::findOrFail($id)->update($request->all());

        return redirect()->route('produk.index')
            ->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $produk = Produk::findOrFail($id);

        if ($produk->pengemasan()->exists()) {
            return redirect()->route('produk.index')
                ->with('error', 'Produk tidak bisa dihapus karena sudah digunakan di pengemasan.');
        }

        $produk->delete();

        return redirect()->route('produk.index')
            ->with('success', 'Produk berhasil dihapus.');
    }
}
