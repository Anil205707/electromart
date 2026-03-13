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
        <a href="<?= base_url('public/index.php/logout') ?>">Logout</a>
    </p>
</body>
</html>