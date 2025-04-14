<?= $this->renderSection('content'); ?>
</body>
<script>
      // Function to close the alert
      function closeAlert() {
        const alert = document.getElementById('error-alert');
        alert.style.display = 'none';
      }
    
      // Set a timeout to automatically close the alert after 5 seconds
      setTimeout(closeAlert, 5000);
</script>
<script>
    const togglePassword = document.getElementById('togglePassword');
    const passwordInput = document.getElementById('password');
    const eyeIcon = document.getElementById('eyeIcon');

    const toggleConfirmPassword = document.getElementById('toggleConfirmPassword');
    const confirmPasswordInput = document.getElementById('confirm_password');
    const eyeIconConfirm = document.getElementById('eyeIconConfirm');

    togglePassword.addEventListener('click', () => {
        // Toggle the type attribute for password input
        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);

        // Toggle the eye icon
        eyeIcon.textContent = type === 'text' ? 'visibility_off' : 'visibility';
    });

    toggleConfirmPassword.addEventListener('click', () => {
        // Toggle the type attribute for confirm password input
        const type = confirmPasswordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        confirmPasswordInput.setAttribute('type', type);

        // Toggle the eye icon
        eyeIconConfirm.textContent = type === 'text' ? 'visibility_off' : 'visibility';
    });
</script>
</html>