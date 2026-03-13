<?= view('layout/header', ['title' => 'ElectroMart Home']) ?>

<div class="hero-card">
    <div class="row align-items-center">
        <div class="col-lg-7">
            <span class="badge bg-primary-subtle text-primary fs-6 px-3 py-2">
                Welcome back, <?= esc(session()->get('user_name')) ?>!
            </span>

            <h1 class="display-4 fw-bold text-primary mt-3">Buy and Sell Electronics with Confidence</h1>

            <p class="lead text-muted mt-3">
                Explore laptops, phones, accessories, and more. Add your own listings, browse products, and manage your marketplace experience in one place.
            </p>

            <div class="mt-4 d-flex flex-wrap gap-3">
                <a href="<?= base_url('index.php/products') ?>" class="btn btn-primary btn-lg">View Products</a>
                <a href="<?= base_url('index.php/products/create') ?>" class="btn btn-outline-primary btn-lg">Add Product</a>
            </div>
        </div>

        <div class="col-lg-5 text-center mt-4 mt-lg-0">
            <img src="https://cdn-icons-png.flaticon.com/512/1041/1041886.png" alt="Electronics" class="img-fluid" style="max-width: 300px;">
        </div>
    </div>
</div>

<div class="search-box mt-4">
    <h4 class="mb-3">Search Products</h4>
    <form method="get" action="<?= base_url('index.php/products') ?>" class="row g-3">
        <div class="col-md-10">
            <input type="text" name="q" class="form-control form-control-lg" placeholder="Search by product name, category, or description">
        </div>
        <div class="col-md-2 d-grid">
            <button type="submit" class="btn btn-success btn-lg">Search</button>
        </div>
    </form>
</div>

<div class="row g-4 mt-2">
    <div class="col-md-4">
        <div class="custom-card">
            <h4 class="text-primary">Browse Products</h4>
            <p class="text-muted">View all available electronic products posted by marketplace users.</p>
            <a href="<?= base_url('index.php/products') ?>" class="btn btn-primary">Go to Products</a>
        </div>
    </div>

    <div class="col-md-4">
        <div class="custom-card">
            <h4 class="text-success">Sell Your Items</h4>
            <p class="text-muted">Post your laptop, phone, or accessory for others to discover and buy.</p>
            <a href="<?= base_url('index.php/products/create') ?>" class="btn btn-success">Add Product</a>
        </div>
    </div>

    <div class="col-md-4">
        <div class="custom-card">
            <h4 class="text-danger">Account Access</h4>
            <p class="text-muted">Your session is active and secure. Log out any time from the navigation bar.</p>
            <a href="<?= base_url('index.php/logout') ?>" class="btn btn-danger">Logout</a>
        </div>
    </div>
</div>

<?= view('layout/footer') ?>