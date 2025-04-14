<?= $this->extend('layout/admin/home/header'); ?>

<?= $this->section('content'); ?>

<!-- Profile Section -->
<main class="flex-1 p-6 sm:ml-20">
    <div class="bg-white rounded-lg shadow-sm">
        <!-- Gradient Banner -->
        <div class="bg-gradient-to-r from-[#F98B88] to-[#FFC6C4] h-16 w-full rounded-t-lg"></div>
        <div class="p-2 md:p-12">
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
                </div>
            </div>
        </div>
        <div class="p-2 pt-0 md:p-6">
            <div class="p-6">
                <h1 class="text-3xl md:text-4xl font-bold text-center mb-12 max-w-full">
                    <?= $laporan['subject'] ?>
                </h1>
                <p class="text-gray-700 mb-6 text-center">
                    <?= $laporan['isi'] ?>
                </p>

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

                <div class="text-gray-500 mb-6">
                    <?= $tanggalLengkap ?>
                </div>
                <div class="bg-slate-50 shadow-lg shadow-slate-100 rounded-lg overflow-hidden mb-12">
                    <div class="bg-gray-100 p-4 flex items-center">
                        <span class="text-gray-500 material-symbols-rounded">image</span>
                        <span class="text-gray-500 ml-2">Bukti Pendukung</span>
                    </div>
                    <div class="columns-1 md:columns-3 lg:columns-4 gap-4 p-4">
                        <?php foreach ($photos as $index => $photo): ?>
                            <div class="mb-4 break-inside-avoid">
                                <img alt="img" class="w-auto h-full object-cover transition-transform duration-300 rounded-md transform hover:scale-105 cursor-pointer"
                                    src="<?= base_url('uploads/reports/' . esc($photo['file_name'])) ?>" />
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <h2 class="text-4xl font-bold text-center mb-2">
                    Ruang Bicara
                </h2>
                <p class="text-center text-gray-500 mb-6">
                    Ayo respon laporan dari pelapor!
                </p>
                <?php if (!empty($comments)) : // Cek apakah ada komentar 
                ?>
                    <?php foreach ($comments as $comment) { ?>
                        <?php if ($comment['id_laporan'] == $laporan['id']) { // Comments on this post 
                        ?>
                            <?php if ($comment['user_id'] == $user['id'] && $user['role'] == 'admin') { // Comment by current user 
                            ?>
                                <div class="mb-12">
                                    <div class="flex items-center justify-end mb-2">
                                        <div class="text-right">
                                            <div class="font-bold">
                                                <?= $comment['nama']; ?>
                                            </div>

                                            <?php
                                            // Ambil tanggal dari laporan
                                            $dateString = $comment['date_create']; // Misalnya "2024-10-18 22:06:46"

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

                                            <div class="text-gray-500 text-sm">
                                                <?= $tanggalLengkap ?>
                                            </div>
                                        </div>
                                        <?php if (!empty($comment['foto'])) : ?>
                                            <img alt="Profile picture" class="w-10 h-10 rounded-full ml-2 object-cover aspect-square" height="40"
                                                src="<?= base_url('uploads/profile/' . $comment['foto']) ?>" width="40" />
                                        <?php else : ?>
                                            <!-- Tampilkan huruf depan dari nama user -->
                                            <div class="bg-red-500 text-white w-10 h-10 rounded-full ml-2 flex items-center justify-center text-lg">
                                                <?= strtoupper($comment['username'][0]); ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="text-gray-700 bg-slate-50 rounded shadow-lg shadow-slate-100 mb-12 mt-4 py-4 px-10 border-r-4 border-[#F98B88]">
                                        <p class="mb-0 text-right"><?= $comment['isi']; ?></p>


                                        <?php
                                        $encrypter = \Config\Services::encrypter();
                                        $encryptedcommentId = bin2hex($encrypter->encrypt(base64_encode($comment['id'])));
                                        // $encryptedId = rawurlencode($encryptedcommentId); // Encode untuk URL
                                        ?>
                                        <div class="flex items-center justify-end mb-2 mt-6">
                                            <a href="" onclick="confirmDeleteComment('<?= ('Admin/Delete-Comment/' . $encryptedcommentId) ?>')"
                                                class="sm:mt-0 sm:ml-auto bg-red-500 text-sm text-white px-4 py-2 rounded-md hover:bg-red-600 focus:bg-red-700 transition duration-300 flex transition duration-300 flex items-center space-x-2">
                                                <span>Hapus</span>
                                                <span class="material-symbols-rounded">delete</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>

                            <?php } else { // Comment by current admin 
                            ?>
                                <div class="mb-12">
                                    <div class="flex items-center mb-2">

                                        <?php if (!empty($comment['foto'])) : ?>
                                            <img alt="Profile picture" class="w-10 h-10 rounded-full mr-2 object-cover"
                                                src="<?= base_url('uploads/profile/' . $comment['foto']) ?>" width="40" height="40" />
                                        <?php else : ?>
                                            <!-- Tampilkan huruf depan dari nama user -->
                                            <div class="bg-red-500 text-white w-10 h-10 mr-2 rounded-full flex items-center justify-center text-lg">
                                                <?= strtoupper($comment['username'][0]); ?>
                                            </div>
                                        <?php endif; ?>

                                        <div>
                                            <div class="font-bold">
                                                <?= $comment['username']; ?>
                                            </div>

                                            <?php
                                            // Ambil tanggal dari laporan
                                            $dateString = $comment['date_create']; // Misalnya "2024-10-18 22:06:46"

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
                                            <div class="text-gray-500 text-sm">
                                                <?= $tanggalLengkap ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div
                                        class="text-gray-700 bg-slate-50 rounded shadow-lg shadow-slate-100 mb-12 mt-4 py-8 px-10 border-l-4 border-[#F98B88]">
                                        <p>
                                            <?= $comment['isi']; ?>
                                        </p>
                                    </div>
                                </div>
                            <?php } ?>
                        <?php } ?>
                    <?php } ?>
                <?php else : // Tampilkan pesan jika tidak ada komentar 
                ?>
                <?php endif; ?>

                <?php
                $encrypter = \Config\Services::encrypter();
                $encryptedLaporanId = bin2hex($encrypter->encrypt(base64_encode($laporan['id'])));
                // $encryptedId = rawurlencode($encryptedLaporanId); // Encode untuk URL
                ?>
                <form id="comment-form" class="user" action="<?= base_url('Admin/Post-Comment/' . $encryptedLaporanId) ?>" method="post">
                    <?= csrf_field() ?>
                    <div class="col-span-full form-group mb-6">
                        <label for="Isi" class="block text-gray-600 mb-2 text-md font-bold">Kirim Pesan ke Pelapor</label>
                        <div class="col-span-full">
                            <div class="mt-2">
                                <textarea id="editor" name="editor" rows="5" required
                                    class="block w-full p-3 rounded bg-gray-50 text-gray-500 focus:outline-none focus:ring-2 focus:ring-[#fba7a6] placeholder:text-gray-400"
                                    placeholder="Tuliskan Responmu Terhadap Laporan di Atas"></textarea>
                            </div>
                        </div>
                    </div>
                    <button type="submit"
                        class="bg-[#F98B88] text-white px-4 py-2 rounded w-full hover:bg-[#e07574] focus:bg-[#c9605e] transition duration-300">
                        Kirim
                    </button>
                </form>
            </div>
        </div>
</main>
</div>
</div>
</body>
<?= $this->endSection(); ?>