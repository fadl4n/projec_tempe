<!doctype html>
<html lang="en" data-bs-theme="auto">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <style>
        .navbar-custom {
            background-color: white;
            padding: 0.5rem 1rem;
            font-size: 1rem;
            color: black;
        }

        .navbar-custom .navbar-nav {
            display: flex;
            justify-content: space-between;
            width: 100%;
            padding: 0.5rem 0;
        }

        .navbar-custom .nav-item {
            margin: 0 15px;
        }

        .navbar-custom .nav-link {
            color: black !important;
        }

        .navbar-custom .nav-link:hover {
            background-color: rgba(0, 0, 0, 0.1);
        }

        .navbar-custom .logo {
            width: 40px;
            height: 40px;
            margin-right: 10px;
        }

        @media (max-width: 992px) {
            .navbar-custom .navbar-nav {
                flex-direction: column;
                align-items: flex-start;
            }
        }
    </style>
</head>


<body>

    <!-- Header -->
    @include('dashboard.layout.header')

    <!-- Main Container -->
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3">
                @include('dashboard.layout.sidebar')
            </div>
            <!-- Konten Utama -->
            <div class="col-md-0">
                <main class="py-4">
                    @yield('content')
                </main>
            </div>
        </div>
    </div>


    <!-- Footer -->
    @include('dashboard.layout.footer')

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
