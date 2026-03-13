<?= view('layout/header', ['title' => 'Products - ElectroMart']) ?>

<div class="d-flex justify-content-between align-items-center flex-wrap mb-4">
    <div>
        <h1 class="page-title">ElectroMart Products</h1>
        <p class="text-muted mb-0">Hello, <?= esc(session()->get('user_name')) ?>. Browse the latest listings below.</p>
    </div>
    <a href="<?= base_url('index.php/products/create') ?>" class="btn btn-primary mt-3 mt-md-0">+ Add Product</a>
</div>

<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success"><?= esc(session()->getFlashdata('success')) ?></div>
<?php endif; ?>

<div class="search-box mb-4">
    <div class="row g-3">
        <div class="col-md-10">
            <input
                type="text"
                id="liveSearch"
                class="form-control form-control-lg"
                placeholder="Search products by name, category, or description..."
                value="<?= esc($q ?? '') ?>"
            >
        </div>
        <div class="col-md-2 d-grid">
            <button type="button" id="searchBtn" class="btn btn-success btn-lg">Search</button>
        </div>
    </div>
</div>

<div class="row g-4" id="productsContainer">
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

<script>
    const searchInput = document.getElementById('liveSearch');
    const searchBtn = document.getElementById('searchBtn');
    const productsContainer = document.getElementById('productsContainer');

    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text ?? '';
        return div.innerHTML;
    }

    function renderProducts(products) {
        if (!products.length) {
            productsContainer.innerHTML = `
                <div class="col-12">
                    <div class="alert alert-warning">No products found.</div>
                </div>
            `;
            return;
        }

        let html = '';

        products.forEach(product => {
            const imageUrl = product.image
                ? `<?= base_url('uploads/') ?>${product.image}`
                : 'https://via.placeholder.com/400x220?text=No+Image';

            html += `
                <div class="col-md-6 col-lg-4">
                    <div class="custom-card">
                        <img src="${imageUrl}" alt="Product Image" class="product-image mb-3">

                        <h4>${escapeHtml(product.title)}</h4>
                        <p class="mb-2"><strong>Category:</strong> ${escapeHtml(product.category)}</p>
                        <p class="mb-2"><strong>Price:</strong> £${escapeHtml(product.price)}</p>
                        <p class="mb-2"><strong>Seller:</strong> ${escapeHtml(product.seller_name)}</p>
                        <p class="text-muted">${escapeHtml(product.description)}</p>

                        <a href="<?= base_url('index.php/products/show/') ?>${product.id}" class="btn btn-outline-primary w-100">View Details</a>
                    </div>
                </div>
            `;
        });

        productsContainer.innerHTML = html;
    }

    async function fetchProducts() {
        const query = searchInput.value.trim();
        const url = `<?= base_url('index.php/products/search-ajax') ?>?q=${encodeURIComponent(query)}`;

        try {
            const response = await fetch(url);
            const data = await response.json();
            renderProducts(data);
        } catch (error) {
            productsContainer.innerHTML = `
                <div class="col-12">
                    <div class="alert alert-danger">Failed to load search results.</div>
                </div>
            `;
        }
    }

    let debounceTimer;

    searchInput.addEventListener('keyup', function () {
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(fetchProducts, 300);
    });

    searchBtn.addEventListener('click', fetchProducts);
</script>

<?= view('layout/footer') ?>