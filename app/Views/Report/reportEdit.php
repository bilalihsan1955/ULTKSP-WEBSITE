<?= $this->extend('layout/user/header'); ?>

<?= $this->section('content'); ?>
<style>
    #editor {
        min-height: 200px;
    }
</style>
<!-- Begin Page Content -->
<div class="container-fluid" style="padding-left: 0; padding-right: 0; padding-bottom: 5%; padding-top: 2.5%;">

    <!-- complain report -->
    <div class="container-fluid bg-light mt-n4 mb-5" style="padding:2.5%">
        <div class="row align-items-center m-5 justify-content-center font-weight-bold py-3 ">
            <h1 class="font-weight-bold text-gray-800" style="text-align:center">Edit Complain Report</h1>
        </div>
        <!-- DataTales Example -->
        <div class="card shadow">
            <div class="card-header py-3">
                <div class="row align-items-center justify-content-center font-weight-bold">
                    <div class="col">
                        <h6 class="m-0 font-weight-bold text-primary">Please Fill The Form Correctly</h6>
                    </div>
                </div>
            </div>
            <div class="card-body">

                <?php
                $encrypter = \Config\Services::encrypter();
                $encryptedLaporanId = bin2hex($encrypter->encrypt(base64_encode($laporan['id'])));
                // $encryptedId = rawurlencode($encryptedLaporanId); // Encode untuk URL
                ?>

                <form id="edit-report" action="<?= base_url('Edit-Report/' . $laporan['subject'] . '/' . $encryptedLaporanId) ?>" method="post" enctype="multipart/form-data">
                    <?= csrf_field() ?>
                    <input type="hidden" name="foto_old" value="<?= esc($laporan['foto_file']) ?>">
                    <div class="form-group row">
                        <div class="col-sm-12 mb-3 mb-sm-0">
                            <label for="subject">Subject</label>
                            <input type="text" class="form-control form-control-sm" id="subject" name="subject" value="<?= esc($laporan['subject']) ?>" placeholder="Your Subject" required>
                        </div>
                    </div>
                    <div class="form-group row mt-4">
                        <div class="col-sm-12 mb-3 mb-sm-0">
                            <label for="editor">Contents</label>
                            <textarea class="form-control" id="editor" name="editor" placeholder="Add report content" required id="floatingTextarea"><?= esc($laporan['isi']) ?></textarea>
                        </div>
                    </div>

                    <div class="form-group row mt-4">
                        <div class="col-sm-12 mb-3 mb-sm-0">
                            <label for="photo">Photo</label>
                            <input type="file" class="form-control form-control-sm" id="foto" name="foto" onchange="previewImage();">
                        </div>
                    </div>

                    <?php if (!empty($laporan['foto_file'])) : ?>
                        <div class="col-sm-2 text-center justify-content-center align-items-center d-flex" style="width: 200px; height: 300px; overflow: hidden; position: relative; margin-left: -1%;">
                            <img id="imgPreview" style="border-radius:0.5rem" src="<?= base_url('uploads/reports/' . esc($laporan['foto_file'])) ?>" class="img-fluid" alt="User Photo">
                        </div>
                    <?php endif; ?>

                    <hr>

                    <button type="submit" class="btn btn-primary btn-block btn-sm mt-2">Confirm Edit</button>
                </form>
            </div>
        </div>
    </div>
    <?= $this->endSection(); ?>