<?= view('layout/header', ['title' => 'My Favourites - ElectroMart']) ?>

<div class="d-flex justify-content-between align-items-center flex-wrap mb-4">
    <div>
        <h1 class="page-title">My Favourite Products</h1>
        <p class="text-muted mb-0">Products you saved for later.</p>
    </div>
    <a href="<?= base_url('index.php/products') ?>" class="btn btn-outline-primary mt-3 mt-md-0">Back to Products</a>
</div>

<div class="row g-4">
    <?php if (empty($products)): ?>
        <div class="col-12">
            <div class="alert alert-warning">You have no favourite products yet.</div>
        </div>
    <?php else: ?>
        <?php foreach ($products as $product): ?>
            <div class="col-md-6 col-lg-4">
                <div class="custom-card">
                    <?php if ($product['image']): ?>
                        <img src="<?= base_url('uploads/' . $product['image']) ?>" alt="Product Image" class="product-image mb-3">
                    <?php else: ?>
                        <img src="https://via.placeholder.com/400x220?text=No+Image" alt="No Image" class="product-image mb-3">
                    <?php endif; ?>

                    <h4><?= esc($product['title']) ?></h4>
                    <p class="mb-2"><strong>Category:</strong> <?= esc($product['category']) ?></p>
                    <p class="mb-2"><strong>Price:</strong> £<?= esc($product['price']) ?></p>
                    <p class="mb-2"><strong>Seller:</strong> <?= esc($product['seller_name']) ?></p>
                    <p class="text-muted"><?= esc($product['description']) ?></p>

                    <a href="<?= base_url('index.php/products/show/' . $product['id']) ?>" class="btn btn-outline-primary w-100">View Details</a>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<?= view('layout/footer') ?>