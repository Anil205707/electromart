<?= view('layout/header', ['title' => 'Product Details - ElectroMart']) ?>

<div class="row justify-content-center">
    <div class="col-lg-9">
        <div class="custom-card">

            <div class="detail-image-wrapper">
                <?php if (!empty($product['image'])): ?>
                    <img src="<?= base_url('uploads/' . $product['image']) ?>" alt="Product Image" class="detail-image">
                <?php else: ?>
                    <img src="https://via.placeholder.com/700x300?text=No+Image" alt="No Image" class="detail-image">
                <?php endif; ?>
            </div>

            <h1 class="page-title mb-4"><?= esc($product['title']) ?></h1>

            <div class="row">
                <div class="col-md-6">
                    <p><strong>Price:</strong> £<?= number_format((float) $product['price'], 2) ?></p>
                    <p><strong>Category:</strong> <?= esc($product['category']) ?></p>
                    <p><strong>Seller:</strong> <?= esc($product['seller_name']) ?></p>
                </div>
                <div class="col-md-6">
                    <?php if (!empty($product['created_at'])): ?>
                        <p><strong>Created At:</strong> <?= esc($product['created_at']) ?></p>
                    <?php endif; ?>
                </div>
            </div>

            <hr>

            <h4 class="mb-3">Description</h4>
            <p class="text-muted"><?= esc($product['description']) ?></p>

            <?php if (!empty($product['latitude']) && !empty($product['longitude'])): ?>
                <hr>
                <h4 class="mt-4">Product Location</h4>
                <p class="text-muted">Location provided by seller using browser geolocation.</p>

                <iframe
                    width="100%"
                    height="350"
                    style="border:0; border-radius:16px;"
                    loading="lazy"
                    allowfullscreen
                    src="https://www.google.com/maps?q=<?= esc($product['latitude']) ?>,<?= esc($product['longitude']) ?>&hl=en&z=14&output=embed">
                </iframe>

                <p class="mt-3 mb-0">
                    <strong>Latitude:</strong> <?= esc($product['latitude']) ?> |
                    <strong>Longitude:</strong> <?= esc($product['longitude']) ?>
                </p>
            <?php endif; ?>

            <div class="mt-4 d-flex flex-wrap gap-2">
                <a href="<?= base_url('products') ?>" class="btn btn-outline-primary">Back to Products</a>
                <a href="<?= base_url('favourites') ?>" class="btn btn-outline-warning">My Favourites</a>
            </div>
        </div>
    </div>
</div>

<?= view('layout/footer') ?>