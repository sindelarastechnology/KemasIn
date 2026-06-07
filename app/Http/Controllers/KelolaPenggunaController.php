<?php

namespace App\Http\Controllers;

use App\Models\Pengguna;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class KelolaPenggunaController extends Controller
{
    public function index()
    {
        $pengguna = Pengguna::paginate(10);
        return view('pengguna.index', compact('pengguna'));
    }

    public function create()
    {
        return view('pengguna.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|unique:tbl_pengguna,username|max:50',
            'password' => 'required|min:8',
            'nama_lengkap' => 'required|max:100',
            'role' => 'required|in:admin,operator,pemilik',
        ]);

        Pengguna::create([
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'nama_lengkap' => $request->nama_lengkap,
            'role' => $request->role,
        ]);

        return redirect()->route('pengguna.index')
            ->with('success', 'Pengguna berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $pengguna = Pengguna::findOrFail($id);
        return view('pengguna.edit', compact('pengguna'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'username' => 'required|unique:tbl_pengguna,username,' . $id . ',id_pengguna|max:50',
            'nama_lengkap' => 'required|max:100',
            'role' => 'required|in:admin,operator,pemilik',
            'password' => 'nullable|min:8',
        ]);

        $pengguna = Pengguna::findOrFail($id);

        $data = [
            'username' => $request->username,
            'nama_lengkap' => $request->nama_lengkap,
            'role' => $request->role,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $pengguna->update($data);

        return redirect()->route('pengguna.index')
            ->with('success', 'Pengguna berhasil diperbarui.');
    }

    public function destroy($id)
    {
        if (auth()->user()->id_pengguna == $id) {
            return redirect()->route('pengguna.index')
                ->with('error', 'Tidak bisa menghapus akun sendiri.');
        }

        Pengguna::findOrFail($id)->delete();

        return redirect()->route('pengguna.index')
            ->with('success', 'Pengguna berhasil dihapus.');
    }
}
