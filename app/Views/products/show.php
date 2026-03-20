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

            <p><strong>Price:</strong> £<span id="gbpPrice"><?= esc($product['price']) ?></span></p>
            <p><strong>Converted Price (USD):</strong> <span id="usdPrice">Loading...</span></p>

            <p><strong>Category:</strong> <?= esc($product['category']) ?></p>
            <p><strong>Seller:</strong> <?= esc($product['seller_name']) ?></p>
            <p><strong>Description:</strong></p>
            <p class="text-muted"><?= esc($product['description']) ?></p>

            <?php if (!empty($product['latitude']) && !empty($product['longitude'])): ?>
                <hr>
                <h4 class="mt-4">Product Location</h4>
                <p class="text-muted">Location provided by seller using browser geolocation.</p>

                <iframe
                    width="100%"
                    height="350"
                    style="border:0; border-radius: 16px;"
                    loading="lazy"
                    allowfullscreen
                    src="https://www.google.com/maps?q=<?= esc($product['latitude']) ?>,<?= esc($product['longitude']) ?>&hl=en&z=14&output=embed">
                </iframe>

                <p class="mt-3 mb-0">
                    <strong>Latitude:</strong> <?= esc($product['latitude']) ?> |
                    <strong>Longitude:</strong> <?= esc($product['longitude']) ?>
                </p>
            <?php endif; ?>

            <div class="mt-4">
                <a href="<?= base_url('products') ?>" class="btn btn-outline-primary">Back to Products</a>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', async function () {
    const gbpPrice = parseFloat(document.getElementById('gbpPrice').textContent);
    const usdPriceElement = document.getElementById('usdPrice');

    try {
        const response = await fetch('https://open.er-api.com/v6/latest/GBP');
        const data = await response.json();

        if (data.result === 'success' && data.rates && data.rates.USD) {
            const usdPrice = (gbpPrice * data.rates.USD).toFixed(2);
            usdPriceElement.textContent = '$' + usdPrice;
        } else {
            usdPriceElement.textContent = 'Unavailable';
        }
    } catch (error) {
        usdPriceElement.textContent = 'Unavailable';
    }
});
</script>

<?= view('layout/footer') ?>