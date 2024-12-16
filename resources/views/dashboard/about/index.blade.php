<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tempe Keluarga</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-image: url('/images/background.png');
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
        }
        nav {
            background-color: rgba(255, 255, 255, 0.9);
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            padding: 10px 20px;
        }
        nav .navbar-brand img {
            width: 50px;
        }
        .container {
            display: grid;
            grid-template-columns: 1fr 1fr;
            align-items: center;
            padding: 70px 100px;
        }
        .text-content {
            max-width: 600px;
        }
        .text-content h1 {
            font-size: 3.5rem; /* Ukuran lebih besar */
            color: #2a2a2a;
            margin-bottom: 10px;
        }
        .text-content h2 {
            font-size: 2.5rem; /* Ukuran lebih besar */
            color: #d9534f;
            margin-bottom: 20px;
        }
        .text-content p {
            font-size: 1.4rem; /* Ukuran lebih besar */
            color: #555;
            line-height: 1.8;
        }
        .text-content .btn {
            background-color: #d9534f;
            color: white;
            padding: 15px 30px; /* Tombol lebih besar */
            border: none;
            border-radius: 5px;
            text-decoration: none;
            font-size: 1.2rem;
        }
        .text-content .btn:hover {
            background-color: #c9302c;
        }
        .image-container {
            text-align: center;
        }
        .image-container img {
            width: 450px; /* Gambar lebih besar */
            height: 450px; /* Gambar lebih besar */
            border-radius: 50%; /* Membuat gambar bulat */
            border: 5px solid #e6e6e6;
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
                <form action="/logout" method="post" class="d-inline">
                    @csrf
                    <button type="submit" class="nav-link bg-transparent border-0 p-3">Logout</button>
                </form>
            </div>
        </div>
    </nav>

    <!-- Konten -->
    <div class="container">
        <!-- Bagian Teks -->
        <div class="text-content">
            <h1>Makanan Lezat Indonesia</h1>
            <h2>Rasa Makanan Terbaik</h2>
            <p>
                Tempe Keluarga dibuat dari bahan berkualitas premium, tanpa bahan pengawet,
                dan diproses secara higienis untuk menjaga kesegarannya.
            </p>
            <a href="{{ route('dashboard-dash-user.index') }}" class="btn">Shop Now</a>

        </div>
        <!-- Bagian Gambar -->
        <div class="image-container">
            <img src="/images/tempe.jpg" alt="Tempe">
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
