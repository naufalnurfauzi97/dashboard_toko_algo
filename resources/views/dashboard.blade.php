@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Grafik Penjualan Barang per Hari</div>
                <div class="card-body">
                    <canvas id="penjualanChart" width="400" height="400"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Persentase Kategori Barang</div>
                <div class="card-body">
                    <canvas id="kategoriChart" width="400" height="400"></canvas>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">10 Penjualan Terakhir</div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Nama Customer</th>
                                <th>Alamat</th>
                                <th>Tanggal Penjualan</th>
                                <th>Total Penjualan</th>
                                <th>Detail</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($penjualanTerakhir as $key => $penjualan)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $penjualan->nama_konsumen }}</td>
                                <td>{{ $penjualan->alamat }}</td>
                                <td>{{ $penjualan->tgl_penjualan }}</td>
                                <td style="float: right;">{{ number_format($penjualan->total_penjualan, 2, ',', '.') }}</td>
                                <td>
                                    <a href="{{ route('detail-penjualan', ['no_invoice' => $penjualan->no_invoice]) }}" target="_blank">
                                        Detail
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Data untuk grafik penjualan per hari (contoh)

    var penjualanData = {
        labels: {!! json_encode($penjualanPerHari->pluck('tanggal')) !!},
        datasets: [{
            label: 'Barang Terjual per Hari',
            data: {!! json_encode($penjualanPerHari->pluck('total')) !!},
            backgroundColor: 'rgba(75, 192, 192, 0.2)',
            borderColor: 'rgba(75, 192, 192, 1)',
            borderWidth: 1
        }]
    };

    var backgroundColors = [];
    for (var i = 0; i < penjualanData.datasets[0].data.length; i++) {
        var randomColor = '#' + Math.floor(Math.random() * 16777215).toString(16);
        backgroundColors.push(randomColor);
    }
    var chartOptions = {
        tooltips: {
            callbacks: {
                label: function(tooltipItem, data) {
                    var dataset = data.datasets[tooltipItem.datasetIndex];
                    var total = dataset.data.reduce(function(previousValue, currentValue) {
                        return previousValue + currentValue;
                    });
                    var currentValue = dataset.data[tooltipItem.index];
                    var percentage = ((currentValue / total) * 100).toFixed(2);
                    return currentValue + ' (' + percentage + '%)';
                }
            }
        },
        responsive: false,
        layout: {
            padding: {
                left: 0,
                right: 0,
                top: 0,
                bottom: 0
            }
        },
    };

    var kategoriData = {
        labels: {!! json_encode($kategoriData->pluck('kategori')) !!},
        datasets: [{
            data: {!! json_encode($kategoriData->pluck('total')) !!},
            backgroundColor: backgroundColors,
            borderColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)'
            ],
            borderWidth: 1
        }]
    };

    var ctxPenjualan = document.getElementById('penjualanChart').getContext('2d');
    new Chart(ctxPenjualan, {
        type: 'bar',
        data: penjualanData,
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            },
            responsive: false,
            layout: {
                padding: {
                    left: 0,
                    right: 0,
                    top: 0,
                    bottom: 0
                }
            },
        }
    });

    var ctxKategori = document.getElementById('kategoriChart').getContext('2d');
    new Chart(ctxKategori, {
        type: 'pie',
        data: kategoriData,
        options: chartOptions
    });
</script>
@endsection