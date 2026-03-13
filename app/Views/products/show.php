<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Product Details - ElectroMart</title>
</head>
<body>
    <h1><?= esc($product['title']) ?></h1>

    <?php if (!empty($product['image'])): ?>
        <img src="<?= base_url('uploads/' . $product['image']) ?>" width="300" alt="Product Image">
    <?php endif; ?>

    <p><strong>Price:</strong> £<?= esc($product['price']) ?></p>
    <p><strong>Category:</strong> <?= esc($product['category']) ?></p>

    <p><strong>Description:</strong></p>
    <p><?= esc($product['description']) ?></p>

    <p><strong>Seller:</strong> <?= esc($product['seller_name']) ?></p>

    <br>

    <a href="<?= base_url('index.php/products') ?>">Back to Products</a>
</body>
</html>