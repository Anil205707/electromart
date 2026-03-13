<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Add Product - ElectroMart</title>
</head>
<body>

<h1>Add Product</h1>

<form method="post" action="<?= base_url('index.php/products/store') ?>" enctype="multipart/form-data">

    <label>Product Name</label><br>
    <input type="text" name="title" required><br><br>

    <label>Category</label><br>
    <input type="text" name="category" required><br><br>

    <label>Price</label><br>
    <input type="number" step="0.01" name="price" required><br><br>

    <label>Description</label><br>
    <textarea name="description" required></textarea><br><br>

    <label>Product Image</label><br>
    <input type="file" name="image"><br><br>

    <button type="submit">Add Product</button>

</form>

<br>
<a href="<?= base_url('index.php/products') ?>">Back to Products</a>

</body>
</html>