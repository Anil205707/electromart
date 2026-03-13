<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ElectroMart Home</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(135deg, #f8f9fa, #e9f2ff);
            min-height: 100vh;
            font-family: Arial, sans-serif;
        }

        .hero-section {
            padding: 80px 0;
        }

        .hero-card {
            background: #ffffff;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.08);
            padding: 50px;
        }

        .hero-title {
            font-size: 3rem;
            font-weight: 700;
            color: #0d6efd;
        }

        .hero-text {
            font-size: 1.1rem;
            color: #555;
        }

        .feature-card {
            border: none;
            border-radius: 18px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.06);
            transition: transform 0.2s ease;
            height: 100%;
        }

        .feature-card:hover {
            transform: translateY(-5px);
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
        }

        .btn-custom {
            padding: 12px 22px;
            border-radius: 10px;
            font-weight: 600;
        }

        .welcome-badge {
            background: #e7f1ff;
            color: #0d6efd;
            padding: 10px 16px;
            border-radius: 30px;
            display: inline-block;
            font-weight: 600;
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

<section class="hero-section">
    <div class="container">
        <div class="hero-card">
            <div class="row align-items-center">
                <div class="col-lg-7">
                    <span class="welcome-badge mb-3">
                        Welcome back, <?= esc(session()->get('user_name')) ?>!
                    </span>

                    <h1 class="hero-title mt-3">Buy and Sell Electronics with Confidence</h1>

                    <p class="hero-text mt-3">
                        ElectroMart is your local marketplace for laptops, phones, accessories, and more.
                        Browse products, add your own items, and manage your marketplace experience in one place.
                    </p>

                    <div class="mt-4 d-flex flex-wrap gap-3">
                        <a href="<?= base_url('index.php/products') ?>" class="btn btn-primary btn-custom">
                            View Products
                        </a>
                        <a href="<?= base_url('index.php/products/create') ?>" class="btn btn-outline-primary btn-custom">
                            Add Product
                        </a>
                    </div>
                </div>

                <div class="col-lg-5 text-center mt-4 mt-lg-0">
                    <img src="https://cdn-icons-png.flaticon.com/512/1041/1041886.png" alt="Electronics" class="img-fluid" style="max-width: 320px;">
                </div>
            </div>
        </div>
    </div>
</section>

<section class="pb-5">
    <div class="container">
        <div class="row g-4">

            <div class="col-md-4">
                <div class="card feature-card p-4">
                    <div class="card-body">
                        <h4 class="card-title text-primary">Browse Products</h4>
                        <p class="card-text text-muted">
                            Explore available electronic items listed by users, with prices and details clearly shown.
                        </p>
                        <a href="<?= base_url('index.php/products') ?>" class="btn btn-sm btn-primary">Go to Products</a>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card feature-card p-4">
                    <div class="card-body">
                        <h4 class="card-title text-success">Sell Your Items</h4>
                        <p class="card-text text-muted">
                            Add your own products quickly and make them visible to other users on the marketplace.
                        </p>
                        <a href="<?= base_url('index.php/products/create') ?>" class="btn btn-sm btn-success">Add Product</a>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card feature-card p-4">
                    <div class="card-body">
                        <h4 class="card-title text-danger">Secure Access</h4>
                        <p class="card-text text-muted">
                            Your account session is active, giving you access to your marketplace actions securely.
                        </p>
                        <a href="<?= base_url('index.php/logout') ?>" class="btn btn-sm btn-danger">Logout</a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<footer>
    <div class="container">
        <p class="mb-0">© <?= date('Y') ?> ElectroMart. Built with CodeIgniter 4 and Bootstrap 5.</p>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>