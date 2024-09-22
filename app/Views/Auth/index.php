<?= $this->extend('layout/auth/header'); ?>
<?= $this->section('content'); ?>

<body class="bg-gradient-purple" style="padding-top: 3em; padding-bottom: 3em; font-family: Poppins, sans-serif;">

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-10 col-lg-12 col-md-9">
                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-lg-6 d-flex justify-content-center align-items-center text-center">
                                <div class="m-5">
                                    <img src="<?= base_url('assets/images/logo vokasi UB vertikal-01.png') ?>" alt="Logo Universitas Brawijaya" style="max-width: 100%;">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <?php if (session()->getFlashdata('success')) : ?>
                                        <svg xmlns="http://www.w3.org/2000/svg" class="d-none">
                                            <symbol id="check-circle-fill" viewBox="0 0 16 16">
                                                <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
                                            </symbol>
                                        </svg>
                                        <div id="autoCloseAlert" class="alert alert-success d-flex align-items-center alert-dismissible fade show" role="alert">
                                            <svg class="bi flex-shrink-0 me-1" role="img" aria-label="Success:" width="20" height="20">
                                                <use xlink:href="#check-circle-fill" />
                                            </svg>
                                            <div class="mx-2">
                                                <?= session()->getFlashdata('success') ?>
                                            </div>
                                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                        </div>
                                    <?php endif; ?>

                                    <?php if (session()->getFlashdata('errors')) : ?>
                                        <symbol id="exclamation-triangle-fill" viewBox="0 0 16 16">
                                            <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z" />
                                        </symbol>
                                        <div id="autoCloseAlert" class="alert alert-danger d-flex align-items-center alert-dismissible fade show" role="alert">
                                            <svg class="bi flex-shrink-0 me-1" role="img" aria-label="Danger:" width="20" height="20">
                                                <use xlink:href="#check-circle-fill" />
                                            </svg>
                                            <div class="mx-2">
                                                <?php foreach (session()->getFlashdata('errors') as $error) : ?>
                                                    <li><?= esc($error) ?></li>
                                                <?php endforeach; ?>
                                            </div>
                                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                        </div>
                                    <?php endif; ?>
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Welcome Back!</h1>
                                    </div>
                                    <form class="user" id="login-form" action="<?= site_url('/SignIn'); ?>" method="post">
                                        <div class="form-group">
                                            <label for="username" class="form-label">Username</label>
                                            <input name="username" type="text" class="form-control form-control-sm" id="username" placeholder="Username" onclick="removeError()">
                                        </div>
                                        <div class="form-group">
                                            <label for="password" class="form-label">Password</label>
                                            <input name="password" type="password" class="form-control form-control-sm" id="password" placeholder="Password" onclick="removeError()">
                                            <?php if (session()->getFlashdata('error-pw')) : ?>
                                                <label for="error-label" id="error-label" class="form-label text-danger"><small><?= session()->getFlashdata('error-pw') ?></small></label>
                                            <?php endif; ?>
                                            <div class="text-right mt-2">
                                                <a class="small" href="<?= base_url('forgot-password') ?>">Forgot Password?</a>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-primary btn-sm btn-block">
                                            Login
                                        </button>
                                    </form>
                                    <hr>
                                    <div class="text-center">
                                        <span>
                                            Don't Have An Account? <a class="small" href="<?= base_url('/Register') ?>">Sign Up</a>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?= $this->endsection(); ?>