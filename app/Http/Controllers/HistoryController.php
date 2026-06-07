<?php

namespace App\Http\Controllers;

use App\Models\MutasiBahan;
use App\Models\ProgresPengemasan;
use Illuminate\Http\Request;

class HistoryController extends Controller
{
    public function pengemasan(Request $request)
    {
        $progres = ProgresPengemasan::with([
            'pengemasan.produk',
            'pengemasan.kemasan',
            'pengguna',
            'pengemasan.pengemasanBahan.bahanBaku',
        ])
        ->when(auth()->user()->role === 'operator', function ($q) {
            $q->where('id_pengguna', auth()->id());
        })
        ->latest('waktu_diproses')
        ->paginate(20);

        return view('history.pengemasan', compact('progres'));
    }

    public function bahanBaku(Request $request)
    {
        $mutasi = MutasiBahan::with(['bahan', 'pengguna'])
            ->when(auth()->user()->role === 'operator', function ($q) {
                $q->where('id_pengguna', auth()->id());
            })
            ->latest('created_at')
            ->paginate(20);

        return view('history.bahan-baku', compact('mutasi'));
    }
}
