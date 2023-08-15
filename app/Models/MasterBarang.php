<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterBarang extends Model
{
    protected $table = 'master_barang';
    protected $fillable = ['kode_barang', 'nama_barang', 'harga_jual', 'harga_beli', 'stok', 'kategori'];
}
