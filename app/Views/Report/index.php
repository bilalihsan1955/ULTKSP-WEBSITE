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
            <h1 class="font-weight-bold text-gray-800" style="text-align:center">Add New Complain Report</h1>
        </div>
        <!-- DataTales Example -->
        <div class="card shadow">
            <div class="card-header py-3">
                <div class="row align-items-center justify-content-center font-weight-bold">
                    <div class="col">
                        <h6 class="m-0 text-purple font-weight-bold ">Please Fill The Form Correctly</h6>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <form action="<?= base_url('Add-Report') ?>" method="post" enctype="multipart/form-data">
                    <?= csrf_field() ?>
                    <div class="form-group row">
                        <div class="col-sm-12 mb-3 mb-sm-0">
                            <label for="subject">Subject</label>
                            <input type="text" class="form-control form-control-sm" id="subject" name="subject" placeholder="Your Subject" required>
                        </div>
                    </div>
                    <div class="form-group row mt-4">
                        <div class="col-sm-12 mb-3 mb-sm-0">
                            <label for="editor">Contents</label>
                            <textarea class="form-control" id="editor" name="editor" placeholder="Add report content" required id="floatingTextarea"></textarea>
                        </div>
                    </div>
                    <div class="form-group row mt-4">
                        <div class="col-sm-12 mb-3 mb-sm-0">
                            <label for="photo">Photo</label>
                            <input type="file" class="form-control form-control-sm" id="photo" name="photo">
                        </div>
                    </div>
                    <button type="submit" class="btn-light-purple btn-block btn-sm">Send Report</button>
                </form>
            </div>
        </div>
    </div>


    <?= $this->endSection(); ?>