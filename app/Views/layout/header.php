<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'ElectroMart') ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #f8f9fa, #e9f2ff);
            min-height: 100vh;
            font-family: Arial, sans-serif;
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
        }

        .hero-card,
        .custom-card,
        .form-card {
            background: #ffffff;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.08);
        }

        .hero-card {
            padding: 50px;
        }

        .custom-card {
            padding: 20px;
            height: 100%;
            transition: transform 0.2s ease;
        }

        .custom-card:hover {
            transform: translateY(-5px);
        }

        .form-card {
            padding: 35px;
        }

        .page-title {
            font-weight: 700;
            color: #0d6efd;
        }

        .product-image {
            width: 100%;
            height: 220px;
            object-fit: cover;
            border-radius: 14px;
        }

        .search-box {
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.06);
            padding: 20px;
        }

        footer {
            margin-top: 60px;
            padding: 20px 0;
            text-align: center;
            color: #666;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
    <div class="container">
        <a class="navbar-brand" href="<?= base_url('index.php/') ?>">ElectroMart</a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarContent">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('index.php/') ?>">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('index.php/products') ?>">Products</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('index.php/products/create') ?>">Add Product</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('index.php/logout') ?>">Logout</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="container py-5">