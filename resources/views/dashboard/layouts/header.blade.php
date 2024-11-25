<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .navbar-brand {
            font-weight: bold;
        }
        .navbar-custom {
            background-color: white;
            padding: 1rem 2rem;
            font-size: 1.25rem;
            color: black; /* Ubah warna teks menjadi putih */
        }
        .navbar-custom .nav-link,
        .navbar-custom span {
            color: black !important; /* Pastikan warna teks putih pada elemen tertentu */
        }
        #notificationMenu {
            min-width: 300px;
        }
    </style>
</head>
<body>

    <header class="navbar sticky-top navbar-custom p-2 shadow d-flex align-items-center">
        <!-- Logo -->
        <div >
            <img src="{{ asset('images/Logo.png') }}" alt="Logo Tempe Keluarga" style="width: 50px; height: 50px; margin-right: 10px;">
            <span >Tempe Keluarga</span>
        </div>

        <div class="ms-auto d-flex align-items-center">
            <!-- Profile image -->
            <img src="{{ asset('images/orang.png') }}"
                 alt="Profile"
                 class="rounded-circle me-2"
                 style="width: 40px; height: 40px;">
            <!-- User name -->
            <span class="d-none d-lg-inline-block">{{ Auth::user()->name }}</span>
        </div>

    </header>


</body>
</html>
