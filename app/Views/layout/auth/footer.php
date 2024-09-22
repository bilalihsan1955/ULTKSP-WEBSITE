<?= $this->renderSection('content'); ?>
    <!-- Bootstrap core JavaScript-->
    <script src="<?= base_url('vendor/jquery/jquery.min.js') ?>"></script>
    <script src="<?= base_url('vendor/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>

    <!-- Core plugin JavaScript-->
    <script src="<?= base_url('vendor/jquery-easing/jquery.easing.min.js') ?>"></script>

    <!-- Custom scripts for all pages-->
    <script src="<?= base_url('assets/js/sb-admin-2.min.js') ?>"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

    <script>
        function removeError() {
            document.getElementById("error-label").style.display = "none";
            document.getElementById("exampleInputemail").classList.remove("border-danger");
        }

        function removeErrorPass() {
            document.getElementById("error-label-pass").style.display = "none";
            document.getElementById("exampleInputPassword").classList.remove("border-danger");
            document.getElementById("Inputconfirm_password").classList.remove("border-danger");
        }

        function removeErrorname() {
            document.getElementById("error-label-name").style.display = "none";
            document.getElementById("exampleInputname").classList.remove("border-danger");
        }
    </script>
    
</body>

</html>