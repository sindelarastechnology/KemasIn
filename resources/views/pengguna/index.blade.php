@extends('layouts.app')

@section('title', 'Kelola Pengguna')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
    <h4 class="fw-bold mb-0">Kelola Pengguna</h4>
    <a href="{{ route('pengguna.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Tambah Pengguna
    </a>
</div>

<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Username</th>
                        <th>Nama Lengkap</th>
                        <th>Role</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pengguna as $key => $p)
                    <tr>
                        <td>{{ $pengguna->firstItem() + $key }}</td>
                        <td><strong>{{ $p->username }}</strong></td>
                        <td>{{ $p->nama_lengkap }}</td>
                        <td>
                            <span class="badge bg-{{ $p->role == 'admin' ? 'danger' : ($p->role == 'pemilik' ? 'primary' : 'secondary') }}">
                                {{ ucfirst($p->role) }}
                            </span>
                        </td>
                        <td>
                            <div class="btn-group">
                                <a href="{{ route('pengguna.edit', $p->id_pengguna) }}" class="btn btn-sm btn-warning" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                @if(auth()->user()->id_pengguna != $p->id_pengguna)
                                <form action="{{ route('pengguna.destroy', $p->id_pengguna) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus {{ $p->nama_lengkap }}?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-4 text-muted">Belum ada data pengguna</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($pengguna->hasPages())
    <div class="card-footer">
        {{ $pengguna->links() }}
    </div>
    @endif
</div>
@endsection
