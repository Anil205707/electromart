<?= view('layout/header', ['title' => 'Products - ElectroMart']) ?>

<div class="d-flex justify-content-between align-items-center flex-wrap mb-4">
    <div>
        <h1 class="page-title">ElectroMart Products</h1>
        <p class="text-muted mb-0">Hello, <?= esc(session()->get('user_name')) ?>. Browse the latest listings below.</p>
    </div>
    <div class="mt-3 mt-md-0 d-flex gap-2 flex-wrap">
        <a href="<?= base_url('favourites') ?>" class="btn btn-warning">My Favourites</a>
        <a href="<?= base_url('products/create') ?>" class="btn btn-primary">+ Add Product</a>
    </div>
</div>

<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success"><?= esc(session()->getFlashdata('success')) ?></div>
<?php endif; ?>

<div class="search-box mb-4">
    <form method="get" action="<?= base_url('products') ?>" class="row g-3">
        <div class="col-md-4">
            <input
                type="text"
                name="q"
                class="form-control form-control-lg"
                placeholder="Search products..."
                value="<?= esc($q ?? '') ?>"
            >
        </div>

        <div class="col-md-2">
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

        <div class="col-md-2">
            <select id="currencySelect" class="form-select form-select-lg">
                <option value="USD">USD ($)</option>
                <option value="EUR">EUR (€)</option>
                <option value="INR">INR (₹)</option>
                <option value="NPR">NPR (Rs)</option>
            </select>
        </div>

        <div class="col-md-1 d-grid">
            <button type="submit" class="btn btn-success btn-lg">Apply</button>
        </div>

        <div class="col-md-1 d-grid">
            <button type="button" id="convertPricesBtn" class="btn btn-dark btn-lg">Convert</button>
        </div>
    </form>

    <div class="row g-3 mt-2">
        <div class="col-md-3 d-grid">
            <button type="button" id="resetPricesBtn" class="btn btn-outline-secondary">Reset to GBP</button>
        </div>
    </div>
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

                    <p class="mb-2 price-line" data-price="<?= esc($product['price']) ?>">
                        <strong>Price:</strong>
                        <span class="price-text">£<?= esc($product['price']) ?></span>
                    </p>

                    <p class="mb-2"><strong>Seller:</strong> <?= esc($product['seller_name']) ?></p>
                    <p class="text-muted"><?= esc($product['description']) ?></p>

                    <a href="<?= base_url('products/show/' . $product['id']) ?>" class="btn btn-outline-primary w-100">View Details</a>
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
        button.textContent = 'Convert';
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