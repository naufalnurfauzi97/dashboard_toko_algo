<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>

<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="card">
                    <div class="card-header">
                        <h4 class="text-center">Detail Penjualan</h4>
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <th style="width: 150px;">No Invoice:</th>
                                    <td>{{ $headerPenjualan->no_invoice }}</td>
                                </tr>
                                <tr>
                                    <th>Tanggal Penjualan:</th>
                                    <td>{{ $headerPenjualan->tgl_penjualan }}</td>
                                </tr>
                                <tr>
                                    <th>Nama Konsumen:</th>
                                    <td>{{ $headerPenjualan->nama_konsumen }}</td>
                                </tr>
                                <tr>
                                    <th>Alamat:</th>
                                    <td>{{ $headerPenjualan->alamat }}</td>
                                </tr>
                                <tr>
                                    <th>Total Penjualan:</th>
                                    <td>{{ $headerPenjualan->total_penjualan }}</td>
                                </tr>
                            </tbody>
                        </table>

                        <hr>

                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Kode Barang</th>
                                    <th>Nama Barang</th>
                                    <th>Jumlah</th>
                                    <th>Harga Satuan</th>
                                    <th>Harga Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($detailPenjualan as $detail)
                                    <tr>
                                        <td>{{ $detail->kode_barang }}</td>
                                        <td>{{ $detail->nama_barang }}</td>
                                        <td>{{ $detail->jumlah }}</td>
                                        <td>{{ $detail->harga_satuan }}</td>
                                        <td>{{ $detail->harga_total }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer text-center">
                        <a href="#" class="btn btn-secondary" onclick="window.close();">Tutup</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
