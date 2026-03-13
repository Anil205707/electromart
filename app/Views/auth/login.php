<?= view('layout/header', ['title' => 'Login - ElectroMart']) ?>

<div class="row justify-content-center align-items-center" style="min-height: 75vh;">
    <div class="col-md-8 col-lg-5">
        <div class="form-card">
            <div class="text-center mb-4">
                <h1 class="page-title">Welcome Back</h1>
                <p class="text-muted">Login to access your ElectroMart account.</p>
            </div>

            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger">
                    <?= esc(session()->getFlashdata('error')) ?>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success">
                    <?= esc(session()->getFlashdata('success')) ?>
                </div>
            <?php endif; ?>

            <form method="post" action="<?= base_url('index.php/login') ?>">
                <div class="mb-3">
                    <label for="email" class="form-label">Email Address</label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        class="form-control"
                        value="<?= old('email') ?>"
                        required
                    >
                </div>

                <div class="mb-4">
                    <label for="password" class="form-label">Password</label>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        class="form-control"
                        required
                    >
                </div>

                <div class="d-grid mb-3">
                    <button type="submit" class="btn btn-primary btn-lg">Login</button>
                </div>
            </form>

            <div class="text-center">
                <p class="mb-0">
                    No account?
                    <a href="<?= base_url('index.php/register') ?>" class="text-decoration-none fw-semibold">Register here</a>
                </p>
            </div>
        </div>
    </div>
</div>

<?= view('layout/footer') ?>