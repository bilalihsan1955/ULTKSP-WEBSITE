<?= $this->extend('layout/auth/header'); ?>
<?= $this->section('content'); ?>
<main
  class="flex flex-col md:flex-row items-center justify-center min-h-screen px-4 md:px-8 lg:px-24 py-8 gap-8 md:gap-[100px] overflow-hidden">

  <section class="bg-white rounded-md shadow-lg border p-6 w-full md:w-1/2">
    <!-- Alert section for errors -->
    <?php if (session()->getFlashdata('error')) : ?>
        <?php foreach (session()->getFlashdata('error') as $error) : ?>
          <div id="error-alert" class="bg-red-100 border text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <strong class="font-bold">Error!</strong><br>
            <span class="block sm:inline"><?= esc($error) ?></span>
            <span class="absolute top-0 bottom-0 right-0 px-4 py-3 cursor-pointer" onclick="this.parentElement.style.display='none'">
              <span class="material-icons text-red-500">close</span>
            </span>
          </div>
        <?php endforeach; ?>
    <?php endif; ?>
    <header>
      <p class="text-black font-Poppins text-lg md:text-xl font-light mb-2">Welcome <span class="font-semibold">!</span></p>
      <p class="text-black font-Poppins text-2xl md:text-3xl font-medium">Reset Password for</p>
      <p class="text-[#F98B88] text-lg font-Poppins font-bold mb-2">ULTKSP <span class="text-[#4F4F4F]">Vokasi UB</span>
    </header>
    <form action="<?= site_url('/process_reset_password') ?>" method="post">
      <?= csrf_field() ?>
      <input type="hidden" name="token" value="<?= $token ?>">
      <div class="md:mb-[15px] mt-2">
          <label for="password" class="block text-sm font-semibold text-gray-700">New Password</label>
          <div class="relative">
            <input type="password" id="password" name="password" class="w-full border border-gray-300 rounded-md px-4 py-2 pr-10 mt-2 focus:outline-none focus:ring-2 focus:ring-[#F98B88]" placeholder="Masukkan password baru" />
            <button type="button" id="togglePassword" class="absolute right-3 top-4 text-gray-600">
              <span class="material-icons" id="eyeIcon">visibility</span>
            </button>
          </div>
        </div>
        
        <div class="md:mb-[15px] mt-2">
          <label for="confirm_password" class="block text-sm font-semibold text-gray-700">Confirm New Password</label>
          <div class="relative">
            <input type="password" id="confirm_password" name="confirm_password" class="w-full border border-gray-300 rounded-md px-4 py-2 pr-10 mt-2 focus:outline-none focus:ring-2 focus:ring-[#F98B88]" placeholder="Konfirmasi password baru Anda" />
            <button type="button" id="toggleConfirmPassword" class="absolute right-3 top-4 text-gray-600">
              <span class="material-icons" id="eyeIconConfirm">visibility</span>
            </button>
          </div>
        </div>
      <button type="submit"
        class="w-full bg-[#F98B88] text-white font-Poppins font-semibold rounded-md mt-6 hover:bg-[#f66d6a] hover:scale-95 transition duration-300 py-2">Reset Kata Sandi</button>
    </form>

    <footer class="mt-8 text-center">
      <p class="text-gray-600 text-sm font-Poppins">
        Sudah ingat kata sandi Anda?
        <a href="<?= base_url('SignIn') ?>" class="text-[#F98B88] font-semibold hover:underline">Sign In</a>
      </p>
    </footer>
  </section>
</main>

<?= $this->endsection(); ?>