<?php

namespace Database\Factories;

use App\Models\Kemasan;
use App\Models\KemasanBahan;
use Illuminate\Database\Eloquent\Factories\Factory;

class KemasanFactory extends Factory
{
    protected $model = Kemasan::class;

    public function definition(): array
    {
        return [
            'nama_kemasan' => fake()->word(),
            'ukuran' => fake()->randomElement(['10x15cm', '20x30cm', '500ml', '1liter']),
            'harga_kemasan' => 0,
        ];
    }

    public function withBahan($idBahan, $jumlahPerUnit = 1)
    {
        return $this->afterCreating(function (Kemasan $kemasan) use ($idBahan, $jumlahPerUnit) {
            KemasanBahan::create([
                'id_kemasan' => $kemasan->id_kemasan,
                'id_bahan' => $idBahan,
                'jumlah_per_unit' => $jumlahPerUnit,
            ]);
            $harga = \App\Models\BahanBaku::where('id_bahan', $idBahan)->value('harga_per_satuan') * $jumlahPerUnit;
            $kemasan->update(['harga_kemasan' => $harga]);
        });
    }
}
