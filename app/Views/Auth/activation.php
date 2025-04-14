<?= $this->extend('layout/auth/header'); ?>
<?= $this->section('content'); ?>
<main class="flex flex-col md:flex-row items-center justify-center min-h-screen px-4 md:px-8 lg:px-24 py-8 gap-8 md:gap-[100px] overflow-hidden">

  <section class="bg-white rounded-md shadow-lg border p-6 w-full md:w-1/2">
    <header>
      <p class="text-black font-Poppins text-lg md:text-xl font-light mb-2">Welcome <span class="font-semibold">!</span></p>
      <p class="text-black font-Poppins text-xl md:text-1xl font-medium">Aktivasi Akun Pengguna</p>
      <p class="text-[#F98B88] text-lg font-Poppins font-bold mb-2">ULTKSP <span class="text-[#4F4F4F]">Vokasi UB</span>
    </header>
    <div class="w-full mt-6 text-center">
      <hr class="mb-4 ">
      <p class="text-black font-Poppins text-center text-2xl md:text-3xl font-medium"><?= $message ?></p>
      <a href="<?= base_url('/SignIn') ?>">
        <button
          class="w-full bg-[#F98B88] text-white font-Poppins font-semibold rounded-md mt-6 hover:bg-[#f66d6a] hover:scale-95 transition duration-300 py-2">Masuk Sekarang</button>
      </a>
    </div>
  </section>
</main>

<?= $this->endsection(); ?>