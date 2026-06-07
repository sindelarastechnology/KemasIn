<?php

namespace App\Http\Controllers;

use App\Models\BahanBaku;
use App\Models\Produk;

class StokProdukController extends Controller
{
    public function index()
    {
        $produk = Produk::orderBy('stok_tersedia')
            ->get();

        return view('stok.index', compact('produk'));
    }

    public function bahanBaku()
    {
        $bahanBaku = BahanBaku::orderBy('stok_tersedia')->get();
        return view('stok.bahan-baku', compact('bahanBaku'));
    }
}
