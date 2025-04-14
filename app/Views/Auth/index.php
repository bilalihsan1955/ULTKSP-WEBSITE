<?= $this->extend('layout/auth/header'); ?>
<?= $this->section('content'); ?>
<main class="flex flex-col md:flex-row items-center justify-center min-h-screen px-4 md:px-8 lg:px-24 py-6 gap-8 md:gap-[100px]">
  <section class="md:w-1/2 flex flex-col items-center md:items-start justify-center md:order-2 mb-6">
    <header class="text-center md:text-right">
      <h1 class="text-[#F98B88] text-3xl lg:text-[52px] md:text-4xl font-Poppins font-bold tracking-wide">ULTKSP <span class="text-[#4F4F4F]">VOKASI</span></h1>
      <p class="text-[#7E7E7E] text-sm font-Poppins mt-2 max-w-[600px] md:text-sm lg:text-sm">Pastikan setiap suara terdengar dan tindakan ditangani dengan tepat untuk menciptakan lingkungan aman dan nyaman di Vokasi UB</p>
    </header>
  </section>

  <section class="bg-white rounded-md shadow-lg border p-6 w-full md:w-1/2">

    <!-- Alert section for errors -->
    <?php if (session()->getFlashdata('error')) : ?>
      <div id="error-alert" class="bg-red-100 border  text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
        <strong class="font-bold">Error!</strong><br>
        <span class="block sm:inline"><?= session()->getFlashdata('error') ?></span>
        <span class="absolute top-0 bottom-0 right-0 px-4 py-3 cursor-pointer" onclick="closeAlert()">
          <span class="material-icons text-red-500">close</span>
        </span>
      </div>
    <?php endif; ?>

    <?php if ($message = session()->getFlashdata('message')) : ?>
      <div id="message-alert" class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded relative mb-4" role="alert">
        <strong class="font-bold">Success!</strong><br>
        <span class="block sm:inline"><?= esc($message) ?></span>
        <span class="absolute top-0 bottom-0 right-0 px-4 py-3 cursor-pointer" onclick="this.parentElement.style.display='none'">
          <span class="material-icons text-blue-500">close</span>
        </span>
      </div>
    <?php endif; ?>

    <header>
      <p class="text-black font-Poppins text-lg md:text-xl font-light mb-2">Welcome <span class="font-semibold">!</span></p>
      <p class="text-black font-Poppins text-2xl md:text-3xl font-medium">Sign In to</p>
      <p class="text-[#F98B88] text-lg font-Poppins font-bold">ULTKSP <span class="text-[#4F4F4F]">Vokasi UB</span></p>
    </header>

    <form action="<?= site_url('/SignIn'); ?>" method="post">
      <?= csrf_field() ?>
      <div class="mt-6">
        <label for="username" class="block text-sm font-semibold font-Poppins text-gray-700">Username atau Email</label>
        <input type="text" id="username" name="username" class="w-full border border-gray-300 rounded-md px-4 py-2 mt-2 focus:outline-none focus:ring-2 focus:ring-[#F98B88]" placeholder="Masukkan username atau email Anda" />
      </div>

      <div class="mt-6">
        <label for="password" class="block text-sm font-semibold text-gray-700">Password</label>
        <div class="relative">
          <input type="password" id="password" name="password" class="w-full border border-gray-300 rounded-md px-4 py-2 pr-10 mt-2 focus:outline-none focus:ring-2 focus:ring-[#F98B88]" placeholder="Masukkan password" />
          <button type="button" id="togglePassword" class="absolute right-3 top-4 text-gray-600">
            <span class="material-icons" id="eyeIcon">visibility</span>
          </button>
        </div>
      </div>

      <div class="flex items-center justify-between mt-4">
        <label class="flex items-center text-gray-700 text-sm">
          <input id="remember-me" name="remember-me" type="checkbox" class="mr-2" />
          Remember me
        </label>
        <a href="<?= base_url('forgot-password') ?>" class="text-[#4c4c4c] text-sm hover:text-[#F98B88] transition">Forgot Password?</a>
      </div>

      <button type="submit" class="w-full bg-[#F98B88] text-white font-Poppins font-semibold rounded-md mt-6 hover:bg-[#f66d6a] hover:scale-95 transition duration-300 py-2">Masuk</button>
    </form>

    <footer class="mt-8 text-center">
      <p class="text-gray-600 text-sm font-Poppins">
        Belum punya Akun ?
        <a href="<?= base_url('Register') ?>" class="text-[#F98B88] font-semibold hover:underline">Daftar</a>
      </p>
    </footer>
  </section>
</main>

<?= $this->endsection(); ?>