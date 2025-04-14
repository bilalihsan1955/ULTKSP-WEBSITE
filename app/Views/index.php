<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>ULTKSP UB</title>
  <!-- icon tab -->
  <link rel="icon" type="image/png" href="<?= base_url('Assets/images/logo vokasi UB vertikal-01 - Crop.png') ?>">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
  <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet" />
  <link href="<?= base_url('/css/style.css') ?>" rel="stylesheet">
</head>

<body class="bg-[#f5f5f5]">
  <header class="flex justify-center w-full fixed top-7 md:top-10 z-50">
    <nav class="bg-white shadow-md border border-gray-200 max-w-[625px] rounded-[40px] md:rounded-full px-4 mx-auto">
      <div class="flex justify-between items-center px-2 lg:px-0 py-2 gap-10">
        <div class="flex items-center space-x-2">
          <img src="<?= base_url('/Assets/images/LogoUB.png') ?>" alt="ULTKSP Logo" class="w-[48px]" />
          <div class="leading-tight">
            <p class="font-bold text-[20px] lg:text-[23px] font-poppins text-[#F98B88]">ULTKSP</p>
            <p class="text-[#222222] text-[14px] lg:text-[16px] font-poppins font-medium">Vokasi UB</p>
          </div>
        </div>
        <div class="hidden md:flex space-x-6 items-center">
          <a href="#about" class="text-gray-700 text-base lg:text-lg font-semibold hover:text-[#F98B88]">About</a>
          <a href="#Services" class="text-gray-700 text-base lg:text-lg font-semibold hover:text-[#F98B88]">Services</a>
          <a href="#modul" class="text-gray-700 text-base lg:text-lg font-semibold hover:text-[#F98B88]">Modul</a>
          <a href="<?= base_url('/SignIn') ?>" class="bg-[#F98B88] text-white px-4 py-2 rounded-full hover:bg-pink-600">Sign In</a>
        </div>
        <button class="md:hidden py-4 px-6 rounded-full text-gray-700 hover:text-[#F98B88] text-2xl focus:outline-none tracking-tight" id="hamburger">
          <i class="fas fa-bars" style="font-size: 35px"></i>
        </button>
      </div>
      <div id="menu-main" class="flex md:hidden flex-col items-center space-y-6 py-6">
        <a href="#about" class="text-gray-700 text-base lg:text-lg font-semibold hover:text-[#F98B88]">About</a>
        <a href="#Services" class="text-gray-700 text-base lg:text-lg font-semibold hover:text-[#F98B88]">Services</a>
        <a href="#modul" class="text-gray-700 text-base lg:text-lg font-semibold hover:text-[#F98B88]">Modul</a>
        <a href="<?= base_url('/SignIn') ?>" class="bg-[#F98B88] text-white px-4 py-2 rounded-full hover:bg-pink-600">Sign In</a>
      </div>
    </nav>
  </header>

  <div class="relative z-0">
    <div class="circlePosition w-[120px] h-[60px] md:w-[367px] md:h-[191px] bg-[#F98B88] rounded-[100%] absolute z-1 blur-[160px] right-[5px] md:right-[2px]"></div>
    <div class="circlePosition w-[120px] h-[60px] md:w-[367px] md:h-[191px] bg-[#F98B88] rounded-[100%] absolute z-1 blur-[220px] md:left-[-150px] bottom-[-120px]"></div>
  </div>

  <main>
    <section id="hero" class="text-center py-16 mt-[80px] md:py-28 lg:py-40 mx-5 md:mx-12 lg:mx-24">
      <div class="container mx-auto">
        <div class="mb-5 md:mt-[20px] inline-block bg-[#F5F5F5] border border-solid border-gray-300 py-1 px-3 rounded-full">
          <div class="flex items-center space-x-2" data-aos="fade-up">
            <img src="<?= base_url('/Assets/images/fire.png') ?>" alt="Fire Icon" class="w-6 h-6" />
            <span class="text-[#F98B88] font-poppins font-semibold text-lg">Welcome</span>
          </div>
        </div>
        <h1 class="text-center text-[#222222] text-2xl md:text-4xl lg:text-5xl font-bold font-poppins leading-snug" data-aos="fade-up">Unit Layanan Terpadu Kekerasan Seksual dan Perundungan</h1>
        <p class="text-[#444444] text-center font-poppins text-base md:text-lg lg:text-xl mt-[20px] md:mt-[30px] leading-relaxed" data-aos="fade-up">Memastikan setiap suara didengar dan setiap tindakan ditangani dengan tepat</p>
        <a
          href="#"
          data-aos="fade-up"
          class="inline-flex items-center bg-[#FFD1D0] text-[#FF4945] py-3 px-6 rounded-full text-lg hover:bg-pink-600 transition duration-300 hover:scale-95 tracking-tight mt-[30px] md:mt-[50px] lg:mt-[80px] hover:text-white hover:shadow-md">
          Laporkan
          <span class="ml-2 flex items-center justify-center w-6 h-6 bg-[#FF4945] text-white rounded-full text-center">
            <i class="fas fa-arrow-right" style="font-size: 12px"></i>
          </span>
        </a>
      </div>
    </section>

    <section id="about" class="py-16 md:py-24 lg:py-32 my-[40px] mx-[20px] md:my-[40px] md:mx-[52px] lg:my-[56px] lg:mx-[72px]">
      <div class="container mx-auto text-center px-4 lg:px-0">
        <h2 class="text-2xl md:text-[40px] lg:text-[56px] font-bold font-poppins text-[#F98B88] mb-6 md:mb-10 lg:mb-16" data-aos="fade-up">Apa Itu ULTKSP</h2>
        <p class="text-gray-700 max-w-[1300px] mx-auto font-poppins text-sm md:text-lg lg:text-[20px]" data-aos="fade-up">
          Unit Layanan Terpadu Kekerasan Seksual dan Perundungan yang selanjutnya disingkat ULTKSP adalah unit yang berfungsi sebagai penyelenggara pelayanan terpadu korban Kekerasan Seksual dan/atau Perundungan yang dikelola oleh UB dan
          dilaksanakan oleh Fakultas, Pascasarjana, dan Program Studi Di Luar Kampus Utama. Unit ini dibentuk sebagai upaya Fakultas Vokasi untuk memfasilitasi dan melayani masyarakat kampus khususnya di lingkungan Fakultas Vokasi UB
          (mahasiswa, tenaga kependidikan dan tenaga pendidik) terkait dengan Tindakan kekerasan seksual dan perundungan.
        </p>
      </div>
      <div class="container mx-auto mt-8 lg:mt-12 px-4 lg:px-0" data-aos="fade-up">
        <div class="relative w-full pb-[56.25%] rounded-lg shadow-lg overflow-hidden">
          <video
            class="absolute top-0 left-0 w-full h-full rounded-lg"
            autoplay
            loop
            muted
          >
            <source src="<?= base_url('Assets/videos/Seminar dan ULTKSP Fakultas Vokasi UB.mp4') ?>" type="video/mp4">
            Your browser does not support the video tag.
          </video>
        </div>
      </div>
    </section>

    </section>

    <section
      id="Services"
      class="py-16 mx-[20px] md:mx-[52px] lg:mx-[72px] my-[40px] lg:my-[56px] rounded-lg md:rounded-2xl py-[30px] px-[20px] md:py-[40px] md:px-[20px] lg:py-[56px] lg:px-[72px]"
      style="background: linear-gradient(260deg, #ffaeac 9.6%, #f57373 83.92%)">
      <div class="container mx-auto text-center px-4 lg:px-0">
        <div class="mb-8 md:mb-10 lg:mb-16 text-center" data-aos="fade-up">
          <h2 class="text-3xl font-poppins md:text-4xl lg:text-5xl font-bold text-white mb-4">Layanan Kami</h2>
          <div class="border border-solid border-white w-24 mx-auto"></div>
        </div>

        <div class="grid gap-8 md:grid-cols-2 mt-[40px]">
          <article class="bg-white p-6 rounded-lg shadow-md text-left lg:text-left" data-aos="fade-up">
            <h3 class="text-base md:text-lg lg:text-2xl font-semibold font-poppins text-[#4F4F4F] mb-4">Pengaduan kekerasan seksual dan perundungan</h3>
            <p class="text-gray-600 font-poppins mb-6 md:mb-8 lg:mb-10">Jika Anda atau seseorang di sekitar Anda mengalami kekerasan seksual atau perundungan, kami siap mendengarkan dan membantu Anda. Laporkan sekarang</p>
            <a href="#" class="inline-block bg-[#F98B88] text-white font-poppins test-sm py-2 px-4 rounded-lg transition duration-300 hover:bg-pink-600 hover:scale-95 hover:shadow-md">Laporkan <i class="fas fa-arrow-right ml-2"></i></a>
          </article>
          <article class="bg-white p-6 rounded-lg shadow-md text-left lg:text-left" data-aos="fade-up">
            <h3 class="text-base md:text-lg lg:text-2xl font-semibold font-poppins text-[#4F4F4F] mb-4">Lapor Bu! Langkah Awal Mengatasi Masalahmu</h3>
            <p class="text-gray-600 font-poppins mb-6 md:mb-8 lg:mb-10">
              Program inovatif ini menyediakan fasilitas bagi mahasiswa, dosen, dan tenaga pendidik untuk berbagai masalah terkait akademik, pribadi, keluarga, sosial, karier, bakat minat, dan masalah lainnya dengan tim kami.
            </p>
            <a href="#" class="inline-block bg-[#F98B88] text-white font-poppins test-sm py-2 px-4 rounded-lg transition duration-300 hover:bg-pink-600 hover:scale-95 hover:shadow-md">Laporkan <i class="fas fa-arrow-right ml-2"></i></a>
          </article>
        </div>
      </div>
    </section>
  </main>

  <section id="modul">
    <aside class="py-16 lg:py-32 w-full flex flex-col lg:flex-row items-center justify-center bg-[#F98B88]">
      <div class="w-full lg:w-1/2 flex justify-center mb-6 lg:mb-0" data-aos="fade-up">
        <img src="<?= base_url('/Assets/images/modul.png') ?>" alt="Module" class="w-[150px] md:w-[200px]" />
      </div>
      <div class="w-full lg:w-1/2 text-center lg:text-left px-4 lg:px-8" data-aos="fade-up">
        <h2 class="text-2xl md:text-3xl lg:text-4xl font-bold text-white mb-4 font-poppins">Unduh Modul</h2>
        <p class="text-sm md:text-base lg:text-lg text-white mb-6 font-poppins">
          Modul Pembelajaran Tentang Pencegahan Dan Penanganan Kekerasan Seksual Di Lingkungan Perguruan Tinggi Bagi Mahasiswa Fakultas Vokasi Universitas Brawijaya Dapat Diunduh.
        </p>
        <a href="https://drive.google.com/drive/folders/1-iQVOGOJ0Tp6gaLjDhYU7Kfe5WyqMYSh?usp=sharing" target="_blank" class="inline-block bg-white text-[#F98B88] py-3 px-6 rounded-lg hover:bg-gray-100 hover:text-[#F98B88] font-poppins hover:scale-95 transition duration-300"> Download <i class="ml-2 fas fa-download"></i> </a>
      </div>
    </aside>
  </section>

  <footer class="bg-[#f5f5f5] mx-4 md:mx-[52px] lg:mx-[72px] my-[20px] lg:my-[30px]">
    <div class="container mx-auto">
      <div class="flex items-center space-x-4">
        <img src="<?= base_url('/Assets/images/LogoUB.png') ?>" alt="ULTKSP Logo" class="w-[48px] lg:w-[60px]" />
        <div class="leading-tight">
          <p class="font-bold text-[20px] lg:text-[23px] text-[#F98B88]">ULTKSP</p>
          <p class="text-[#222222] text-[14px] lg:text-[16px] font-medium">Vokasi UB</p>
        </div>
      </div>

      <p class="text-[#5f5f5f] mt-4 text-sm lg:text-base max-w-[670px]">Mari bersama-sama menjaga lingkungan yang aman dan peduli bagi seluruh warga vokasi UB.</p>

      <div class="border border-solid border-gray-300 w-full mt-4"></div>

      <div class="flex flex-col lg:flex-row justify-between mt-4 space-y-2 lg:space-y-0 lg:items-center">
        <p class="text-[#555555] text-sm lg:text-base">Developed by <span class="text-[#fcc153] font-semibold">Provoks</span> Community</p>
        <p class="text-[#555555] text-sm lg:text-base">Copyright 2024. Tim ULTKSP Vokasi UB. All Rights Reserved.</p>
      </div>
    </div>
  </footer>

  <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
  <script>
    AOS.init();
    const hamburger = document.getElementById('hamburger');
    const navbar = document.getElementById('menu-main');
    hamburger.addEventListener('click', function() {
      navbar.classList.toggle('hidden');
    });
  </script>
</body>

</html>