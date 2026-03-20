<?= view('layout/header', ['title' => 'Products - ElectroMart']) ?>

<div class="d-flex justify-content-between align-items-center flex-wrap mb-4">
    <div>
        <h1 class="page-title">ElectroMart Products</h1>
        <p class="text-muted mb-0">Hello, <?= esc(session()->get('user_name')) ?>. Browse the latest listings below.</p>
    </div>
    <div class="mt-3 mt-md-0 d-flex gap-2">
        <a href="<?= base_url('index.php/favourites') ?>" class="btn btn-warning">My Favourites</a>
        <a href="<?= base_url('index.php/products/create') ?>" class="btn btn-primary">+ Add Product</a>
    </div>
</div>

<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success"><?= esc(session()->getFlashdata('success')) ?></div>
<?php endif; ?>

<div class="search-box mb-4">
    <form method="get" action="<?= base_url('index.php/products') ?>" class="row g-3">
        <div class="col-md-5">
            <input
                type="text"
                name="q"
                class="form-control form-control-lg"
                placeholder="Search products..."
                value="<?= esc($q ?? '') ?>"
            >
        </div>

        <div class="col-md-3">
            <select name="category" class="form-select form-select-lg">
                <option value="">All Categories</option>
                <?php foreach ($categories as $cat): ?>
                    <option value="<?= esc($cat['category']) ?>" <?= (($category ?? '') === $cat['category']) ? 'selected' : '' ?>>
                        <?= esc($cat['category']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="col-md-2">
            <select name="sort" class="form-select form-select-lg">
                <option value="">Newest</option>
                <option value="price_low" <?= (($sort ?? '') === 'price_low') ? 'selected' : '' ?>>Price: Low to High</option>
                <option value="price_high" <?= (($sort ?? '') === 'price_high') ? 'selected' : '' ?>>Price: High to Low</option>
            </select>
        </div>

        <div class="col-md-2 d-grid">
            <button type="submit" class="btn btn-success btn-lg">Apply</button>
        </div>
    </form>
</div>

<div class="row g-4">
    <?php if (empty($products)): ?>
        <div class="col-12">
            <div class="alert alert-warning">No products found.</div>
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

                    <div class="d-flex justify-content-between align-items-start">
                        <h4><?= esc($product['title']) ?></h4>
                        <button
                            type="button"
                            class="btn btn-sm favourite-btn <?= in_array($product['id'], $favouriteIds ?? []) ? 'btn-danger' : 'btn-outline-danger' ?>"
                            data-product-id="<?= $product['id'] ?>"
                        >
                            ♥
                        </button>
                    </div>

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

<div class="mt-5 d-flex justify-content-center">
    <?= $pager->links() ?>
</div>

<script>
document.querySelectorAll('.favourite-btn').forEach(button => {
    button.addEventListener('click', async function () {
        const productId = this.dataset.productId;

        try {
            const response = await fetch("<?= base_url('index.php/favourites/toggle') ?>", {
                method: "POST",
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded"
                },
                body: "product_id=" + encodeURIComponent(productId)
            });

            const data = await response.json();

            if (data.status === 'added') {
                this.classList.remove('btn-outline-danger');
                this.classList.add('btn-danger');
            } else if (data.status === 'removed') {
                this.classList.remove('btn-danger');
                this.classList.add('btn-outline-danger');
            }
        } catch (error) {
            alert('Failed to update favourite.');
        }
    });
});
</script>

<?= view('layout/footer') ?>