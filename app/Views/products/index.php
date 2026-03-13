<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Products - ElectroMart</title>
</head>
<body>
    <h1>ElectroMart Products</h1>

    <p>Hello, <?= esc(session()->get('user_name')) ?>!</p>

    <?php if (session()->getFlashdata('success')): ?>
        <p style="color:green;"><?= esc(session()->getFlashdata('success')) ?></p>
    <?php endif; ?>

    <p>
        <a href="<?= base_url('index.php/') ?>">Home</a> |
        <a href="<?= base_url('index.php/products/create') ?>">Add Product</a> |
        <a href="<?= base_url('index.php/logout') ?>">Logout</a>
    </p>

    <?php if (empty($products)): ?>
        <p>No products found.</p>
    <?php else: ?>
        <?php foreach ($products as $product): ?>
            <hr>

            <h3><?= esc($product['title']) ?></h3>

            <?php if (!empty($product['image'])): ?>
                <img src="<?= base_url('uploads/' . $product['image']) ?>" width="120" alt="Product Image">
            <?php endif; ?>

            <p><strong>Category:</strong> <?= esc($product['category']) ?></p>
            <p><strong>Price:</strong> £<?= esc($product['price']) ?></p>
            <p><strong>Seller:</strong> <?= esc($product['seller_name']) ?></p>
            <p><?= esc($product['description']) ?></p>

            <p>
                <a href="<?= base_url('index.php/products/show/' . $product['id']) ?>">View Details</a>
            </p>
        <?php endforeach; ?>
    <?php endif; ?>
</body>
</html>