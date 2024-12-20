@extends('dashboard.layouts.main')

@section('title', 'Data Keuangan')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3">Laporan Keuangan Tahun {{ $tahun }}</h1>
        <a href="{{ route('dashboard-keuangan.pdf', ['tahun' => $tahun]) }}" class="btn btn-danger">
            <i class="bi bi-file-earmark-pdf"></i> Unduh PDF
        </a>
    </div>

    <form action="{{ route('dashboard-keuangan.index') }}" method="GET" class="row mb-4 align-items-end">
        <div class="col-md-4">
            <label for="tahun" class="form-label">Pilih Tahun:</label>
            <select name="tahun" id="tahun" class="form-select">
                @foreach (range(date('Y'), date('Y') - 10) as $t)
                    <option value="{{ $t }}" {{ $tahun == $t ? 'selected' : '' }}>
                        {{ $t }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-primary w-100">Filter</button>
        </div>
    </form>

    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>Bulan</th>
                <th>Pemasukan</th>
                <th>Pengeluaran</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($dataBulan as $data)
                <tr class="text-center">
                    <td>{{ $data['bulan'] }}</td>
                    <td>Rp {{ number_format($data['pemasukan'], 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($data['pengeluaran'], 0, ',', '.') }}</td>
                    <td class="{{ str_contains($data['keterangan'], 'Rugi') ? 'text-danger' : 'text-success' }}">
                        {{ $data['keterangan'] }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Pesan jika tidak ada data -->
    @if ($dataBulan->isEmpty())
        <p class="text-center mt-4">Tidak ada data keuangan untuk tahun {{ $tahun }}.</p>
    @endif
@endsection
    