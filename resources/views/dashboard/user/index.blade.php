@extends('dashboard.layouts.main')

@section('title', 'Data User')

@section('content')
<div class="container">
    <h1 class="mb-4">Daftar User</h1>

    <!-- Tabel User -->
    <table class="table table-bordered table-hover text-center align-middle">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Alamat</th>
                <th>Telepon</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($users as $index => $dataUser)
                <tr>
                    <td>{{ $users->firstItem() + $index }}</td> <!-- Nomor Urut -->
                    <td>{{ $dataUser->name }}</td> <!-- Nama -->
                    <td>{{ $dataUser->email }}</td> <!-- Email -->
                    <td>{{ $dataUser->alamat ?? '-' }}</td> <!-- Alamat -->
                    <td>{{ $dataUser->no_telp ?? '-' }}</td> <!-- No. Telepon -->
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center text-muted">Belum ada data user.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Pagination -->
    <div class="d-flex justify-content-center mt-3">
        {{ $users->links() }}
    </div>
</div>
@endsection
