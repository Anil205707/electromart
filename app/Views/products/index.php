<?= view('layout/header', ['title' => 'Products - ElectroMart']) ?>

<div class="d-flex justify-content-between align-items-start flex-wrap mb-4 gap-3">
    <div>
        <h1 class="page-title mb-2">ElectroMart Products</h1>
        <p class="text-muted mb-0">
            Hello, <?= esc(session()->get('user_name')) ?>. Browse the latest listings below.
        </p>
    </div>

    <div class="d-flex gap-2 flex-wrap">
        <a href="<?= base_url('favourites') ?>" class="btn btn-warning px-4 py-2 fw-semibold">My Favourites</a>
        <a href="<?= base_url('products/create') ?>" class="btn btn-primary px-4 py-2 fw-semibold">+ Add Product</a>
    </div>
</div>

<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success">
        <?= esc(session()->getFlashdata('success')) ?>
    </div>
<?php endif; ?>

<div class="search-box mb-4">
    <form method="get" action="<?= base_url('products') ?>">
        <div class="row g-3 align-items-end">

            <div class="col-lg-4 col-md-12">
                <label class="form-label fw-semibold">Search</label>
                <input
                    type="text"
                    name="q"
                    class="form-control form-control-lg"
                    placeholder="Search products..."
                    value="<?= esc($q ?? '') ?>"
                >
            </div>

            <div class="col-lg-3 col-md-4">
                <label class="form-label fw-semibold">Category</label>
                <select name="category" class="form-select form-select-lg">
                    <option value="">All Categories</option>
                    <?php foreach ($categories as $cat): ?>
                        <option value="<?= esc($cat['category']) ?>" <?= (($category ?? '') === $cat['category']) ? 'selected' : '' ?>>
                            <?= esc($cat['category']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="col-lg-2 col-md-4">
                <label class="form-label fw-semibold">Sort</label>
                <select name="sort" class="form-select form-select-lg">
                    <option value="">Newest</option>
                    <option value="price_low" <?= (($sort ?? '') === 'price_low') ? 'selected' : '' ?>>Low to High</option>
                    <option value="price_high" <?= (($sort ?? '') === 'price_high') ? 'selected' : '' ?>>High to Low</option>
                </select>
            </div>

            <div class="col-lg-3 col-md-4">
                <label class="form-label fw-semibold">Currency</label>
                <select id="currencySelect" class="form-select form-select-lg">
                    <option value="USD">USD ($)</option>
                    <option value="EUR">EUR (€)</option>
                    <option value="INR">INR (₹)</option>
                    <option value="NPR">NPR (Rs)</option>
                </select>
            </div>

            <div class="col-12">
                <div class="d-flex flex-wrap gap-2 pt-2">
                    <button type="submit" class="btn btn-success px-4 py-2 fw-semibold">Apply Filters</button>
                    <button type="button" id="convertPricesBtn" class="btn btn-dark px-4 py-2 fw-semibold">Convert Prices</button>
                    <button type="button" id="resetPricesBtn" class="btn btn-outline-secondary px-4 py-2 fw-semibold">Reset to GBP</button>
                </div>
            </div>

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

                    <div class="product-image-wrapper">
                        <?php if (!empty($product['image'])): ?>
                            <img src="<?= base_url('uploads/' . $product['image']) ?>" alt="Product Image" class="product-image">
                        <?php else: ?>
                            <img src="https://via.placeholder.com/400x220?text=No+Image" alt="No Image" class="product-image">
                        <?php endif; ?>
                    </div>

                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <h4 class="mb-0"><?= esc($product['title']) ?></h4>
                        <button
                            type="button"
                            class="btn btn-sm favourite-btn <?= in_array($product['id'], $favouriteIds ?? []) ? 'btn-danger' : 'btn-outline-danger' ?>"
                            data-product-id="<?= esc($product['id']) ?>"
                        >
                            ♥
                        </button>
                    </div>

                    <p class="mb-2"><strong>Category:</strong> <?= esc($product['category']) ?></p>

                    <p class="mb-2 price-line" data-price="<?= esc($product['price']) ?>">
                        <strong>Price:</strong>
                        <span class="price-text">£<?= number_format((float) $product['price'], 2) ?></span>
                    </p>

                    <p class="mb-2"><strong>Seller:</strong> <?= esc($product['seller_name']) ?></p>
                    <p class="text-muted"><?= esc($product['description']) ?></p>

                    <a href="<?= base_url('products/show/' . $product['id']) ?>" class="btn btn-outline-primary w-100">View Details</a>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<div class="pagination-wrapper d-flex justify-content-center">
    <?= $pager->links('default', 'custom_pager') ?>
</div>

<script>
document.querySelectorAll('.favourite-btn').forEach(button => {
    button.addEventListener('click', async function () {
        const productId = this.dataset.productId;

        try {
            const response = await fetch("<?= base_url('favourites/toggle') ?>", {
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

const currencySymbols = {
    USD: '$',
    EUR: '€',
    INR: '₹',
    NPR: 'Rs '
};

async function convertPrices() {
    const button = document.getElementById('convertPricesBtn');
    const selectedCurrency = document.getElementById('currencySelect').value;

    button.disabled = true;
    button.textContent = 'Converting...';

    try {
        const response = await fetch('https://open.er-api.com/v6/latest/GBP');
        const data = await response.json();

        if (data.result === 'success' && data.rates && data.rates[selectedCurrency]) {
            const rate = data.rates[selectedCurrency];
            const symbol = currencySymbols[selectedCurrency] ?? '';

            document.querySelectorAll('.price-line').forEach(priceLine => {
                const gbpPrice = parseFloat(priceLine.dataset.price);
                const convertedPrice = (gbpPrice * rate).toFixed(2);

                priceLine.querySelector('.price-text').textContent =
                    symbol + convertedPrice + ' ' + selectedCurrency;
            });

            button.textContent = 'Converted';
        } else {
            button.textContent = 'Failed';
        }
    } catch (error) {
        button.textContent = 'Failed';
    }

    setTimeout(() => {
        button.disabled = false;
        button.textContent = 'Convert Prices';
    }, 800);
}

function resetPricesToGBP() {
    document.querySelectorAll('.price-line').forEach(priceLine => {
        const gbpPrice = parseFloat(priceLine.dataset.price).toFixed(2);
        priceLine.querySelector('.price-text').textContent = '£' + gbpPrice;
    });
}

document.getElementById('convertPricesBtn').addEventListener('click', convertPrices);
document.getElementById('resetPricesBtn').addEventListener('click', resetPricesToGBP);
</script>

<?= view('layout/footer') ?>