<?= $this->extend('layout/user/profile/header'); ?>

<?= $this->section('content'); ?>

<!-- Profile Section -->
<main class="flex-1 p-6 sm:ml-20">
    <div class="bg-white rounded-lg shadow-sm">
        <!-- Gradient Banner -->
        <div class="bg-gradient-to-r from-[#F98B88] to-[#FFC6C4] h-16 w-full rounded-t-lg"></div>
        <div class="p-8">
            <?php if (session()->has('errors')): ?>
                <div id="alert" class="bg-red-100 backdrop-blur-md text-red-700 px-4 py-4 rounded-lg relative w-full mx-auto flex items-start mb-4 sm:mb-6 md:mb-8 lg:mb-10" role="alert">
                    <div class="flex-shrink-0">
                        <span class="material-icons text-red-500">error_outline</span>
                    </div>
                    <div class="ml-3 flex-1">
                        <strong class="font-bold">Error! Terdapat <?= count(session('errors')) ?> kesalahan.</strong>
                        <ul class="list-disc ml-5 mt-2">
                            <?php foreach (session('errors') as $field => $error): ?>
                                <?php if ($field == 'username'): ?>
                                    <li>Form <strong>Username</strong> tidak boleh kosong.</li>
                                <?php elseif ($field == 'nama'): ?>
                                    <li>Form <strong>Nama</strong> tidak boleh kosong.</li>
                                <?php elseif ($field == 'email'): ?>
                                    <li>Form <strong>Email</strong> tidak boleh kosong.</li>
                                <?php elseif ($field == 'nomor_hp'): ?>
                                    <li>Form <strong>Nomor HP</strong> tidak boleh kosong.</li>
                                <?php elseif ($field == 'nim'): ?>
                                    <li>Form <strong>NIM</strong> tidak boleh kosong.</li>
                                <?php elseif ($field == 'prodi'): ?>
                                    <li>Form <strong>Prodi</strong> tidak boleh kosong.</li>
                                <?php elseif ($field == 'foto'): ?>
                                    <?php if (strpos($error, 'mime_in') !== false): ?>
                                        <li><strong>Foto</strong> harus berformat JPG, JPEG, atau PNG.</li>
                                    <?php elseif (strpos($error, 'max_size') !== false): ?>
                                        <li><strong>Foto</strong> maksimal berukuran 1MB.</li>
                                    <?php endif; ?>
                                <?php else: ?>
                                    <li><?= esc($error); ?></li>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    <span class="absolute top-0 bottom-0 right-0 px-4 py-3 cursor-pointer" onclick="closeAlert()">
                        <span class="material-icons text-red-500">close</span>
                    </span>
                </div>
            <?php endif; ?>
            <!-- Tambahkan tag form dengan method dan action yang sesuai -->
            <form id="edit-profile-form" action="<?= base_url('Dashboard/Profile') ?>" method="post" enctype="multipart/form-data">
                <?= csrf_field() ?>
                <input type="hidden" name="foto_old" value="<?= esc($user['foto']) ?>">

                <!-- Ganti '/submit' dengan endpoint backend yang sesuai -->
                <div class="flex flex-col sm:flex-row items-center mb-12">
                    <?php if (!empty($user['foto'])) : ?>
                        <img alt="Profile picture"
                            class="w-40 h-40 rounded-full object-cover aspect-square sm:w-20 sm:h-20 lg:mr-6 mb-4 lg:mb-0"
                            src="<?= base_url('uploads/profile/' . $user['foto']) ?>" />
                    <?php else : ?>
                        <a href="<?= base_url('Dashboard/Profile/' . $user['username']) ?>">
                            <div class="bg-red-500 text-white w-40 h-40 rounded-full lg:mr-6 mb-4 lg:mb-0 sm:w-20 sm:h-20 flex items-center justify-center text-4xl">
                                <?= strtoupper($user['username'][0]); ?>
                            </div>
                        </a>
                    <?php endif; ?>

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

                    <button
                        class="mt-4 sm:mt-0 sm:ml-auto bg-[#F98B88] text-white px-4 py-2 rounded-md hover:bg-[#e07574] focus:bg-[#c9605e] transition duration-300 flex items-center space-x-2"
                        type="submit"> <!-- Ganti type menjadi 'submit' agar mengirimkan form -->
                        <span>Simpan Perubahan</span>
                        <span class="material-symbols-rounded ">save</span>
                    </button>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-gray-600 mb-2 text-md font-bold">Nama</label>
                        <input
                            class="w-full p-3 rounded bg-gray-50 text-gray-500 focus:outline-none focus:ring-2 focus:ring-[#fba7a6]"
                            placeholder="Nama Lengkap Kamu" type="text" name="nama" required value="<?= esc($user['nama']) ?>" />
                        <!-- Tambahkan name dan required -->
                    </div>
                    <div>
                        <label class="block text-gray-600 mb-2 text-md font-bold">Username</label>
                        <input
                            class="w-full p-3 rounded bg-gray-50 text-gray-500 focus:outline-none focus:ring-2 focus:ring-[#fba7a6]"
                            placeholder="Username kamu" type="text" name="username" required value="<?= esc($user['username']) ?>" />
                        <!-- Tambahkan name dan required -->
                    </div>
                    <div>
                        <label class="block text-gray-600 mb-2 text-md font-bold">No Hp</label>
                        <input
                            class="w-full p-3 rounded bg-gray-50 text-gray-500 focus:outline-none focus:ring-2 focus:ring-[#fba7a6]"
                            placeholder="Nomor Hp Kamu" type="text" name="nomor_hp" required value="<?= esc($user['nomor_hp']) ?>" />
                        <!-- Tambahkan name dan required -->
                    </div>
                    <div>
                        <label class="block text-gray-600 mb-2 text-md font-bold">Email</label>
                        <input
                            class="w-full p-3 rounded bg-gray-50 text-gray-500 focus:outline-none focus:ring-2 focus:ring-[#fba7a6]"
                            placeholder="Email Mahasiswa UB Kamu" type="email" name="email" required readonly value="<?= esc($user['email']) ?>" />
                        <!-- Ganti type menjadi 'email' dan tambahkan name -->
                    </div>
                    <div>
                        <label class="block text-gray-600 mb-2 text-md font-bold">NIM</label>
                        <input
                            class="w-full p-3 rounded bg-gray-50 text-gray-500 focus:outline-none focus:ring-2 focus:ring-[#fba7a6]"
                            placeholder="NIM Kamu" type="text" name="nim" required value="<?= esc($user['nim']) ?>" />
                        <!-- Tambahkan name dan required -->
                    </div>
                    <div>
                        <label for="dropdownBtn" class="block text-gray-600 mb-2 text-md font-bold">Prodi</label>
                        <div class="relative w-full">
                            <button id="dropdownBtn" class="w-full bg-gray-50 text-gray-500 py-3 px-4 rounded flex justify-between items-center focus:outline-none focus:ring-2 focus:ring-[#fba7a6]" type="button" onclick="toggleDropdown()">
                                <span id="dropdownSelected"><?= !empty($user['prodi']) ? esc($user['prodi']) : 'Pilih Prodi' ?></span>
                                <span class="material-symbols-rounded">expand_more</span>
                            </button>
                            <ul id="dropdownOptions" class="absolute w-full bg-white mt-1 rounded-md shadow-xl hidden">
                                <li class="py-2 px-4 hover:bg-[#F98B88] hover:text-white cursor-pointer whitespace-nowrap rounded-t-md" onclick="selectOption('Teknologi Informasi')">Teknologi Informasi</li>
                                <li class="py-2 px-4 hover:bg-[#F98B88] hover:text-white cursor-pointer whitespace-nowrap" onclick="selectOption('Desain Grafis')">Desain Grafis</li>
                                <li class="py-2 px-4 hover:bg-[#F98B88] hover:text-white cursor-pointer whitespace-nowrap" onclick="selectOption('Administrasi Bisnis')">Administrasi Bisnis</li>
                                <li class="py-2 px-4 hover:bg-[#F98B88] hover:text-white cursor-pointer whitespace-nowrap" onclick="selectOption('Keuangan dan Perbankan')">Keuangan dan Perbankan</li>
                                <li class="py-2 px-4 hover:bg-[#F98B88] hover:text-white cursor-pointer whitespace-nowrap rounded-b-md" onclick="selectOption('Manajemen Perhotelan')">Manajemen Perhotelan</li>
                            </ul>
                            <!-- Hidden input untuk menyimpan nilai dropdown -->
                            <input type="hidden" id="dropdownValue" name="prodi" value="<?= esc($user['prodi']) ?>" required>
                        </div>
                    </div>

                    <!-- Upload Foto -->
                    <div class="col-span-full">
                        <label for="cover-photo" class="block text-gray-600 mb-2 text-md font-bold">Foto</label>
                        <div id="drop-area" class="mt-2 flex justify-center rounded-lg border border-dashed border-gray-900/25 px-6 py-10">
                            <div class="text-center">
                                <div id="photo-preview-container" class="grid max-w-full mt-4 justify-items-center pb-4">
                                    <!-- Foto akan ditampilkan di sini -->
                                </div>
                                <svg id="upload-icon" class="mx-auto h-12 w-12 text-gray-300 mb-12" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M1.5 6a2.25 2.25 0 012.25-2.25h16.5A2.25 2.25 0 0122.5 6v12a2.25 2.25 0 01-2.25 2.25H3.75A2.25 2.25 0 011.5 18V6zM3 16.06V18c0 .414.336.75.75.75h16.5A.75.75 0 0021 18v-1.94l-2.69-2.689a1.5 1.5 0 00-2.12 0l-.88.879.97.97a.75.75 0 11-1.06 1.06l-5.16-5.159a1.5 1.5 0 00-2.12 0L3 16.061zm10.125-7.81a1.125 1.125 0 112.25 0 1.125 1.125 0 01-2.25 0z" clip-rule="evenodd" />
                                </svg>
                                <div class="mt-4 flex flex-col md:flex-row text-sm leading-6 text-gray-600 mt-12 justify-center">
                                    <label for="file-upload" class="relative cursor-pointer rounded-md bg-white font-semibold text-[#F98B88] focus-within:outline-none focus-within:ring-2 focus-within:ring-[#F98B88] focus-within:ring-offset-2 hover:text-[#F98B88]">
                                        <span>Unggah File Foto Kamu</span>
                                        <input id="file-upload" name="foto" type="file" class="sr-only" accept=".jpg,.jpeg,.png" onchange="previewFile(event)">
                                    </label>
                                    <p class="pl-1">Atau Seret dan Jatuhkan</p>
                                </div>
                                <p class="text-xs leading-5 text-gray-600">PNG, JPG, JPEG up to 10MB</p>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</main>
