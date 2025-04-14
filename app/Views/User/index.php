<?= $this->extend('layout/user/home/header'); ?>

<?= $this->section('content'); ?>

<!-- Profile Section -->
<main class="flex-1 p-6 sm:ml-20">
    <div class="bg-white rounded-lg shadow-sm">
        <!-- Gradient Banner -->
        <div class="bg-gradient-to-r from-[#F98B88] to-[#FFC6C4] h-16 w-full rounded-t-lg"></div>
        <div class="p-8 md:p-12">
            <div
                class="flex flex-col md:flex-row lg:flex-row items-center lg:justify-between w-full text-center lg:text-left">
                <!-- Konten dan Tombol -->
                <div
                    class="flex flex-col md:flex-col lg:flex-row items-center md:items-start lg:w-full lg:justify-between md:mt-0 lg:mt-0">
                    <div class="flex flex-col items-center md:items-start lg:items-start">
                        <!-- Salam dan Info Hari -->
                        <h1 class="text-xl font-semibold text-gray-800">
                            <span id="salam"></span>👋, <?= ucwords($user['username']) ?>
                        </h1>
                        <p class="mt-2 text-sm text-gray-500">
                            Sekarang Hari
                            <span id="hari"></span>,
                            <span id="tanggal"></span>
                            <span id="bulan"></span>
                            <span id="tahun"></span>
                        </p>
                    </div>

                    <!-- Tombol Buat Laporan Baru -->
                    <a href="<?= base_url('Dashboard/Add-Report') ?>"
                        class="mt-4 lg:mt-0 md:mt-6 bg-[#F98B88] text-white px-4 py-2 rounded-md hover:bg-[#e07574] focus:bg-[#c9605e] transition duration-300 flex items-center space-x-2 text-xs md:text-sm">
                        <span>Buat Laporan Baru</span>
                        <span class="material-symbols-rounded">post_add</span>
                    </a>
                </div>
            </div>
        </div>
        <div class="p-8 pt-0 pb-14 md:p-12 md:pt-0">
            <div class="flex flex-col items-center pb-8">
                <h2 class="text-4xl font-bold pt-8 pb-2 text-center mb-2">Laporan Kamu</h2>
                <p class="text-gray-600 text-sm text-center mb-8">
                    Menampilkan semua laporan yang telah kamu buat.
                    <span class="font-semibold">Jangan ragu untuk berbagi!</span>
                </p>
            </div>

            <!-- Search and Sort Section -->
            <div class="flex flex-col md:flex-row items-center mb-6 pb-4">
                <div class="relative flex-grow mb-4 md:mb-0">
                    <input type="text" id="searchInput" placeholder="Cari berdasarkan judul"
                        class="border border-gray-300 rounded-md py-2 px-10 w-full focus:outline-none focus:ring-2 focus:ring-[#fba7a6]"
                        onkeyup="filterCards()">
                    <span class="absolute left-3 top-2.5 text-gray-400">
                        <span class="material-icons">search</span>
                    </span>
                </div>

                <div class="relative ml-0 md:ml-4">
                    <button id="dropdownSortBtn" class="w-full border-2 bg-gray-100 text-gray-700 py-2 px-4 rounded-md flex items-center justify-between focus:outline-none focus:ring-2 focus:ring-[#fba7a6]"
                        type="button" onclick="toggleSortDropdown()">
                        <span id="sortOption">Urutkan</span>
                        <span class="material-icons">expand_more</span>
                    </button>

                    <ul id="sortOptions" class="absolute w-full bg-white mt-1 rounded-md shadow-2xl hidden z-10">
                        <li class="py-2 px-4 hover:bg-[#F98B88] hover:text-white cursor-pointer whitespace-nowrap hover:rounded-t-md cursor-pointer" onclick="selectSortOption('terbaru')">Terbaru</li>
                        <li class="py-2 px-4 hover:bg-[#F98B88] hover:text-white cursor-pointer whitespace-nowrap hover:rounded-b-md cursor-pointer" onclick="selectSortOption('terlama')">Terlama</li>
                    </ul>
                </div>
            </div>

            <!-- Cek apakah ada laporan -->
            <?php if (empty($laporans)): ?>
                <!-- Tampilkan UI ajakan membuat laporan baru -->
                <div class="flex flex-col items-center justify-center bg-gray-100 rounded-lg shadow-sm p-8 text-center">
                    <!-- Ilustrasi interaktif -->
                    <img src="<?= base_url('Assets/images/emptystate2.png') ?>"
                        alt="Illustrasi laporan kosong"
                        class="w-40 h-auto mb-6 object-contain">

                    <h2 class="text-2xl text-gray-600 font-semibold mb-4">Tidak ada laporan yang tersedia</h2>
                    <p class="text-gray-500 mb-0">Butuh Seseorang untuk Mendengarkan?, Jangan pendam sendirian.</p>
                    <p class="text-gray-500 mb-6">Sampaikan curhat atau laporkan kejadian yang Anda alami, kami siap membantu.</p>

                    <!-- Tombol buat laporan baru -->
                    <a href="<?= base_url('Dashboard/Add-Report') ?>"
                        class="flex items-center justify-center bg-[#F98B88] hover:bg-[#f56a68] focus:bg-[#e75b5a] text-white px-4 py-2 rounded text-sm transition duration-300 w-auto max-w-xs">
                        Buat Laporan Baru
                        <span class="material-icons ml-2">post_add</span>
                    </a>
                </div>
            <?php else: ?>
                <!-- Kontainer Kartu -->
                <div id="cardWrapper">
                    <!-- Mulai Kartu -->
                    <div id="cardsContainer" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                        <?php foreach ($laporans as $laporan) : ?>
                            <div class="card bg-white rounded-lg shadow-xl flex flex-col h-full transition-transform transform hover:scale-105">
                                <!-- Gambar laporan -->
                                <img src="<?= base_url('uploads/reports/' . $laporan['foto_file']) ?>"
                                    alt="Gambar laporan"
                                    class="rounded-t-lg w-full h-[200px] object-cover">

                                <!-- Isi laporan -->
                                <div class="p-4 flex-grow">
                                    <?php
                                    // Ambil tanggal dari laporan
                                    $dateString = $laporan['date_create']; // Misalnya "2024-10-18 22:06:46"

                                    // Coba untuk membuat objek DateTime dari string
                                    try {
                                        $date = new DateTime($dateString);

                                        // Buat objek IntlDateFormatter untuk bahasa Indonesia
                                        $fmt = new \IntlDateFormatter('id_ID', \IntlDateFormatter::FULL, \IntlDateFormatter::NONE);
                                        $fmt->setPattern('EEEE, d MMMM yyyy');

                                        // Format tanggal ke dalam format yang diinginkan
                                        $tanggalLengkap = $fmt->format($date);
                                    } catch (Exception $e) {
                                        $tanggalLengkap = 'Tanggal tidak tersedia'; // Menangani kasus tidak valid
                                    }
                                    ?>

                                    <h3 class="card-title text-blue-800 font-semibold text-lg leading-tight line-clamp-2">
                                        <?= $laporan['subject'] ?>
                                    </h3>

                                    <!-- Deskripsi singkat laporan -->
                                    <p class="text-gray-600 mt-2 text-sm leading-relaxed line-clamp-3">
                                        <?= $laporan['isi'] ?>
                                    </p>

                                    <!-- Tampilkan tanggal -->
                                    <p class="card-date text-gray-500 mt-2 text-xs" data-date="<?= $laporan['date_create'] ?>">
                                        <?= $tanggalLengkap ?>
                                    </p>
                                </div>

                                <!-- Tombol aksi (selengkapnya dan hapus) -->
                                <div class="px-4 pb-4 mt-auto">
                                    <div class="flex flex-col justify-between items-center space-y-2">
                                        <!-- Tombol Selengkapnya -->
                                        <?php
                                        $encrypter = \Config\Services::encrypter();
                                        $encryptedLaporanId = bin2hex($encrypter->encrypt(base64_encode($laporan['id'])));
                                        ?>
                                        <a href="<?= base_url('Dashboard/Detail-Laporan/' . url_title(ucwords($laporan['subject']), '-', FALSE) . '/' . $encryptedLaporanId) ?>"
                                            class="bg-[#F98B88] hover:bg-[#f56a68] focus:bg-[#e75b5a] transition duration-300 text-white px-4 py-2 rounded text-xs w-full text-center"
                                            aria-label="Lihat lebih lanjut tentang laporan">
                                            Selengkapnya
                                        </a>

                                        <!-- Tombol Hapus -->
                                        <a href="#" onclick="confirmDelete('<?= base_url('Dashboard/Delete/' . $laporan['subject'] . '/' . $encryptedLaporanId) ?>', this)"
                                            class="text-red-500 border border-red-500 hover:bg-red-600 transition duration-300 hover:text-white px-4 py-2 rounded text-xs w-full text-center"
                                            aria-label="Hapus laporan ini">
                                            Hapus
                                        </a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <!-- Elemen Pesan 'Tidak ada hasil' -->
                    <div id="noResultMessage" class="hidden flex flex-col items-center justify-center bg-gray-100 rounded-lg shadow-sm p-8 text-center">
                        <img src="<?= base_url('Assets/images/emptystate3.png') ?>"
                            alt="Illustrasi laporan kosong"
                            class="w-40 h-auto mb-6 object-contain">
                        <h2 class="text-2xl text-gray-600 font-semibold mb-4">Tidak ada hasil yang ditemukan</h2>
                        <p class="text-gray-500 mb-6">Coba kata kunci lain atau buat laporan baru jika belum ada laporan.</p>
                    </div>
                </div>
            <?php endif; ?>
        </div>
</main>
</div>
</div>
</body>
<?= $this->endSection(); ?>