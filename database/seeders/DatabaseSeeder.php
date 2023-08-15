<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MasterBarang;
use App\Models\Penjualan;
use App\Models\DetailPenjualan;
use Faker\Factory as Faker;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        foreach (range(1, 50) as $index) {
            $masterBarang = MasterBarang::create([
                'kode_barang' => $faker->unique()->ean8,
                'nama_barang' => $faker->word,
                'harga_jual' => $faker->randomFloat(2, 10000, 1000000),
                'harga_beli' => $faker->randomFloat(2, 5000, 500000),
                'stok' => $faker->numberBetween(1, 50),
                'kategori' => $faker->randomElement(['Elektronik', 'Rumah Tangga', 'Makanan', 'Minuman', 'Lainnya'])
            ]);

            $penjualan = Penjualan::create([
                'no_invoice'    => $faker->unique()->numerify('INV####'),
                'tgl_penjualan' => $faker->dateTimeBetween('-1 month', 'now'),
                'nama_konsumen' => $faker->name,
                'alamat'        => $faker->address
            ]);

            $jumlahBarang = $faker->numberBetween(1, 5);
            for ($i = 0; $i < $jumlahBarang; $i++) {
                $detailHargaSatuan = $masterBarang->harga_jual;
                $detailJumlah = $faker->numberBetween(1, 10);
                $detailHargaTotal = $detailHargaSatuan * $detailJumlah;

                DetailPenjualan::create([
                    'no_invoice' => $penjualan->no_invoice,
                    'kode_barang' => $masterBarang->kode_barang,
                    'jumlah' => $detailJumlah,
                    'harga_satuan' => $detailHargaSatuan,
                    'harga_total' => $detailHargaTotal
                ]);
            }
        }
    }
}
