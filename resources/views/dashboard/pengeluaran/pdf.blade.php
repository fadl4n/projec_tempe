<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Pengeluaran</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            font-size: 12px;
            margin: 20px;
            color: #333;
        }

        h2 {
            text-align: center;
            font-size: 20px;
            margin-bottom: 10px;
        }

        p {
            text-align: center;
            font-size: 14px;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 12px;
            text-align: left;
            font-size: 12px;
        }

        th {
            background-color: #f4f4f4;
        }

        .text-right {
            text-align: right;
        }

        .total {
            font-weight: bold;
            background-color: #f9f9f9;
        }

        .total td {
            border-top: 2px solid #ddd;
        }

        .currency {
            text-align: right;
        }

        .currency span {
            font-weight: bold;
        }
    </style>
</head>
<body>

    <h2>Laporan Pengeluaran</h2>
    <p>Tanggal Laporan: {{ date('d-m-Y') }}</p>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Barang</th>
                <th>Jumlah</th>
                <th>Satuan</th>
                <th>Total Harga</th>
                <th>Kategori</th>
                <th>Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pengeluaran as $index => $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->nama_barang }}</td>
                    <td class="text-right">{{ $item->jumlah }}</td>
                    <td>{{ $item->satuan }}</td>
                    <td class="currency">Rp <span>{{ number_format($item->ttl_harga, 0, ',', '.') }}</span></td>
                    <td>{{ $item->kategori }}</td>
                    <td>{{ date('d-m-Y', strtotime($item->tanggal)) }}</td>
                </tr>
            @endforeach
            <tr class="total">
                <td colspan="4" class="text-right">Total</td>
                <td colspan="3" class="currency">Rp <span>{{ number_format($totalPengeluaran, 0, ',', '.') }}</span></td>
            </tr>
        </tbody>
    </table>

</body>
</html>
