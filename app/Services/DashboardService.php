<?php

namespace App\Services;

use App\Models\DetailPenjualan;
use App\Models\MasterBarang;
use App\Models\Penjualan;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardService
{
    public function getPenjualanTerakhir()
    {
        return DB::table('penjualan')
            ->leftJoin('detail_penjualan', 'penjualan.no_invoice', '=', 'detail_penjualan.no_invoice')
            ->select(
                'penjualan.no_invoice',
                'penjualan.nama_konsumen',
                'penjualan.alamat',
                'penjualan.tgl_penjualan',
                DB::raw('SUM(detail_penjualan.harga_total) as total_penjualan')
            )
            ->groupBy('penjualan.no_invoice', 'penjualan.nama_konsumen', 'penjualan.alamat', 'penjualan.tgl_penjualan')
            ->orderBy('penjualan.tgl_penjualan', 'desc')
            ->take(10)
            ->get();
    }

    public function getKategoriData()
    {
        return MasterBarang::select('kategori', DB::raw('COUNT(*) as total'))->groupBy('kategori')->get();
    }

    public function getPenjualanPerHari()
    {
        $now = Carbon::now();
        return DetailPenjualan::join('penjualan', 'detail_penjualan.no_invoice', '=', 'penjualan.no_invoice')
            ->whereMonth('penjualan.tgl_penjualan', $now->month)
            ->select(DB::raw('DATE_FORMAT(penjualan.tgl_penjualan, "%d") as tanggal'), DB::raw('SUM(detail_penjualan.jumlah) as total'))
            ->groupBy('tanggal')
            ->get();
    }

    public function getKategoriDataWithPercentage()
    {
        $now = Carbon::now();

        $kategoriData = MasterBarang::join('detail_penjualan', 'master_barang.kode_barang', '=', 'detail_penjualan.kode_barang')
            ->join('penjualan', 'detail_penjualan.no_invoice', '=', 'penjualan.no_invoice')
            ->whereMonth('penjualan.tgl_penjualan', $now->month)
            ->select('master_barang.kategori', DB::raw('COUNT(*) as total'))
            ->groupBy('master_barang.kategori')
            ->get();

        $totalBarangTerjual = $kategoriData->sum('total');

        foreach ($kategoriData as $kategori) {
            $kategori->presentase = ($kategori->total / $totalBarangTerjual) * 100;
        }

        return $kategoriData;
    }

    public function getHeaderPenjualan($no_invoice)
    {
        return DB::table('penjualan')
            ->leftJoin('detail_penjualan', 'penjualan.no_invoice', '=', 'detail_penjualan.no_invoice')
            ->select(
                'penjualan.no_invoice',
                'penjualan.nama_konsumen',
                'penjualan.alamat',
                'penjualan.tgl_penjualan',
                DB::raw('SUM(detail_penjualan.harga_total) as total_penjualan')
            )
            ->where('penjualan.no_invoice', '=', $no_invoice)
            ->groupBy('penjualan.no_invoice', 'penjualan.nama_konsumen', 'penjualan.alamat', 'penjualan.tgl_penjualan')
            ->first();
    }

    public function getDetailPenjualan($no_invoice)
    {
        return DB::table('detail_penjualan')
            ->leftJoin('master_barang', 'detail_penjualan.kode_barang', '=', 'master_barang.kode_barang')
            ->select(
                'detail_penjualan.kode_barang',
                'master_barang.nama_barang',
                'detail_penjualan.jumlah',
                'detail_penjualan.harga_satuan',
                'detail_penjualan.harga_total'
            )
            ->where('detail_penjualan.no_invoice', '=', $no_invoice)
            ->get();
    }
}
