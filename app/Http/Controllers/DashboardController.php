<?php

namespace App\Http\Controllers;

use App\Models\DetailPenjualan;
use App\Models\MasterBarang;
use App\Models\Penjualan;
use App\Services\DashboardService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    protected $dashboardService;

    public function __construct(DashboardService $dashboardService)
    {
        $this->dashboardService = $dashboardService;
    }

    public function index()
    {
        $penjualanTerakhir = $this->dashboardService->getPenjualanTerakhir();
        $kategoriData = $this->dashboardService->getKategoriData();
        $penjualanPerHari = $this->dashboardService->getPenjualanPerHari();
        $kategoriDataWithPercentage = $this->dashboardService->getKategoriDataWithPercentage();

        return view('dashboard', compact('penjualanTerakhir', 'kategoriData', 'penjualanPerHari', 'kategoriDataWithPercentage'));
    }

    public function penjualan($no_invoice)
    {
        $headerPenjualan = $this->dashboardService->getHeaderPenjualan($no_invoice);
        $detailPenjualan = $this->dashboardService->getDetailPenjualan($no_invoice);
        return view('detailpenjualan', compact('headerPenjualan', 'detailPenjualan'));
    }
}
