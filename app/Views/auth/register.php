<?= view('layout/header', ['title' => 'Register - ElectroMart']) ?>

<div class="row justify-content-center align-items-center" style="min-height: 75vh;">
    <div class="col-md-8 col-lg-5">
        <div class="form-card">
            <div class="text-center mb-4">
                <h1 class="page-title">Create Account</h1>
                <p class="text-muted">Join ElectroMart and start buying or selling electronics.</p>
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

            <form method="post" action="<?= base_url('index.php/register') ?>">
                <div class="mb-3">
                    <label for="name" class="form-label">Full Name</label>
                    <input
                        type="text"
                        id="name"
                        name="name"
                        class="form-control"
                        value="<?= old('name') ?>"
                        required
                    >
                </div>

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
                    <button type="submit" class="btn btn-success btn-lg">Register</button>
                </div>
            </form>

            <div class="text-center">
                <p class="mb-0">
                    Already have an account?
                    <a href="<?= base_url('index.php/login') ?>" class="text-decoration-none fw-semibold">Login here</a>
                </p>
            </div>
        </div>
    </div>
</div>

<?= view('layout/footer') ?>