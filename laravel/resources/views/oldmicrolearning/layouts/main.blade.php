<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Microlearning')</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            color: #333;
        }
        header {
            background-color: #396db2;
            color: white;
            padding: 15px 0;
        }
        header nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 15px;
        }
        header a {
            color: white;
            text-decoration: none;
            font-weight: bold;
        }
        header a:hover {
            text-decoration: underline;
        }
        .main-container {
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        }
        footer {
            background-color: #396db2;
            color: white;
            text-align: center;
            padding: 15px 0;
            margin-top: 20px;
        }
        footer p {
            margin: 0;
        }
        .btn-primary {
            background-color: #396db2;
            border-color: #396db2;
        }
        .btn-primary:hover {
            background-color: #2f5a96;
            border-color: #2f5a96;
        }
    </style>
</head>
<body>
    <header>
        <nav>
            <div>
                <a href="{{ route('microlearning.index') }}" class="navbar-brand">Microlearning</a>
            </div>
            <form class="d-flex" role="search">
                <input class="form-control me-2" type="search" placeholder="Search lessons" aria-label="Search">
                <button class="btn btn-light" type="submit">Search</button>
            </form>
        </nav>
    </header>

    <main class="main-container">
        @yield('content')
    </main>

    <footer>
        <p>© 2024 Microlearning. All rights reserved.</p>
    </footer>
</body>
</html>
