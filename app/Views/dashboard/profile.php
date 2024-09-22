<?= $this->extend('layout/user/header'); ?>

<?= $this->section('content'); ?>

<div class="container-fluid" style="padding-left: 0; padding-right: 0;">
    <div class="container-fluid bg-light mt-n4 mb-5" style="padding:2.5%">
        <div class="row align-items-center m-5 justify-content-center font-weight-bold py-3 ">
            <h1 class="font-weight-bold text-gray-800" style="text-align:center">Profile</h1>
        </div>
        <div class="card shadow">
            <div class="card-header py-3">
                <div class="row align-items-center justify-content-center font-weight-bold">
                    <div class="col">
                        <h6 class="m-0 font-weight-bold text-purple">Your Identity</h6>
                    </div>
                </div>
            </div>
            <div class="card-body">
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

                <form id="edit-profile-form" action="<?= base_url('/Profile') ?>" method="post" enctype="multipart/form-data">
                    <?= csrf_field() ?>
                    <input type="hidden" name="foto_old" value="<?= esc($user['foto']) ?>">

                    <div class="form-group row">
                        <div class="col-sm-6 mb-3 mb-sm-0">
                            <label for="exampleUsername">Username</label>
                            <input type="text" required class="form-control form-control-sm" name="username" placeholder="Your Username" value="<?= esc($user['username']) ?>">
                        </div>
                        <div class="col-sm-6">
                            <label for="exampleLastName">Name</label>
                            <input type="text" required class="form-control form-control-sm" name="nama" placeholder="Your Name" value="<?= esc($user['nama']) ?>">
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-6 mb-3 mb-sm-0">
                            <label for="exampleInputEmail">Email</label>
                            <input type="email" required readonly class="form-control form-control-sm" name="email" placeholder="Ex. email@student.ub.ac.id" value="<?= esc($user['email']) ?>">
                        </div>
                        <div class="col-sm-6">
                            <label for="examplePhonenumber">Phone Number</label>
                            <input type="text" required class="form-control form-control-sm" name="nomor_hp" placeholder="Your Phone Number" value="<?= esc($user['nomor_hp']) ?>" inputmode="numeric">
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-6">
                            <label for="exampleInputEmail">Nim</label>
                            <input type="numberrequired " class="form-control form-control-sm" name="nim" placeholder="Your NIM" value="<?= esc($user['nim']) ?>" inputmode="numeric">
                        </div>
                        <div class="col-sm-6 mb-3 mb-sm-0">
                            <label for="kategori">Study Program</label>
                            <select class="form-control form-control-sm" name="prodi" placeholder="Your Study Program">
                                <option value="select">Select Your Study Program</option>
                                <option value="Ti" <?= $user['prodi'] === 'Ti' ? 'selected' : '' ?>>Teknologi Informasi</option>
                                <option value="Dg" <?= $user['prodi'] === 'Dg' ? 'selected' : '' ?>>Desain Grafis</option>
                                <option value="Adbis" <?= $user['prodi'] === 'Adbis' ? 'selected' : '' ?>>Administrasi Bisnis</option>
                                <option value="Keubank" <?= $user['prodi'] === 'Keubank' ? 'selected' : '' ?>>Keuangan dan Perbankan</option>
                                <option value="MP" <?= $user['prodi'] === 'MP' ? 'selected' : '' ?>>Manajemen Perhotelan</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="exampleInputEmail">Photo</label>
                        <input type="file" class="form-control form-control-sm" name="foto" id="foto" onchange="previewImage();">
                    </div>

                    <?php if (!empty($user['foto'])) : ?>
                        <div class="col-sm-2 text-center justify-content-center align-items-center d-flex" style="width: 200px; height: 300px; overflow: hidden; position: relative; margin-left: -1%;">
                            <img id="imgPreview" style="border-radius:0.5rem" src="<?= base_url('uploads/profile/' . esc($user['foto'])) ?>" class="img-fluid" alt="User Photo">
                        </div>
                    <?php endif; ?>
                    <hr>
                    <button type="submit" class="btn-light-purple btn-block btn-sm">Update Profile</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>