<?= $this->extend('layout/Admin/user-management/header'); ?>

<?= $this->section('content'); ?>

<!-- Profile Section -->
<main class="flex-1 p-6 sm:ml-20">
    <div class="bg-white rounded-lg shadow-sm">
        <!-- Gradient Banner -->
        <div class="bg-gradient-to-r from-[#F98B88] to-[#FFC6C4] h-16 w-full rounded-t-lg"></div>
        <div class="p-8 md:p-12">
            <div class="flex flex-col md:flex-row lg:flex-row items-center lg:justify-between w-full text-center lg:text-left">
                <div class="flex flex-col items-center md:items-start lg:items-start">
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
            </div>
        </div>
        <div class="p-8 pt-0 pb-14 md:p-12 md:pt-0">
            <div class="flex flex-col items-center pb-8">
                <h2 class="text-4xl font-bold pt-8 pb-2 text-center mb-2">Daftar Pengguna</h2>
                <p class="text-gray-600 text-sm text-center mb-8">
                    Menampilkan semua pengguna.
                </p>
            </div>

            <!-- Search and Sort Section -->
            <div class="flex flex-col md:flex-row items-center mb-6 pb-4">
                <!-- Input Pencarian dengan Lebar Penuh -->
                <div class="relative flex-grow mb-4 w-full md:mb-0 md:w-auto">
                    <input type="text" id="searchInput" placeholder="Cari berdasarkan nama pengguna"
                        class="border border-gray-300 rounded-md py-2 px-10 w-full focus:outline-none focus:ring-2 focus:ring-[#fba7a6]"
                        onkeyup="filterCards()">
                    <span class="absolute left-3 top-2.5 text-gray-400">
                        <span class="material-icons">search</span>
                    </span>
                </div>

                <!-- Dropdown Sort dengan Ukuran dan Posisi Terkendali -->
                <div class="relative ml-0 md:ml-4 w-full md:w-auto">
                    <button id="dropdownSortBtn"
                        class="border border-gray-300 bg-gray-100 text-gray-700 py-2 px-4 rounded-md flex items-center justify-between focus:outline-none focus:ring-2 focus:ring-[#fba7a6] w-full md:min-w-60"
                        type="button" onclick="toggleSortDropdown()">
                        <span id="sortOption" class="mr-3">Pilih Prodi</span>
                        <span class="material-icons">expand_more</span>
                    </button>

                    <ul id="sortOptions" class="absolute left-0 md:left-auto md:right-0 mt-1 bg-white rounded-md shadow-lg min-w-auto w-full hidden z-10">
                        <li class="py-2 px-4 hover:bg-[#F98B88] hover:text-white cursor-pointer whitespace-nowrap rounded-t-md" onclick="selectProdi('Teknologi Informasi')">Teknologi Informasi</li>
                        <li class="py-2 px-4 hover:bg-[#F98B88] hover:text-white cursor-pointer whitespace-nowrap" onclick="selectProdi('Desain Grafis')">Desain Grafis</li>
                        <li class="py-2 px-4 hover:bg-[#F98B88] hover:text-white cursor-pointer whitespace-nowrap" onclick="selectProdi('Administrasi Bisnis')">Administrasi Bisnis</li>
                        <li class="py-2 px-4 hover:bg-[#F98B88] hover:text-white cursor-pointer whitespace-nowrap" onclick="selectProdi('Keuangan dan Perbankan')">Keuangan dan Perbankan</li>
                        <li class="py-2 px-4 hover:bg-[#F98B88] hover:text-white cursor-pointer whitespace-nowrap rounded-b-md" onclick="selectProdi('Manajemen Perhotelan')">Manajemen Perhotelan</li>
                    </ul>
                </div>
            </div>

            <!-- Cek apakah ada laporan -->
            <?php if (empty($users)) : ?>
                <!-- Tampilkan UI ajakan membuat laporan baru -->
                <div class="flex flex-col items-center justify-center bg-gray-100 rounded-lg shadow-sm p-8 text-center">
                    <img src="<?= base_url('Assets/images/emptystate2.png') ?>"
                        alt="Illustrasi laporan kosong"
                        class="w-40 h-auto mb-6 object-contain">

                    <h2 class="text-2xl text-gray-600 font-semibold mb-4">Tidak ada laporan yang tersedia</h2>
                    <p class="text-gray-500 mb-0">Butuh Seseorang untuk Mendengarkan?, Jangan pendam sendirian.</p>
                    <p class="text-gray-500 mb-6">Sampaikan curhat atau laporkan kejadian yang Anda alami, kami siap membantu.</p>

                    <a href="<?= base_url('Dashboard/Add-Report') ?>"
                        class="flex items-center justify-center bg-[#F98B88] hover:bg-[#f56a68] focus:bg-[#e75b5a] text-white px-4 py-2 rounded text-sm transition duration-300 w-auto max-w-xs">
                        Buat Laporan Baru
                        <span class="material-icons ml-2">post_add</span>
                    </a>
                </div>
            <?php else : ?>
                <!-- Kontainer Kartu -->
                <div id="cardWrapper">
                    <!-- Mulai Kartu -->
                    <div id="cardsContainer" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                        <?php foreach ($users as $users) : ?>
                            <div class="card bg-white rounded-lg shadow-xl flex flex-col h-full transition-transform transform hover:scale-105">
                                <div class="flex flex-col items-center mb-12">
                                    <?php if (!empty($users['foto'])) : ?>
                                        <img src="<?= base_url('uploads/profile/' . $users['foto']) ?>"
                                            alt="Gambar laporan"
                                            class="rounded-t-lg w-full h-[200px] object-cover">
                                    <?php else : ?>
                                        <div class="bg-red-500 text-white w-full h-[200px] flex items-center justify-center text-4xl rounded-t-lg">
                                            <?= strtoupper($users['username'][0]); ?>
                                        </div>
                                    <?php endif; ?>
                                </div>


                                <div class="p-4 flex-grow">

                                    <h3 class="card-title text-blue-800 font-semibold text-lg leading-tight line-clamp-2">
                                        <?= $users['nama'] ?>
                                    </h3>
                                    <p class="text-gray-600 mt-2 text-xs leading-relaxed line-clamp-3">
                                        Username : <?= $users['username'] ?>
                                    </p>
                                    <p class="card-prodi text-gray-600 mt-2 text-xs leading-relaxed line-clamp-3">
                                        Prodi : <?= $users['prodi'] ?>
                                    </p>
                                    <p class="text-gray-600 mt-2 text-xs leading-relaxed line-clamp-3">
                                        Email : <?= $users['email'] ?>
                                    </p>
                                </div>

                                <div class="px-4 pb-4 mt-auto">
                                    <div class="flex flex-col justify-between items-center space-y-2">
                                        <?php
                                        $encrypter = \Config\Services::encrypter();
                                        $encryptedUserId = bin2hex($encrypter->encrypt(base64_encode($users['id'])));
                                        ?>
                                        <a href="<?= base_url('Admin/Detail-User/' . url_title(ucwords($users['nama']), '-', FALSE) . '/' . $encryptedUserId) ?>"
                                            class="bg-[#F98B88] hover:bg-[#f56a68] focus:bg-[#e75b5a] transition duration-300 text-white px-4 py-2 rounded text-xs w-full text-center"
                                            aria-label="Lihat lebih lanjut tentang laporan">
                                            Selengkapnya
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
                        <p class="text-gray-500 mb-6">Coba kata kunci lain.</p>
                    </div>
                </div>
            <?php endif; ?>
        </div>
