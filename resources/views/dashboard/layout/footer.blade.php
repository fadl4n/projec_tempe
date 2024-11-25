<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Footer Example</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        /* Styling Footer */
        .footer {
            background-color: #ffffff; /* Latar putih */
            color: #333; /* Warna teks lebih gelap */
            text-align: center;
            padding: 10px 0; /* Ukuran padding lebih kecil */
            font-family: 'Arial', sans-serif;
            font-size: 0.85em; /* Ukuran font kecil */
            border-top: 1px solid #000; /* Garis pembatas hitam */
        }

        .footer p {
            margin: 3px 0;
        }

        .footer i {
            color: #4CAF50; /* Warna ikon yang sesuai dengan tema sidebar */
            margin-right: 5px;
        }

        /* Responsif */
        @media (max-width: 600px) {
            .footer {
                font-size: 0.75em;
            }
        }
    </style>
</head>
<body>
    <!-- Konten halaman lainnya -->

    <footer class="footer">
        <div class="container">
            <p>&copy; Tempe Keluarga</p>
            <p>Jl. Kapalo Koto, Kec. Pauh, Kota Padang, Sumatra Barat, Indonesia</p>
            <p>
                <i class="fas fa-envelope"></i> Email: tempekeluarga@gmail.com |
                <i class="fas fa-phone"></i> Tel: +628 2285 2647 09
            </p>
        </div>
    </footer>
</body>
</html>
