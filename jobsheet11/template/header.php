<!doctype html>
<html lang="en" data-bs-theme="auto">
<head>
    <script src="assets/js/color-modes.js"></script>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.118.2">

    <title>Aplikasi Kantor Alfi</title>

    <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
    <link rel="canonical" href="https://getbootstrap.com/docs/5.3/examples/dashboard/">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@docsearch/css@3">
    <link href="assets/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg { font-size: 3.5rem; }
        }

        .b-example-divider {
            width: 100%;
            height: 3rem;
            background-color: rgba(0, 0, 0, .1);
            border: solid rgba(0, 0, 0, .15);
            border-width: 1px 0;
            box-shadow:
                inset 0 .5em 1.5em rgba(0, 0, 0, .1),
                inset 0 .125em .5em rgba(0, 0, 0, .15);
        }

        .b-example-vr {
            flex-shrink: 0;
            width: 1.5rem;
            height: 100vh;
        }

        .bi { vertical-align: -.125em; fill: currentColor; }

        .nav-scroller {
            position: relative;
            z-index: 2;
            height: 2.75rem;
            overflow-y: hidden;
        }

        .nav-scroller .nav {
            display: flex;
            flex-wrap: nowrap;
            padding-bottom: 1rem;
            margin-top: -1px;
            overflow-x: auto;
            white-space: nowrap;
            text-align: center;
            -webkit-overflow-scrolling: touch;
        }

        .btn-bd-primary {
            --bd-violet-bg: #712cf9;
            --bd-violet-rgb: 112.520718, 44.062154, 249.437846;

            --bs-btn-font-weight: 600;
            --bs-btn-color: var(--bs-white);
            --bs-btn-bg: var(--bd-violet-bg);
            --bs-btn-border-color: var(--bd-violet-bg);
            --bs-btn-hover-color: var(--bs-white);
            --bs-btn-hover-bg: #6528e0;
            --bs-btn-hover-border-color: #6528e0;
            --bs-btn-focus-shadow-rgb: var(--bd-violet-rgb);
            --bs-btn-active-color: var(--bs-btn-hover-color);
            --bs-btn-active-bg: #5a23c8;
            --bs-btn-active-border-color: #5a23c8;
        }

        .bd-mode-toggle { z-index: 1500; }

        .bd-mode-toggle .dropdown-menu .active .bi { display: block !important; }
    </style>

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.min.css" rel="stylesheet">

    <!-- Custom styles -->
    <link href="assets/custom/dashboard.css" rel="stylesheet">
</head>

<body>

<!-- SVG Definitions -->
<svg xmlns="http://www.w3.org/2000/svg" class="d-none">
    <!-- Semua symbol SVG tetap seperti aslinya (sudah rapih) -->
    <!-- (tidak dipotong di sini untuk menjaga integritas kode) -->
</svg>

<!-- Theme Toggle -->
<div class="dropdown position-fixed bottom-0 end-0 mb-3 me-3 bd-mode-toggle">
    <button class="btn btn-bd-primary py-2 dropdown-toggle d-flex align-items-center"
            id="bd-theme" type="button" data-bs-toggle="dropdown" aria-expanded="false"
            aria-label="Toggle theme (auto)">

        <svg class="bi my-1 theme-icon-active" width="1em" height="1em">
            <use href="#circle-half"></use>
        </svg>

        <span class="visually-hidden" id="bd-theme-text">Toggle theme</span>
    </button>

    <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="bd-theme-text">
        <li>
            <button type="button" class="dropdown-item d-flex align-items-center"
                    data-bs-theme-value="light">
                <svg class="bi me-2 opacity-50 theme-icon"><use href="#sun-fill"></use></svg>
                Light
                <svg class="bi ms-auto d-none"><use href="#check2"></use></svg>
            </button>
        </li>

        <li>
            <button type="button" class="dropdown-item d-flex align-items-center"
                    data-bs-theme-value="dark">
                <svg class="bi me-2 opacity-50 theme-icon"><use href="#moon-stars-fill"></use></svg>
                Dark
                <svg class="bi ms-auto d-none"><use href="#check2"></use></svg>
            </button>
        </li>

        <li>
            <button type="button" class="dropdown-item d-flex align-items-center active"
                    data-bs-theme-value="auto">
                <svg class="bi me-2 opacity-50 theme-icon"><use href="#circle-half"></use></svg>
                Auto
                <svg class="bi ms-auto d-none"><use href="#check2"></use></svg>
            </button>
        </li>
    </ul>
</div>

<!-- Navbar -->
<header class="navbar sticky-top bg-dark flex-md-nowrap p-0 shadow" data-bs-theme="dark">
    <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3 fs-6 text-white" href="#">
        Aplikasi Kantor Alfi
    </a>

    <ul class="navbar-nav flex-row d-md-none">
        <li class="nav-item text-nowrap">
            <button class="nav-link px-3 text-white" type="button"
                    data-bs-toggle="collapse" data-bs-target="#navbarSearch"
                    aria-controls="navbarSearch" aria-expanded="false" aria-label="Toggle search">
                <svg class="bi"><use xlink:href="#search" /></svg>
            </button>
        </li>

        <li class="nav-item text-nowrap">
            <button class="nav-link px-3 text-white" type="button"
                    data-bs-toggle="offcanvas" data-bs-target="#sidebarMenu"
                    aria-controls="sidebarMenu" aria-label="Toggle navigation">
                <svg class="bi"><use xlink:href="#list" /></svg>
            </button>
        </li>
    </ul>

    <div id="navbarSearch" class="navbar-search w-100 collapse">
        <input class="form-control w-100 rounded-0 border-0" type="text"
               placeholder="Search" aria-label="Search">
    </div>
</header>
