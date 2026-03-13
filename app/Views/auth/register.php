<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Register - ElectroMart</title>
</head>
<body>
    <h1>Register</h1>

    <?php if (session()->getFlashdata('error')): ?>
        <p style="color:red;"><?= esc(session()->getFlashdata('error')) ?></p>
    <?php endif; ?>

    <?php if (session()->getFlashdata('success')): ?>
        <p style="color:green;"><?= esc(session()->getFlashdata('success')) ?></p>
    <?php endif; ?>

    <form method="post" action="<?= base_url('public/index.php/register') ?>">
        <label for="name">Name:</label><br>
        <input type="text" id="name" name="name" value="<?= old('name') ?>"><br><br>

        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" value="<?= old('email') ?>"><br><br>

        <label for="password">Password:</label><br>
        <input type="password" id="password" name="password"><br><br>

        <button type="submit">Register</button>
    </form>

    <p>
        Already have an account?
        <a href="<?= base_url('public/index.php/login') ?>">Login here</a>
    </p>
</body>
</html>