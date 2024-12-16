<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Keuangan</title>
    <style>
        body { font-family: Arial, sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: center; }
        th { background-color: #f4f4f4; }
    </style>
</head>
<body>
    <h2 style="text-align: center;">Laporan Keuangan Tahun {{ $tahun }}</h2>
    <table>
        <thead>
            <tr>
                <th>Bulan</th>
                <th>Pemasukan</th>
                <th>Pengeluaran</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($keuangan as $data)
                <tr>
                    <td>{{ $data['bulan'] }}</td>
                    <td>Rp {{ number_format($data['pemasukan'], 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($data['pengeluaran'], 0, ',', '.') }}</td>
                    <td>{!! $data['keterangan'] !!}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
