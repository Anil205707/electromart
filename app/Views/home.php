<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>ElectroMart Home</title>
</head>
<body>
    <h1>Welcome to ElectroMart</h1>

    <p>Hello, <?= esc(session()->get('user_name')) ?>!</p>
    <p>You are logged in successfully.</p>

    <p>
        <a href="<?= base_url('index.php/products') ?>">View Products</a> |
        <a href="<?= base_url('index.php/products/create') ?>">Add Product</a> |
        <a href="<?= base_url('index.php/logout') ?>">Logout</a>
    </p>
</body>
</html>