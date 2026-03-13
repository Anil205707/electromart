<?= view('layout/header', ['title' => 'Product Details - ElectroMart']) ?>

<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="custom-card">
            <?php if ($product['image']): ?>
                <img src="<?= base_url('uploads/' . $product['image']) ?>" alt="Product Image" class="product-image mb-4">
            <?php else: ?>
                <img src="https://via.placeholder.com/700x300?text=No+Image" alt="No Image" class="product-image mb-4">
            <?php endif; ?>

            <h1 class="page-title"><?= esc($product['title']) ?></h1>
            <p><strong>Price:</strong> £<?= esc($product['price']) ?></p>
            <p><strong>Category:</strong> <?= esc($product['category']) ?></p>
            <p><strong>Seller:</strong> <?= esc($product['seller_name']) ?></p>
            <p><strong>Description:</strong></p>
            <p class="text-muted"><?= esc($product['description']) ?></p>

            <a href="<?= base_url('index.php/products') ?>" class="btn btn-outline-primary">Back to Products</a>
        </div>
    </div>
</div>

<?= view('layout/footer') ?>