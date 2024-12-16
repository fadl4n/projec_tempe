<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tempe Keluarga</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa; /* Warna latar umum */
        }
        nav {
            background-color: white; /* Sidebar putih polos */
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            padding: 10px 20px;
        }
        nav .navbar-brand img {
            width: 50px;
        }
        .navbar-nav .nav-item {
            margin: 0 10px;
        }
        .navbar-nav .nav-link {
            color: black !important;
            font-weight: bold;
        }
        .navbar-nav .nav-link:hover {
            background-color: rgba(0, 0, 0, 0.05);
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <a class="navbar-brand" href="/">
                <img src="/images/Logo.png" alt="Logo">
                Tempe Keluarga
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="navbar-nav">
                <form action="{{ route('dashboard-dash-user.index') }}" method="get" class="d-inline">
                    <button type="submit" class="nav-link bg-transparent border-0 p-3">Home</button>
                </form>
                <form action="{{ route('dashboard-about.index') }}" method="get" class="d-inline">
                    <button type="submit" class="nav-link bg-transparent border-0 p-3">About</button>
                </form>
                <a href="{{ route('dashboard-keranjang.index') }}" class="nav-link p-3">
                    Keranjang
                </a>
                <a href="{{ route('riwayat.pesanan') }}" class="nav-link p-3">
                    Riwayat
                </a>
               
                <form action="/logout" method="post" class="d-inline">
                    @csrf
                    <button type="submit" class="nav-link bg-transparent border-0 p-3">Logout</button>
                </form>


            </div>
        </div>
    </nav>
</body>
</html>
