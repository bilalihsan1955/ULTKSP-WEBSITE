<?= $this->extend('layout/auth/header'); ?>
<?= $this->section('content'); ?>
<main
  class="flex flex-col md:flex-row items-center justify-center min-h-screen px-4 md:px-8 lg:px-24 py-8 gap-8 md:gap-[100px] overflow-hidden">

  <section class="bg-white rounded-md shadow-lg border p-6 w-full md:w-1/2">
    <!-- Alert section for errors -->
    <?php if ($errors = session()->getFlashdata('error')) : ?>
      <?php
      // Pastikan $errors adalah array
      $errors = is_array($errors) ? $errors : [$errors];
      ?>
      <?php foreach ($errors as $error) : ?>
        <div id="error-alert" class="bg-red-100 border text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
          <strong class="font-bold">Error!</strong><br>
          <span class="block sm:inline"><?= esc($error) ?></span>
          <span class="absolute top-0 bottom-0 right-0 px-4 py-3 cursor-pointer" onclick="this.parentElement.style.display='none'">
            <span class="material-icons text-red-500">close</span>
          </span>
        </div>
      <?php endforeach; ?>
    <?php endif; ?>
    <!-- Alert section for success -->
    <?php if ($success = session()->getFlashdata('success')) : ?>
      <?php
      // Pastikan $success adalah array
      $success = is_array($success) ? $success : [$success];
      ?>
      <?php foreach ($success as $message) : ?>
        <div id="success-alert" class="bg-green-100 border text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
          <strong class="font-bold">Success!</strong><br>
          <span class="block sm:inline"><?= esc($message) ?></span>
          <span class="absolute top-0 bottom-0 right-0 px-4 py-3 cursor-pointer" onclick="this.parentElement.style.display='none'">
            <span class="material-icons text-green-500">close</span>
          </span>
        </div>
      <?php endforeach; ?>
    <?php endif; ?>
    <header>
      <p class="text-black font-Poppins text-lg md:text-xl font-light mb-2">Welcome <span class="font-semibold">!</span></p>
      <p class="text-black font-Poppins text-2xl md:text-3xl font-medium">Lupa Kata Sandi<span
          class="font-semibold"> ?</span></p>
      </p>
      <p class="text-[#F98B88] text-lg font-Poppins font-bold mb-2">ULTKSP <span class="text-[#4F4F4F]">Vokasi UB</span>
    </header>
    <form action="<?= site_url('/process_forgot_password') ?>" method="post">
      <?= csrf_field() ?>
      <div class="mt-6">
        <label for="Email" class="block text-sm font-semibold font-Poppins text-gray-700">Email Akun</label>
        <input name="email" type="email" id="Email"
          class="w-full border border-gray-300 rounded-md px-4 py-2 mt-2 focus:outline-none focus:ring-2 focus:ring-[#F98B88]"
          placeholder="Masukkan email akun Anda" />
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