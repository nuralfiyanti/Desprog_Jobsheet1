<?php
if (session_status() === PHP_SESSION_NONE) session_start();
include "fungsi/pesan_kilat.php";
?>
<!DOCTYPE html>
<html lang="en" data-bs-theme="auto">

<head>
    <script src="assets/js/color-modes.js"></script>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.118.2">
    <title>Aplikasi Kantor alfi</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/5.3/examples/sign-in/">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@docsearch/css@3">
    <link rel="icon" href="assets/img/favicons/favicon.ico">
    <link href="assets/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
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

        .bi {
            vertical-align: -.125em;
            fill: currentColor;
        }

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

        .bd-mode-toggle {
            z-index: 1500;
        }

        .bd-mode-toggle .dropdown-menu .active .bi {
            display: block !important;
        }
    </style>

    <link href="assets/custom/sign-in.css" rel="stylesheet">
</head>

<body class="d-flex align-items-center py-4 bg-body-tertiary">

    <!-- ICON DEFINITIONS -->
    <svg xmlns="http://www.w3.org/2000/svg" class="d-none">
        <symbol id="check2" viewBox="0 0 16 16">
            <path d="M13.854 3.646a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L6.5 10.293l6.646-6.647a.5.5 0 0 1 .708 0z" />
        </symbol>

        <symbol id="circle-half" viewBox="0 0 16 16">
            <path d="M8 15A7 7 0 1 0 8 1v14zm0 1A8 8 0 1 1 8 0a8 8 0 0 1 0 16z" />
        </symbol>

        <symbol id="moon-stars-fill" viewBox="0 0 16 16">
            <path d="M6 .278a.768.768 0 0 1 .08.858..."></path>
        </symbol>

        <symbol id="sun-fill" viewBox="0 0 16 16">
            <path d="M8 12a4 4 0 1 0 0-8..."></path>
        </symbol>
    </svg>

    <!-- THEME DROPDOWN -->
    <div class="dropdown position-fixed bottom-0 end-0 mb-3 me-3 bd-mode-toggle">
        <button class="btn btn-bd-primary py-2 dropdown-toggle d-flex align-items-center" id="bd-theme"
            type="button" data-bs-toggle="dropdown" aria-expanded="false" aria-label="Toggle theme (auto)">
            <svg class="bi my-1 theme-icon-active" width="1em" height="1em">
                <use href="#circle-half"></use>
            </svg>
            <span class="visually-hidden" id="bd-theme-text">Toggle theme</span>
        </button>

        <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="bd-theme-text">
            <li>
                <button class="dropdown-item d-flex align-items-center" data-bs-theme-value="light">
                    <svg class="bi me-2 opacity-50 theme-icon"><use href="#sun-fill"></use></svg>
                    Light
                    <svg class="bi ms-auto d-none"><use href="#check2"></use></svg>
                </button>
            </li>

            <li>
                <button class="dropdown-item d-flex align-items-center" data-bs-theme-value="dark">
                    <svg class="bi me-2 opacity-50 theme-icon"><use href="#moon-stars-fill"></use></svg>
                    Dark
                    <svg class="bi ms-auto d-none"><use href="#check2"></use></svg>
                </button>
            </li>

            <li>
                <button class="dropdown-item d-flex align-items-center active" data-bs-theme-value="auto">
                    <svg class="bi me-2 opacity-50 theme-icon"><use href="#circle-half"></use></svg>
                    Auto
                    <svg class="bi ms-auto d-none"><use href="#check2"></use></svg>
                </button>
            </li>
        </ul>
    </div>

    <!-- FORM LOGIN -->
    <main class="form-signin w-100 m-auto">
        <form action="cek_login.php" method="post">

            <img class="mb-4" src="assets/brand/bootstrap-logo.svg" alt="" width="72" height="57">

            <h1 class="h3 mb-3 fw-normal">Lakukan Login</h1>

            <!-- Flash Message -->
            <?php
            if (isset($_SESSION['_flashdata'])) {
                foreach ($_SESSION['_flashdata'] as $key => $val) {
                    echo get_flashdata($key);
                }
            }
            ?>

            <div class="form-floating mb-2">
                <input type="text" class="form-control" name="username" placeholder="Username" required>
                <label>Username</label>
            </div>

            <div class="form-floating mb-3">
                <input type="password" class="form-control" name="password" placeholder="Password" required>
                <label>Password</label>
            </div>

            <button class="btn btn-primary w-100 py-2" type="submit">Masuk</button>

            <p class="mt-5 mb-3 text-body-secondary">&copy; 2017–2023</p>

        </form>
    </main>

    <script src="assets/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
