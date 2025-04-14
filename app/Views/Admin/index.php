<?= $this->extend('layout/Admin/home/header'); ?>

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
                <h2 class="text-4xl font-bold pt-8 pb-2 text-center mb-2">Daftar Laporan ULTKSP</h2>
                <p class="text-gray-600 text-sm text-center mb-8">
                    Menampilkan semua laporan yang telah dibuat pengguna.
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
            <?php if (empty($laporans)) : ?>
                <!-- Tampilkan UI ajakan membuat laporan baru -->
                <div class="flex flex-col items-center justify-center bg-gray-100 rounded-lg shadow-sm p-8 text-center">
                    <img src="<?= base_url('Assets/images/emptystate2.png') ?>"
                        alt="Illustrasi laporan kosong"
                        class="w-40 h-auto mb-6 object-contain">

                    <h2 class="text-2xl text-gray-600 font-semibold mb-4">Tidak ada laporan yang tersedia</h2>
                </div>
            <?php else : ?>
                <!-- Kontainer Kartu -->
                <div id="cardWrapper">
                    <!-- Mulai Kartu -->
                    <div id="cardsContainer" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                        <?php foreach ($laporans as $laporan) : ?>
                            <div class="card bg-white rounded-lg shadow-xl flex flex-col h-full transition-transform transform hover:scale-105">
                                <img src="<?= base_url('uploads/reports/' . $laporan['foto_file']) ?>"
                                    alt="Gambar laporan"
                                    class="rounded-t-lg w-full h-[200px] object-cover">

                                <div class="p-4 flex-grow">
                                    <?php
                                    $dateString = $laporan['date_create'];
                                    try {
                                        $date = new DateTime($dateString);
                                        $fmt = new \IntlDateFormatter('id_ID', \IntlDateFormatter::FULL, \IntlDateFormatter::NONE);
                                        $fmt->setPattern('EEEE, d MMMM yyyy');
                                        $tanggalLengkap = $fmt->format($date);
                                    } catch (Exception $e) {
                                        $tanggalLengkap = 'Tanggal tidak tersedia';
                                    }
                                    ?>

                                    <h3 class="card-title text-blue-800 font-semibold text-lg leading-tight line-clamp-2">
                                        <?= $laporan['subject'] ?>
                                    </h3>
                                    <p class="text-gray-600 mt-2 text-sm leading-relaxed line-clamp-3">
                                        <?= $laporan['isi'] ?>
                                    </p>
                                    <p class="card-date text-gray-500 mt-2 text-xs" data-date="<?= $laporan['date_create'] ?>">
                                        <?= $tanggalLengkap ?>
                                    </p>
                                </div>

                                <div class="px-4 pb-4 font-semibold">
                                    <p class="card-date text-gray-500 mt-2 text-xs break-words">
                                        Pembuat : <?= esc($laporan['creator_name']) ?>
                                    </p>
                                    <p class="card-date text-gray-500 mt-2 text-xs break-words">
                                        <?= esc($laporan['email']) ?>
                                    </p>
                                </div>

                                <div class="px-4 pb-4 mt-auto">
                                    <div class="flex flex-col justify-between items-center space-y-2">
                                        <?php
                                        $encrypter = \Config\Services::encrypter();
                                        $encryptedLaporanId = bin2hex($encrypter->encrypt(base64_encode($laporan['id'])));
                                        ?>
                                        <a href="<?= base_url('Admin/Detail-Laporan/' . url_title(ucwords($laporan['subject']), '-', FALSE) . '/' . $encryptedLaporanId) ?>"
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

    function selectSortOption(option) {
        document.getElementById('sortOption').textContent = option.charAt(0).toUpperCase() + option.slice(1);
        document.getElementById('sortOptions').classList.add('hidden');
        sortCards(option);
    }

    function sortCards(option) {
        const cardsContainer = document.getElementById('cardsContainer');
        const cards = Array.from(cardsContainer.children);

        cards.sort((a, b) => {
            const dateA = new Date(a.querySelector('.card-date').dataset.date);
            const dateB = new Date(b.querySelector('.card-date').dataset.date);

            return option === 'terbaru' ? dateB - dateA : dateA - dateB;
        });

        // Clear the current card order
        cardsContainer.innerHTML = '';
        // Append the sorted cards back to the container
        cards.forEach(card => cardsContainer.appendChild(card));
    }

    function filterCards() {
        const input = document.getElementById('searchInput');
        const filter = input.value.toLowerCase();
        const cards = document.querySelectorAll('#cardsContainer > div');
        let cardsFound = false; // Flag untuk melacak apakah ada kartu yang ditemukan

        cards.forEach(card => {
            const title = card.querySelector('.card-title').textContent.toLowerCase();
            const content = card.querySelector('p').textContent.toLowerCase();
            if (title.includes(filter) || content.includes(filter)) {
                card.style.display = ''; // Tampilkan kartu
                cardsFound = true; // Set kartu ditemukan
            } else {
                card.style.display = 'none'; // Sembunyikan kartu
            }
        });

        // Mengatur tampilan elemen "Tidak ada hasil"
        const noResultElement = document.getElementById('noResultMessage');
        if (!cardsFound) {
            noResultElement.classList.remove('hidden'); // Tampilkan pesan
        } else {
            noResultElement.classList.add('hidden'); // Sembunyikan pesan
        }
    }

    // Close dropdown when clicking outside of it
    document.addEventListener('click', function(event) {
        const dropdown = document.getElementById('sortOptions');
        const button = document.getElementById('dropdownSortBtn');

        // Check if click is outside dropdown and button
        if (!button.contains(event.target) && !dropdown.contains(event.target)) {
            dropdown.classList.add('hidden');
        }
    });
</script>
<?= $this->endSection(); ?>