<?= $this->extend('layout/admin/header'); ?>
<?= $this->section('content'); ?>

<!-- Begin Page Content -->
<div class="container-fluid px-4">

    <!-- Page Heading -->
    <div class="row align-items-center m-5 justify-content-center font-weight-bold py-3 ">
        <h1 class="font-weight-bold text-gray-800" style="text-align:center">Report Tables Data</h1>
    </div>

    <!-- DataTales Example -->
    <div class="card shadow mb-5">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-purple">DataTables Example</h6>
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
                    <!-- <tfoot>
                        <tr>
                            <th>Name</th>
                            <th>Position</th>
                            <th>Office</th>
                            <th>Age</th>
                            <th>Start date</th>
                            <th>Salary</th>
                        </tr>
                    </tfoot> -->
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
                                            <a href="<?= base_url('Admin/Post-Report/' . $laporan['subject'] . '/' . $encryptedLaporanId) ?>" class="btn btn-success btn-icon-split btn-sm text-gray-100" style="--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .75rem;">
                                                <span class="icon icon-center bg-transparent">
                                                    <i class="fas fa-info-circle"></i>
                                                </span>
                                                <span class="text">Post Info</span>
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
<!-- /.container-fluid -->
<?= $this->endsection(); ?>