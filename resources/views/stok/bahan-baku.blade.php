@extends('layouts.app')

@section('title', 'Stok Bahan Baku')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0">Stok Bahan Baku</h4>
</div>

<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Bahan</th>
                        <th>Satuan</th>
                        <th>Stok Tersedia</th>
                        <th>Stok Minimum</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($bahanBaku as $key => $b)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td><strong>{{ $b->nama_bahan }}</strong></td>
                        <td>{{ $b->satuan }}</td>
                        <td>{{ number_format($b->stok_tersedia, 2) }}</td>
                        <td>{{ number_format($b->stok_minimum, 2) }}</td>
                        <td>
                            @if($b->stok_tersedia <= $b->stok_minimum)
                                <span class="badge bg-danger">Kritis</span>
                            @else
                                <span class="badge bg-success">Aman</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-4 text-muted">Belum ada data bahan baku</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
