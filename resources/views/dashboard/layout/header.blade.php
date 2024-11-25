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
            background-color: white;
        }
        .navbar-custom {
            background-color: #4CAF50;
            padding: 0.5rem 0; /* reduce padding */
            font-size: 1rem; /* reduced font size */
            color: black;
        }
        .navbar-custom .navbar-brand {
            font-weight: bold;
            display: flex;
            justify-content: center;
            align-items: center;
            padding-bottom: 5px; /* reduce space below the logo */
        }
        .navbar-custom .navbar-nav {
            display: flex;
            justify-content: center;
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
            width: 40px; /* reduced logo size */
            height: 40px; /* reduced logo size */
            margin-right: 10px;
        }
    </style>
</head>
<body>

    <header class="navbar navbar-expand-lg sticky-top navbar-custom shadow">

        <!-- Logo and Menu on the left -->
        <div class="navbar-nav">
            <form action="{{ route('dashboard-dash-user.index') }}" method="get" class="d-inline">
                <button type="submit" class="nav-link bg-transparent border-0 p-3">Home</button>
            </form>


            <form action="/about" method="get" class="d-inline">
                <button type="submit" class="nav-link bg-transparent border-0 p-3">About</button>
            </form>
            <a href="{{ route('dashboard-keranjang.index') }}" class="nav-link p-3">
                <i class="bi bi-cart"></i>
            </a>
            <form action="/logout" method="post" class="d-inline">
                @csrf
                <button type="submit" class="nav-link bg-transparent border-0 p-3">Logout</button>
            </form>
        </div>



    </header>



</body>
</html>
