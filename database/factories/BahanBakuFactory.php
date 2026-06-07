<?php

namespace Database\Factories;

use App\Models\BahanBaku;
use Illuminate\Database\Eloquent\Factories\Factory;

class BahanBakuFactory extends Factory
{
    protected $model = BahanBaku::class;

    public function definition(): array
    {
        return [
            'nama_bahan' => fake()->word(),
            'satuan' => fake()->randomElement(['kg', 'liter', 'pcs', 'lembar']),
            'stok_tersedia' => fake()->randomFloat(2, 0, 100),
            'stok_minimum' => fake()->randomFloat(2, 1, 10),
            'harga_per_satuan' => fake()->randomFloat(2, 1000, 50000),
            'keterangan' => null,
        ];
    }
}
