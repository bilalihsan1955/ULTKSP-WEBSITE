<?= $this->extend('layout/admin/header'); ?>
<?= $this->section('content'); ?>

<style>
    #editor {
        min-height: 200px;
    }
</style>

<!-- Begin Page Content -->
<div class="container-fluid" style="padding-left: 0; padding-right: 0;">

    <!-- complain report -->
    <div class="container-fluid bg-light mt-n4 mb-2" style="padding:2.5%">
        <div class="row align-items-center m-5 justify-content-center font-weight-bold py-3 ">
            <h1 class="font-weight-bold text-gray-800" style="text-align:center"><?= $laporan['subject'] ?></h1>
            <div class="col-12 align-items-center m-5 justify-content-center text-center">
                <img src="<?= base_url('uploads/reports/' . $laporan['foto_file']) ?>" alt="Logo Universitas Brawijaya" style="max-width: 100%; max-height: 25rem; height: auto; width:auto; border-radius:0.5rem;">
            </div>
            <div class="container-fluid font-weight-normal text-gray-900 mt-5">
                <p>
                    <?= $laporan['isi'] ?>
                </p>
                <hr class="mt-5">

            </div>
            <?php if (!empty($comments)) : // Cek apakah ada komentar 
            ?>
                <div class="container mt-5">

                    <h1 class="mb-4 font-weight-bold text-gray-800">Comments</h1>
                    <div class="row mt-2">
                        <?php foreach ($comments as $comment) { ?>
                            <?php if ($comment['id_laporan'] == $laporan['id']) { // Comments on this post 
                            ?>
                                <?php if ($comment['user_id'] == $user['id'] && $user['role'] == 'admin') { // Comment by current user 
                                ?>
                                    <div class="col-md-12 mb-4">
                                        <div class="bg-gray-100 p-4 border-right-purple border-4 shadow rounded">
                                            <div class="row align-items-center">
                                                <div class="col">
                                                    <div class="row text-end">
                                                        <div class="col">
                                                            <h6 class="mb-1"><?= $comment['nama']; ?></h6>
                                                            <small class="text-muted"><?= $comment['date_create']; ?></small>
                                                        </div>
                                                        <div class="col-auto">
                                                            <?php if (!empty($comment['foto'])) : ?>
                                                                <img src="<?= base_url('uploads/profile/' . $comment['foto']) ?>" alt="User Profile Picture" class="rounded-circle img-circle img-fluid ms-auto" width="40" height="40" style="object-fit: cover; aspect-ratio: 1/1;">
                                                            <?php else : ?>
                                                                <!-- Tampilkan huruf depan dari nama user -->
                                                                <div class="img-profile rounded-circle bg-primary" style=" color: white; width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; font-size: 20px;">
                                                                    <?= strtoupper($comment['username'][0]); ?>
                                                                </div>
                                                            <?php endif; ?>

                                                        </div>
                                                    </div>
                                                    <hr>
                                                    <div class="col font-weight-normal pt-3 pb-4" style="padding: 0;">
                                                        <p class="mb-0"><?= $comment['isi']; ?></p>
                                                    </div>
                                                    <?php
                                                    $encrypter = \Config\Services::encrypter();
                                                    $encryptedcommentId = bin2hex($encrypter->encrypt(base64_encode($comment['id'])));
                                                    // $encryptedId = rawurlencode($encryptedcommentId); // Encode untuk URL
                                                    ?>
                                                    <div class="col font-weight-normal pt-2 align-end text-end" style="padding: 0;">
                                                        <a href="" onclick="confirmDelete('<?= ('Delete-Comment/' . $encryptedcommentId) ?>')" class="btn btn-danger btn-delete btn-icon-split btn-sm text-gray-100 align-self-end" style="--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .75rem;">
                                                            <span class="icon icon-center bg-transparent">
                                                                <i class="fas fa-trash"></i>
                                                            </span>
                                                            <span class="text">Post Info</span>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php } else { // Comment by current admin 
                                ?>
                                    <div class="col-md-12 mb-4">
                                        <div class="bg-gray-100 p-4 border-left-purple border-4 shadow rounded">
                                            <div class="row align-items-center">
                                                <div class="col">
                                                    <div class="row">
                                                        <div class="col-auto">
                                                            <?php if (!empty($comment['foto'])) : ?>
                                                                <img src="<?= base_url('uploads/profile/' . $comment['foto']) ?>" alt="User Profile Picture" class="rounded-circle img-circle img-fluid ms-auto" width="40" height="40" style="object-fit: cover; aspect-ratio: 1/1;">
                                                            <?php else : ?>
                                                                <!-- Tampilkan huruf depan dari nama user -->
                                                                <div class="img-profile rounded-circle bg-primary" style=" color: white; width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; font-size: 20px;">
                                                                    <?= strtoupper($comment['username'][0]); ?>
                                                                </div>
                                                            <?php endif; ?>
                                                        </div>
                                                        <div class="col">
                                                            <h6 class="mb-1"><?= $comment['nama']; ?></h6>
                                                            <small class="text-muted"><?= $comment['date_create']; ?></small>
                                                        </div>
                                                    </div>
                                                    <hr>
                                                    <div class="col font-weight-normal pt-3 pb-4" style="padding: 0">
                                                        <p class="mb-0"><?= $comment['isi']; ?></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                            <?php } ?>
                        <?php } ?>
                    </div>
                </div>
            <?php else : // Tampilkan pesan jika tidak ada komentar 
            ?>
                <p class="text-muted">No comments available.</p>
            <?php endif; ?>
            <?php

            $encrypter = \Config\Services::encrypter();
            $encryptedLaporanId = bin2hex($encrypter->encrypt(base64_encode($laporan['id'])));
            // $encryptedId = rawurlencode($encryptedLaporanId); // Encode untuk URL
            ?>
            <div class="container-fluid font-weight-normal text-gray-900 mt-5">
                <form id="comment-form" class="user" action="<?= base_url('Admin/Post-Comment/' .  $encryptedLaporanId) ?>" method="post" enctype="multipart/form-data">
                    <div class="form-group row ">
                        <div class="col-sm-12">
                            <label class="fs-3" for="">Add Comment</label>
                            <textarea class="form-control" id="editor" name="editor" placeholder="Add report content" required id="floatingTextarea"></textarea>
                            <button type="submit" class="btn-light-purple btn-block btn-sm mt-3">
                                Post Commment
                            </button>
                        </div>
                    </div>
                    <div class="form-group row ">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- /.container-fluid -->
<?= $this->endsection(''); ?>