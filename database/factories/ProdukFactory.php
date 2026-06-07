<?php

namespace Database\Factories;

use App\Models\Produk;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProdukFactory extends Factory
{
    protected $model = Produk::class;

    public function definition(): array
    {
        return [
            'nama_produk' => fake()->word(),
            'stok_tersedia' => fake()->numberBetween(0, 500),
            'stok_minimum' => fake()->numberBetween(5, 50),
            'harga_produk' => fake()->randomFloat(2, 1000, 100000),
            'keterangan' => null,
        ];
    }
}