</main>
</div>
</div>
</body>
<script>
    function toggleSortDropdown() {
        document.getElementById('sortOptions').classList.toggle('hidden');
    }

    function selectProdi(prodi) {
        document.getElementById('sortOption').textContent = prodi;
        document.getElementById('sortOptions').classList.add('hidden');
        filterCards(); // Update tampilan kartu berdasarkan pilihan prodi
    }

    function filterCards() {
        const input = document.getElementById('searchInput').value.toLowerCase();
        const selectedProdi = document.getElementById('sortOption').textContent.toLowerCase();
        const cards = document.querySelectorAll('#cardsContainer > .card');
        let cardsFound = false;

        cards.forEach(card => {
            const title = card.querySelector('.card-title').textContent.toLowerCase();
            const prodi = card.querySelector('.card-prodi').textContent.toLowerCase();

            if ((title.includes(input) || input === '') && (prodi.includes(selectedProdi) || selectedProdi === 'pilih prodi')) {
                card.style.display = ''; // Tampilkan kartu yang sesuai
                cardsFound = true;
            } else {
                card.style.display = 'none'; // Sembunyikan kartu yang tidak sesuai
            }
        });

        // Menampilkan atau menyembunyikan pesan "Tidak ada hasil"
        const noResultElement = document.getElementById('noResultMessage');
        noResultElement.classList.toggle('hidden', cardsFound);
    }

    // Menutup dropdown saat klik di luar
    document.addEventListener('click', function(event) {
        const dropdown = document.getElementById('sortOptions');
        const button = document.getElementById('dropdownSortBtn');

        if (!button.contains(event.target) && !dropdown.contains(event.target)) {
            dropdown.classList.add('hidden');
        }
    });
</script>
<?= $this->endSection(); ?>