<?= view('layout/header', ['title' => 'Add Product - ElectroMart']) ?>

<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="form-card">
            <h1 class="page-title mb-4">Add Product</h1>
            <p class="text-muted">Fill in the product details below to list your electronic item on ElectroMart.</p>

            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger"><?= esc(session()->getFlashdata('error')) ?></div>
            <?php endif; ?>

            <form method="post" action="<?= base_url('index.php/products/store') ?>" enctype="multipart/form-data">
                <div class="mb-3">
                    <label class="form-label">Product Name</label>
                    <input type="text" name="title" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Category</label>
                    <input type="text" name="category" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Price</label>
                    <input type="number" step="0.01" name="price" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Description</label>
                    <textarea name="description" class="form-control" rows="5" required></textarea>
                </div>

                <div class="mb-4">
                    <label class="form-label">Product Image</label>
                    <input type="file" name="image" class="form-control" accept="image/*" capture="environment">
                </div>

                <div class="d-flex gap-3">
                    <button type="submit" class="btn btn-primary">Add Product</button>
                    <a href="<?= base_url('index.php/products') ?>" class="btn btn-outline-secondary">Back to Products</a>
                </div>
            </form>
        </div>
    </div>
</div>

<?= view('layout/footer') ?>