</div>
</div>
</body>
<script>
    const dropArea = document.getElementById('drop-area');
    const fileInput = document.getElementById('file-upload');
    const photoPreviewContainer = document.getElementById('photo-preview-container');
    const uploadIcon = document.getElementById('upload-icon');

    let uploadedFile = null; // Menyimpan file yang diunggah

    // Fungsi untuk menampilkan pratinjau gambar
    function previewFile(event) {
        const file = event.target.files[0];
        if (!file || !isValidFileType(file)) {
            return;
        }
        handleFileUpload(file);
    }

    // Fungsi validasi tipe file
    function isValidFileType(file) {
        const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];
        return allowedTypes.includes(file.type);
    }

    // Fungsi untuk menangani unggahan file
    function handleFileUpload(file) {
        if (uploadedFile) {
            // Jika sudah ada file yang diunggah, hapus file sebelumnya
            removeUploadedFile();
        }
        const reader = new FileReader();
        reader.onload = function(e) {
            const img = document.createElement('div');
            img.classList.add('relative', 'group');
            img.innerHTML = `
                <img src="${e.target.result}" class="h-auto w-60 object-cover rounded-lg border border-gray-300 shadow-md transition-transform duration-300 hover:scale-105">
                <button class="absolute top-1 right-1 bg-red-500 text-white text-md rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-300 py-2 px-2.5 text-md" onclick="removeUploadedFile()"><i class="fas fa-times"></i></button>
            `;
            photoPreviewContainer.appendChild(img);
            uploadedFile = file; // Simpan file yang diunggah
            updateUploadIconVisibility(); // Sembunyikan ikon
        };
        reader.readAsDataURL(file);
    }

    // Fungsi untuk menghapus file yang diunggah
    function removeUploadedFile() {
        uploadedFile = null;
        photoPreviewContainer.innerHTML = ''; // Hapus pratinjau
        fileInput.value = ''; // Kosongkan input file
        updateUploadIconVisibility(); // Tampilkan ikon jika tidak ada file
    }

    // Fungsi untuk memperbarui visibilitas ikon SVG
    function updateUploadIconVisibility() {
        if (!uploadedFile) {
            uploadIcon.classList.remove('hidden');
        } else {
            uploadIcon.classList.add('hidden');
        }
    }

    // Event Listener untuk drag and drop
    dropArea.addEventListener('dragover', (event) => {
        event.preventDefault();
        dropArea.classList.add('border-blue-500'); // Tambahkan gaya saat drag
    });

    dropArea.addEventListener('dragleave', () => {
        dropArea.classList.remove('border-blue-500'); // Hapus gaya saat drag selesai
    });

    dropArea.addEventListener('drop', (event) => {
        event.preventDefault();
        dropArea.classList.remove('border-blue-500');
        const files = event.dataTransfer.files; // Ambil file dari drag and drop
        if (files.length > 0 && isValidFileType(files[0])) {
            handleFileUpload(files[0]); // Tangani file yang dijatuhkan
        }
    });
</script>
<?= $this->endSection(); ?>