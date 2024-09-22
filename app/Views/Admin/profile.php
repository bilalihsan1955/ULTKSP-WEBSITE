<?= $this->extend('layout/admin/header'); ?>
<?= $this->section('content'); ?>
<style>
    .ck-editor__editable_inline {
        min-height: 200px;
    }
</style>
<!-- Begin Page Content -->
<div class="container-fluid" style="padding-left: 0; padding-right: 0;">

    <!-- complain report -->
    <div class="container-fluid bg-light mt-n4 mb-5" style="padding:2.5%">
        <div class="row align-items-center m-5 justify-content-center font-weight-bold py-3 ">
            <h1 class="font-weight-bold text-gray-800" style="text-align:center">Profile</h1>
        </div>
        <!-- DataTales Example -->
        <div class="card shadow">
            <div class="card-header py-3">
                <div class="row align-items-center justify-content-center font-weight-bold">
                    <div class="col">
                        <h6 class="m-0 font-weight-bold text-purple">Your Identity</h6>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row ">
                    <div class="col-sm-12">
                        <div class="p-5">
                            <form class="user" action="<?= base_url('Admin/Profile') ?>" method="post" enctype="multipart/form-data">
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
                                            <option value="no" <?= $user['prodi'] === 'no' ? 'selected' : '' ?>>none</option>
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
        </div>
    </div>
    <!-- /.container-fluid -->
    <?= $this->endsection(); ?>