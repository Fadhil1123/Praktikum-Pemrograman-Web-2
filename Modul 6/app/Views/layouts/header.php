<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portfolio Praktikan</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css'); ?>">
</head>

<body>
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top">
    <div class="container">

        <a class="navbar-brand fw-bold" href="<?= base_url('/'); ?>">
            My Portfolio
        </a>

        <button class="navbar-toggler"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#navbarNav">

            <span class="navbar-toggler-icon"></span>

        </button>

        <div class="collapse navbar-collapse" id="navbarNav">

            <ul class="navbar-nav ms-auto">

                <li class="nav-item">
                    <a class="nav-link <?= current_url() == base_url('/') ? 'active-menu' : ''; ?>"
                    href="<?= base_url('/'); ?>">
                        Beranda
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link <?= current_url() == base_url('profile') ? 'active-menu' : ''; ?>"
                    href="<?= base_url('profile'); ?>">
                        Profil
                    </a>
                </li>

            </ul>

        </div>

    </div>
</nav>