<?= $this->extend('layout/auth/header'); ?>
<?= $this->section('content'); ?>
<body class="bg-gradient-purple" style="padding-top: 3em; padding-bottom: 3em; font-family: Poppins, sans-serif;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-10 col-lg-12 col-md-9">
                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-lg-12 text-center">
                                <div class="p-5">
                                    <h3><?= $message ?></h3>
                                    <a href="<?= base_url('/SignIn') ?>" class="btn btn-primary mt-4">Login Sekarang</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?= $this->endsection(); ?>