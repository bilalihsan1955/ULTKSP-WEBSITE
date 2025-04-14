<?= $this->extend('layout/auth/header'); ?>
<?= $this->section('content'); ?>
<main class="flex flex-col md:flex-row items-center justify-center min-h-screen px-4 md:px-8 lg:px-24 py-8 gap-8 md:gap-[100px]">
  <section class="md:w-1/2 flex flex-col items-center md:items-start justify-center md:order-1 mb-6">
    <header class="text-center md:text-right">
      <h1 class="text-[#F98B88] text-center md:text-left text-3xl lg:text-[52px] md:text-4xl font-Poppins font-bold tracking-wide">ULTKSP <span class="text-[#4F4F4F]">VOKASI</span></h1>
      <p class="text-[#7E7E7E] text-center md:text-left text-sm font-Poppins mt-2 max-w-[600px] md:text-sm lg:text-md">Pastikan setiap suara terdengar dan tindakan ditangani dengan tepat untuk menciptakan lingkungan aman dan nyaman di Vokasi UB</p>
    </header>
  </section>

  <section class="bg-white rounded-md shadow-lg border p-6 w-full md:w-1/2 md:order-2">
    <!-- Alert section for errors -->
    <?php if ($errors = session()->getFlashdata('error')) : ?>
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

    <header>
      <p class="text-black font-Poppins text-lg md:text-xl font-light mb-2">Welcome <span class="font-semibold">!</span></p>
      <p class="text-black font-Poppins text-2xl md:text-3xl font-medium">Sign up to</p>
      <p class="text-[#F98B88] text-lg font-Poppins font-bold">ULTKSP <span class="text-[#4F4F4F]">Vokasi UB</span></p>
    </header>

    <form class="mt-[15px] md:mt-[20px] lg:mt-[26px]" action="<?= base_url('Register') ?>" method="post">
    <?= csrf_field() ?>
      <div class="md:mb-[15px] mt-2">
        <label for="nama" class="block text-sm font-Poppins font-semibold text-gray-700">Nama</label>
        <input type="text" id="nama" name="nama" class="w-full border border-gray-300 rounded-md px-4 py-[4px] md:py-2 mt-1 focus:outline-none focus:ring-2 focus:ring-[#F98B88]" placeholder="Masukkan Nama Lengkap Anda" />
      </div>
      <div class="md:mb-[15px] mt-2">
        <label for="username" class="block font-Poppins text-sm font-semibold text-gray-700">Username</label>
        <input type="text" id="username" name="username" class="w-full border border-gray-300 rounded-md px-4 py-[4px] md:py-2 mt-1 focus:outline-none focus:ring-2 focus:ring-[#F98B88]" placeholder="Masukkan username Anda" />
      </div>
      <div class="md:mb-[15px] mt-2">
        <label for="email" class="block text-sm font-Poppins font-semibold text-gray-700">Email</label>
        <input type="email" id="email" name="email" class="w-full border border-gray-300 rounded-md px-4 py-[4px] md:py-2 mt-1 focus:outline-none focus:ring-2 focus:ring-[#F98B88]" placeholder="Gunakan email @student.ub.ac.id" />
      </div>
      <div class="md:mb-[15px] mt-2">
        <label for="password" class="block text-sm font-semibold text-gray-700">Password</label>
        <div class="relative">
          <input type="password" id="password" name="password" class="w-full border border-gray-300 rounded-md px-4 py-2 pr-10 mt-2 focus:outline-none focus:ring-2 focus:ring-[#F98B88]" placeholder="Masukkan password" />
          <button type="button" id="togglePassword" class="absolute right-3 top-4 text-gray-600">
            <span class="material-icons" id="eyeIcon">visibility</span>
          </button>
        </div>
      </div>
      
      <div class="md:mb-[15px] mt-2">
        <label for="confirm_password" class="block text-sm font-semibold text-gray-700">Confirm Password</label>
        <div class="relative">
          <input type="password" id="confirm_password" name="confirm_password" class="w-full border border-gray-300 rounded-md px-4 py-2 pr-10 mt-2 focus:outline-none focus:ring-2 focus:ring-[#F98B88]" placeholder="Konfirmasi password Anda" />
          <button type="button" id="toggleConfirmPassword" class="absolute right-3 top-4 text-gray-600">
            <span class="material-icons" id="eyeIconConfirm">visibility</span>
          </button>
        </div>
      </div>
        <button type="submit" class="w-full h-10 bg-[#F98B88] text-white font-Poppins font-semibold rounded-md mt-6 hover:bg-[#f66d6a] hover:scale-95 transition duration-300 md:h-[50px]">Register</button>
    </form>

    <footer class="mt-8 text-center">
      <p class="text-gray-600 md:text-sm font-Poppins text-[15px]">
        Sudah punya akun ?
        <a href="<?= base_url('SignIn') ?>" class="text-[#F98B88] font-semibold hover:underline">Masuk</a>
      </p>
    </footer>
    </footer>
  </section>
</main>
<?= $this->endsection(); ?>