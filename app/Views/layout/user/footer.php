</div>
<!-- End of Main Content -->

<!-- Footer -->
<footer class="sticky-footer bg-dark-purple text-gray-100">
    <div class="container my-auto">
        <div class="copyright text-center my-auto">
            <span id="footer">
                <script>
                    document.getElementById('footer').textContent = `Copyright © ${new Date().getFullYear()} Unit Layanan Terpadu Kekerasan Seksual dan Perundungan`;
                </script>
            </span>
        </div>
    </div>
</footer>
<!-- End of Footer -->

</div>
<!-- End of Content Wrapper -->

</div>
<!-- End of Page Wrapper -->

<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>

<!-- Bootstrap core JavaScript-->
<script src="<?= base_url('vendor/jquery/jquery.min.js') ?>"></script>
<script src="<?= base_url('vendor/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>

<!-- Core plugin JavaScript-->
<script src="<?= base_url('vendor/jquery-easing/jquery.easing.min.js') ?>"></script>

<!-- Custom scripts for all pages-->
<script src="<?= base_url('assets/js/sb-admin-2.min.js') ?>"></script>

<!-- Page level plugins -->
<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/2.1.3/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.1.3/js/dataTables.bootstrap5.js"></script>

<!-- Page level custom scripts -->
<script src="<?= base_url('assets/js/demo/datatables-demo.js') ?>"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    function previewImage() {
        const file = document.querySelector('#foto').files[0];
        const imgPreview = document.querySelector('#imgPreview');

        const reader = new FileReader();
        reader.readAsDataURL(file);

        reader.onload = function(e) {
            imgPreview.src = e.target.result;
        }
    }
</script>

<script>
    document.getElementById('signout').addEventListener('click', function(e) {
        e.preventDefault(); // Mencegah aksi default link

        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Apakah Anda ingin keluar??",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, keluar!',
            customClass: {
                confirmButton: "btn btn-success",
                cancelButton: "btn btn-danger"
            }
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = '<?= base_url('/SignOut') ?>'; // Redirect ke URL logout
            }
        });
    });
</script>


<script>
    function confirmDelete(id) {
        event.preventDefault();
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Anda tidak dapat mengembalikan data ini!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, hapus!',
            customClass: {
                confirmButton: "btn btn-success",
                cancelButton: "btn btn-danger"
            }
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "<?= base_url('/'); ?>" + id;
            }
        })
    }
</script>
<script>
    function confirmDeleteComment(id) {
        event.preventDefault();
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Anda tidak dapat mengembalikan data ini!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, hapus!',
            customClass: {
                confirmButton: "btn btn-success",
                cancelButton: "btn btn-danger"
            }
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "<?= base_url('/Post-Report'); ?>" + id;
            }
        })
    }
</script>
<?php if (session()->getFlashdata('success')) : ?>
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Sukses',
            text: '<?= session()->getFlashdata('success'); ?>'
        });
    </script>
<?php endif; ?>

<?php if (session()->getFlashdata('error')) : ?>
    <script>
        Swal.fire({
            icon: 'warning',
            title: 'Error',
            text: '<?= session()->getFlashdata('error'); ?>'
        });
    </script>
<?php endif; ?>

<script>
    document.querySelector('form').addEventListener('submit', function(event) {
        event.preventDefault(); // Mencegah form di-submit langsung

        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Anda akan mengirimkan laporan ini!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, kirim!',
            cancelButtonText: 'Batal',
            customClass: {
                confirmButton: "btn btn-success",
                cancelButton: "btn btn-danger"
            }
        }).then((result) => {
            if (result.isConfirmed) {
                // Jika user menekan tombol "Ya, kirim", submit form
                this.submit();
            }
        });
    });
</script>

<script>
    document.getElementById('edit-profile-form').addEventListener('submit', function(event) {
        event.preventDefault(); // Mencegah form di-submit langsung

        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Perubahan pada profil Anda akan disimpan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, simpan!',
            cancelButtonText: 'Batal',
            customClass: {
                confirmButton: "btn btn-success",
                cancelButton: "btn btn-danger"
            }
        }).then((result) => {
            if (result.isConfirmed) {
                // Jika user menekan tombol "Ya, simpan", submit form
                this.submit();
            }
        });
    });
</script>

<script>
    document.getElementById('edit-report').addEventListener('submit', function(event) {
        event.preventDefault(); // Mencegah form di-submit langsung

        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Perubahan pada laporan Anda akan disimpan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, simpan!',
            cancelButtonText: 'Batal',
            customClass: {
                confirmButton: "btn btn-success",
                cancelButton: "btn btn-danger"
            }
        }).then((result) => {
            if (result.isConfirmed) {
                // Jika user menekan tombol "Ya, simpan", submit form
                this.submit();
            }
        });
    });
</script>

<script>
    document.getElementById('comment-form').addEventListener('submit', function(event) {
        event.preventDefault(); // Mencegah form di-submit langsung

        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Komentar Anda akan dikirim!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, kirim!',
            cancelButtonText: 'Batal',
            customClass: {
                confirmButton: "btn btn-success",
                cancelButton: "btn btn-danger"
            }
        }).then((result) => {
            if (result.isConfirmed) {
                // Jika user menekan tombol "Ya, simpan", submit form
                this.submit();
            }
        });
    });
</script>


</body>

</body>

</html>