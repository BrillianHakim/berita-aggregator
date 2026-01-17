<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title', 'BeritaKu')</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('images/sources/Beritaku.webp') }}">

    <!-- Bootstrap CSS -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <!-- Custom Style -->
    <style>
        body {
            background-color: #ffffff;
        }

        /* =====================
           HEADLINE
        ===================== */
        .headline-card {
            background-size: cover;
            background-position: center;
            min-height: 420px;
            position: relative;
        }

        .headline-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(
                to bottom,
                rgba(0, 0, 0, 0.2),
                rgba(0, 0, 0, 0.8)
            );
        }

        /* =====================
           NAVBAR
        ===================== */
        .navbar {
            border-bottom: 1px solid #eaeaea;
        }

        .navbar-brand {
            color: #0d6efd !important;
            font-weight: 700;
            font-size: 1.4rem;
        }

        .nav-link {
            color: #555 !important;
            font-weight: 500;
        }

        .nav-link:hover,
        .nav-link.active {
            color: #0d6efd !important;
        }

        /* =====================
           SEARCH
        ===================== */
        .search-input {
            border-radius: 20px;
            padding-left: 15px;
        }

        .btn-search {
            border-radius: 20px;
        }

        /* =====================
           PAGINATION
        ===================== */
        .pagination .page-link {
            width: 42px;
            height: 42px;
            line-height: 42px;
            text-align: center;
            padding: 0;
            border-radius: 50%;
            margin: 0 4px;
            color: #0d6efd;
        }

        .pagination .page-item.active .page-link {
            background-color: #0d6efd;
            border-color: #0d6efd;
            color: #fff;
        }
    </style>
</head>

<body>

    <!-- =====================
         NAVBAR
    ====================== -->
    <nav class="navbar navbar-expand-lg bg-white fixed-top">
        <div class="container">

            <!-- Brand -->
            <a class="navbar-brand" href="/">
                BeritaKu
            </a>

            <!-- Toggler -->
            <button
                class="navbar-toggler"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#navbarMain"
            >
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarMain">

                <!-- Category Menu -->
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">

                    {{-- Terbaru --}}
                    <li class="nav-item">
                        <a
                            class="nav-link {{ request()->routeIs('latest') ? 'active' : '' }}"
                            href="{{ route('latest') }}"
                        >
                            Terbaru
                        </a>
                    </li>

                    {{-- Kategori --}}
                    @foreach ($categories->take(5) as $category)
                        <li class="nav-item">
                            <a
                                class="nav-link {{ request()->is('kategori/' . $category->slug) ? 'active' : '' }}"
                                href="{{ route('category.show', $category->slug) }}"
                            >
                                {{ $category->name }}
                            </a>
                        </li>
                    @endforeach

                </ul>

                <!-- Search -->
                <form class="d-flex" action="{{ route('search') }}" method="GET">
                    <input
                        type="search"
                        name="q"
                        class="form-control me-2 search-input"
                        placeholder="Cari berita..."
                        value="{{ request('q') }}"
                    >
                    <button type="submit" class="btn btn-primary btn-search">
                        Cari
                    </button>
                </form>

            </div>
        </div>
    </nav>

    <!-- =====================
         CONTENT
    ====================== -->
    <main class="container pt-5 mt-4">
        @yield('content')
    </main>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
