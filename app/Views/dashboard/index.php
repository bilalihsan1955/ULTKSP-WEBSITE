<?= $this->extend('layout/user/header'); ?>

<?= $this->section('content'); ?>

<!-- Begin Page Content -->
<div class="container-fluid " style="padding-left: 0; padding-right: 0;">

    <!-- Page Heading -->
    <div class="container-fluid bg-gradient-purple" style="padding-top: 2rem; padding-bottom: 5rem;">
        <div class="row align-items-center mx-5 justify-content-center" style="padding-top:5%">
            <div class="col-md-2 text-center mt-4 mb-5 mx-5 justify-content-center align-items-center d-flex" style="width: 200px; height: 300px; overflow: hidden; position: relative;">
                <?php if ($user['foto']) : ?>
                    <img style="border-radius:0.5rem" src="<?= base_url('uploads/profile/' . $user['foto']) ?>" class="img-fluid" alt="Your Photo">
                <?php else : ?>
                    <div class="profile-photo d-flex align-items-center justify-content-center" style="width: 100%; height: 100%; background-color: #007bff; border-radius: 0.5rem;">
                        <a href="<?= base_url('profile/edit/' . $user['id']) ?>">
                            <span class="text-gray-100 font-weight-bold" style="font-size: 100px;">
                                <?= strtoupper($user['nama'][0]) ?>
                            </span>
                        </a>
                    </div>
                <?php endif; ?>
            </div>
            <div class="col-md-8 mt-5 mb-5">
                <p class="mb-2 text-gray-100">Hi 👋, Welcome To ULTKSP (Unit Layanan Terpadu Kekerasan Seksual dan Perundungan)</p>
                <h1 class="h3 mb-2 text-gray-100 font-weight-bold"><?= strtoupper($user['nama']) ?></h1>
                <h1 class="h3 mb-2 text-gray-100 font-weight-bold"><?= $user['nim'] ?></h1>
                <p class="mb-4 text-gray-100">
                    Unit Layanan Terpadu Kekerasan Seksual dan Perundungan yang selanjutnya disingkat ULTKSP adalah unit yang berfungsi sebagai penyelenggara pelayanan terpadu korban Kekerasan Seksual dan/atau Perundungan yang dikelola oleh UB dan dilaksanakan oleh Fakultas, Pascasarjana, dan Program Studi Di Luar Kampus Utama. Unit ini dibentuk sebagai upaya Fakultas Vokasi untuk memfasilitasi dan melayani masyarakat kampus khususnya di lingkungan Fakultas Vokasi UB (mahasiswa, tenaga kependidikan dan tenaga pendidik) terkait dengan Tindakan kekerasan seksual dan perundungan.
                </p>
            </div>
        </div>
    </div>

    <!-- Complaint Report -->
    <div class="container-fluid bg-light" style="padding:2.5%">
        <div class="row align-items-center m-5 justify-content-center font-weight-bold py-3">
            <h1 class="font-weight-bold text-gray-900" style="text-align:center">Complaint Report</h1>
        </div>
        <!-- DataTales Example -->
        <div class="card shadow">

            <div class="card-header py-3">
                <div class="row align-items-center justify-content-center font-weight-bold">
                    <div class="col">
                        <h6 class="m-0 font-weight-bold text-purple">Your Complaint Report Data</h6>
                    </div>
                    <div class="col-auto mt-2">
                        <a href="<?= base_url('/Add-Report') ?>" class="btn btn-primary btn-sm btn-icon-split container-auto" style="--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .75rem;">
                            <span class="icon icon-center bg-transparent">
                                <i class="fas fa-plus"></i>
                            </span>
                            <span class="text">Add Complaint</span>
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body">

                <div class="table-responsive">
                    <table class="table table-bordered table-sm table-striped" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">Subject</th>
                                <th scope="col">Isi</th>
                                <th scope="col">Date Create</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1; ?>
                            <?php foreach ($laporans as $laporan) : ?>
                                <tr>
                                    <td scope="row"><?= $i++; ?></td>
                                    <td><?= $laporan['subject'] ?></td>
                                    <td><?= $laporan['isi'] ?></td>
                                    <td><?= $laporan['date_create'] ?>
                                    <td>
                                        <div class="row">
                                            <div class="col-auto mb-2">
                                                <?php
                                                $encrypter = \Config\Services::encrypter();
                                                $encryptedLaporanId = bin2hex($encrypter->encrypt(base64_encode($laporan['id'])));
                                                // $encryptedId = rawurlencode($encryptedLaporanId); // Encode untuk URL
                                                ?>
                                                <a href="<?= base_url('Edit-Report/' . 'Edit-' . $laporan['subject'] . '/' . $encryptedLaporanId) ?>" class="btn btn-primary btn-icon-split btn-sm text-gray-100" style="--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .75rem;">
                                                    <span class="icon icon-center bg-transparent">
                                                        <i class="fas fa-edit"></i>
                                                    </span>
                                                    <span class="text">Edit Post</span>
                                                </a>
                                            </div>
                                            <div class="col-auto mb-2">
                                                <?php
                                                $encrypter = \Config\Services::encrypter();
                                                $encryptedLaporanId = bin2hex($encrypter->encrypt(base64_encode($laporan['id'])));
                                                // $encryptedId = rawurlencode($encryptedLaporanId); // Encode untuk URL
                                                ?>
                                                <a href="<?= base_url('Post-Report/' . $laporan['subject'] . '/' . $encryptedLaporanId) ?>" class="btn btn-success btn-icon-split btn-sm text-gray-100" style="--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .75rem;">
                                                    <span class="icon icon-center bg-transparent">
                                                        <i class="fas fa-info-circle"></i>
                                                    </span>
                                                    <span class="text">Post Info</span>
                                                </a>
                                            </div>
                                            <div class="col-auto mb-2">
                                                <?php
                                                $encrypter = \Config\Services::encrypter();
                                                $encryptedLaporanId = bin2hex($encrypter->encrypt(base64_encode($laporan['id'])));
                                                // $encryptedId = rawurlencode($encryptedLaporanId); // Encode untuk URL
                                                ?>
                                                <a href="" onclick="confirmDelete('<?= ('Delete/' . $laporan['subject'] . '/' . $encryptedLaporanId) ?>')" class="btn btn-danger btn-icon-split btn-sm text-gray-100 " style="--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .75rem;">
                                                    <span class="icon icon-center bg-transparent">
                                                        <i class="fas fa-trash"></i>
                                                    </span>
                                                    <span class="text">Delete Post</span>
                                                </a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

<?= $this->endSection(); ?>