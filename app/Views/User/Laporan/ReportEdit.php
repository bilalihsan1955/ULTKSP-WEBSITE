<?= $this->extend('layout/user/home/header'); ?>

<?= $this->section('content'); ?>

<!-- Edit Form -->
<main class="flex-1 p-6 sm:ml-20">
    <div class="bg-white rounded-lg shadow-sm">
        <!-- Gradient Banner -->
        <div class="bg-gradient-to-r from-[#F98B88] to-[#FFC6C4] h-16 w-full rounded-t-lg"></div>
        <!-- Title -->
        <h2 class="text-center text-2xl font-bold text-gray-800 p-6 md:text-4xl">Form Edit Laporan</h2>
        <div class="p-8">

            <!-- Error Alert -->
            <?php if (session()->has('errors')): ?>
                <div id="alert" class="bg-red-100 backdrop-blur-md text-red-700 px-4 py-4 rounded-lg relative w-full mx-auto flex items-start mb-4 sm:mb-6 md:mb-8 lg:mb-10" role="alert">
                    <div class="flex-shrink-0">
                        <span class="material-icons text-red-500">error_outline</span>
                    </div>
                    <div class="ml-3 flex-1">
                        <strong class="font-bold">Error! Terdapat <?= count(session('errors')) ?> kesalahan.</strong>
                        <ul class="list-disc ml-5 mt-2">
                            <?php foreach (session('errors') as $field => $error): ?>
                                <?php if ($field == 'subject'): ?>
                                    <li>Form <strong>Subjek</strong> tidak boleh kosong.</li>
                                <?php elseif ($field == 'editor'): ?>
                                    <li>Form <strong>Kronologi</strong> tidak boleh kosong.</li>
                                <?php elseif ($field == 'photo'): ?>
                                    <?php if (strpos($error, 'uploaded') !== false): ?>
                                        <li><strong>Foto</strong> harus diupload.</li>
                                    <?php elseif (strpos($error, 'mime_in') !== false): ?>
                                        <li><strong>Foto</strong> harus berformat JPG, JPEG, atau PNG.</li>
                                    <?php elseif (strpos($error, 'max_size') !== false): ?>
                                        <li><strong>Foto</strong> maksimal berukuran 1MB.</li>
                                    <?php elseif (strpos($error, 'foto') !== false): ?>
                                        <li><strong>Foto</strong>File tidak valid atau sudah dipindahkan</li>
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

            <?php
            $encrypter = \Config\Services::encrypter();
            $encryptedLaporanId = bin2hex($encrypter->encrypt(base64_encode($laporan['id'])));
            // $encryptedId = rawurlencode($encryptedLaporanId); // Encode untuk URL
            ?>

            <form action="<?= base_url('Dashboard/Edit-Report/' . $laporan['subject'] . '/' . $encryptedLaporanId) ?>" method="post" enctype="multipart/form-data">
                <?= csrf_field() ?>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <!-- Subject -->
                    <div class="col-span-full">
                        <label class="block text-gray-600 mb-2 text-md font-bold">Subject</label>
                        <input
                            class="w-full p-3 rounded bg-gray-50 text-gray-500 focus:outline-none focus:ring-2 focus:ring-[#fba7a6]"
                            placeholder="Subject Lengkap Kamu" type="text" name="subject" value="<?= old('subject', $laporan['subject']) ?>" />
                    </div>

                    <!-- Isi -->
                    <div class="col-span-full">
                        <label for="Isi" class="block text-gray-600 mb-2 text-md font-bold">Kronologi</label>
                        <div class="mt-2">
                            <textarea id="editor" name="editor" rows="3"
                                class="block w-full p-3 rounded bg-gray-50 text-gray-500 focus:outline-none focus:ring-2 focus:ring-[#fba7a6] placeholder:text-gray-400"
                                placeholder="Tuliskan Segala Masalahmu dan Keluh Kesahmu" oninput="autoResize(this)"><?= old('editor', $laporan['isi']) ?></textarea>
                        </div>
                    </div>

                    <!-- Area untuk Upload Foto -->
                    <div class="col-span-full">
                        <label for="cover-photo" class="block text-gray-600 mb-2 text-md font-bold">Foto</label>
                        <div id="drop-area" class="mt-2 flex justify-center rounded-lg border border-dashed border-gray-900/25 px-6 py-10 max-w-full">
                            <div class="text-center">
                                <div id="photo-preview-container" class="grid grid-cols-1 md:grid-cols-4 lg:grid-cols-4 gap-6 max-w-full mt-4 justify-items-center pb-4">
                                    <!-- Existing photos and uploaded photos will be displayed here -->
                                </div>
                                <svg id="upload-icon" class="mx-auto h-12 w-12 text-gray-300 mb-12 hidden" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M1.5 6a2.25 2.25 0 012.25-2.25h16.5A2.25 2.25 0 0122.5 6v12a2.25 2.25 0 01-2.25 2.25H3.75A2.25 2.25 0 011.5 18V6zM3 16.06V18c0 .414.336.75.75.75h16.5A.75.75 0 0021 18v-1.94l-2.69-2.689a1.5 1.5 0 00-2.12 0l-.88.879.97.97a.75.75 0 11-1.06 1.06l-5.16-5.159a1.5 1.5 0 00-2.12 0L3 16.061zm10.125-7.81a1.125 1.125 0 112.25 0 1.125 1.125 0 01-2.25 0z" clip-rule="evenodd" />
                                </svg>
                                <div class="mt-4 flex flex-col md:flex-row text-sm leading-6 text-gray-600 mt-12 justify-center">
                                    <label for="file-upload" class="relative cursor-pointer rounded-md bg-white font-semibold text-[#F98B88] focus-within:outline-none focus-within:ring-2 focus-within:ring-[#F98B88] focus-within:ring-offset-2 hover:text-[#F98B88]">
                                        <span>Unggah File Foto Kamu</span>
                                        <input id="file-upload" name="photo[]" type="file" class="sr-only" accept=".jpg,.jpeg,.png" multiple>
                                    </label>
                                    <p class="pl-1">Atau Seret dan Jatuhkan</p>
                                </div>
                                <p class="text-xs leading-5 text-gray-600">PNG, JPG, JPEG up to 10MB</p>
                            </div>
                        </div>
                    </div>

                    <!-- Input Hidden untuk menyimpan nama file yang ada -->
                    <input type="hidden" id="existing-photos" name="existing_photos">

                    <!-- Submit button -->
                    <div class="col-span-full mt-8">
                        <button type="submit" class="w-full p-3 rounded bg-[#F98B88] text-white hover:bg-[#e07574] transition duration-300">
                            Update
                        </button>
                    </div>
            </form>

            <script>
                const dropArea = document.getElementById('drop-area');
                const fileInput = document.getElementById('file-upload');
                const photoPreviewContainer = document.getElementById('photo-preview-container');
                const existingPhotosInput = document.getElementById('existing-photos');
                const uploadIcon = document.getElementById('upload-icon');
            
                let uploadedFiles = []; // Menyimpan file yang baru diunggah
                let existingPhotos = []; // Menyimpan foto yang sudah ada dari database
                let dataTransfer = new DataTransfer(); // Untuk menambahkan file ke input file
            
                // Ambil foto yang sudah ada dari PHP dan tampilkan
                existingPhotos = [
                    <?php foreach ($photos as $photo): ?> "<?= $photo['file_name'] ?>",
                    <?php endforeach; ?>
                ].filter(Boolean);
            
                // Tampilkan foto yang sudah ada di pratinjau
                existingPhotos.forEach(photo => {
                    const img = document.createElement('div');
                    img.classList.add('relative', 'group');
                    img.innerHTML = `
                        <img src="<?= base_url('uploads/reports/'); ?>${photo}" class="h-auto w-60 object-cover rounded-lg border border-gray-300 shadow-md transition-transform duration-300 hover:scale-105">
                        <button class="absolute top-1 right-1 bg-red-500 text-white text-md rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-300 py-2 px-2.5 text-md" onclick="removeExistingImage('${photo}')"><i class="fas fa-times"></i></button>
                    `;
                    photoPreviewContainer.appendChild(img);
                });
            
                // Cek visibilitas ikon SVG setelah gambar ditampilkan
                updateUploadIconVisibility();
            
                // Kirimkan foto yang ada ke input tersembunyi
                existingPhotosInput.value = existingPhotos.join(',');
            
                // Event Listener untuk unggahan file baru melalui input file
                fileInput.addEventListener('change', (event) => {
                    const files = event.target.files;
                    if (files.length > 0) {
                        for (let i = 0; i < files.length; i++) {
                            handleFileUpload(files[i]);
                        }
                    }
                    updateUploadIconVisibility(); // Update visibilitas ikon SVG setelah upload
                });
            
                // Event Listener untuk drag and drop
                dropArea.addEventListener('dragover', (event) => {
                    event.preventDefault();
                    dropArea.classList.add('border-blue-500'); // Gaya ketika drag
                });
            
                dropArea.addEventListener('dragleave', () => {
                    dropArea.classList.remove('border-blue-500'); // Kembalikan gaya saat drag selesai
                });
            
                dropArea.addEventListener('drop', (event) => {
                    event.preventDefault();
                    dropArea.classList.remove('border-blue-500');
                    const files = event.dataTransfer.files; // Ambil file dari drag and drop
                    if (files.length > 0) {
                        for (let i = 0; i < files.length; i++) {
                            handleFileUpload(files[i]); // Tangani file yang dijatuhkan
                            dataTransfer.items.add(files[i]); // Tambahkan file ke input file
                        }
                        fileInput.files = dataTransfer.files; // Update input file dengan file yang baru di-drop
                    }
                    updateUploadIconVisibility(); // Update visibilitas ikon SVG setelah drag & drop
                });
            
                // Fungsi untuk menampilkan pratinjau file yang baru diunggah
                function handleFileUpload(file) {
                    // Validasi tipe file
                    const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];
                    if (!allowedTypes.includes(file.type)) {
                        alert('Format file tidak diperbolehkan. Hanya file JPG, JPEG, dan PNG yang diperbolehkan.');
                        return;
                    }
            
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const img = document.createElement('div');
                        img.classList.add('relative', 'group');
                        img.innerHTML = `
                            <img src="${e.target.result}" class="h-auto w-60 object-cover rounded-lg border border-gray-300 shadow-md transition-transform duration-300 hover:scale-105">
                            <button class="absolute top-1 right-1 bg-red-500 text-white text-md rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-300 py-2 px-2.5 text-md" onclick="removeUploadedFile(${uploadedFiles.length})"><i class="fas fa-times"></i></button>
                        `;
                        photoPreviewContainer.appendChild(img);
                    };
                    reader.readAsDataURL(file);
                    uploadedFiles.push(file); // Tambahkan file ke array
                    updateUploadIconVisibility(); // Perbarui visibilitas ikon
                }
            
                function removeExistingImage(photo) {
                    const index = existingPhotos.indexOf(photo);
                    if (index > -1) {
                        existingPhotos.splice(index, 1); // Hapus dari array
                        updatePreview();
                        updateExistingPhotosInput(); // Perbarui input tersembunyi
                        updateUploadIconVisibility(); // Update visibilitas ikon SVG setelah menghapus gambar
                    }
                }
            
                function updateExistingPhotosInput() {
                    document.getElementById('existing-photos').value = existingPhotos.join(',');
                }
            
                // Fungsi untuk menghapus file yang baru diunggah
                function removeUploadedFile(index) {
                    uploadedFiles.splice(index, 1);
                    dataTransfer.items.remove(index); // Hapus dari DataTransfer
                    fileInput.files = dataTransfer.files; // Update input file
                    updatePreview();
                    if (uploadedFiles.length === 0) {
                        uploadIcon.classList.remove('hidden'); // Tampilkan kembali ikon upload jika semua file dihapus
                    }
                    updateUploadIconVisibility(); // Update visibilitas ikon SVG setelah menghapus gambar
                }
            
                // Fungsi untuk memperbarui pratinjau
                function updatePreview() {
                    photoPreviewContainer.innerHTML = ''; // Hapus pratinjau yang ada
            
                    // Tampilkan kembali foto yang sudah ada
                    existingPhotos.forEach(photo => {
                        const img = document.createElement('div');
                        img.classList.add('relative', 'group');
                        img.innerHTML = `
                            <img src="<?= base_url('uploads/reports/'); ?>${photo}" class="h-auto w-60 object-cover rounded-lg border border-gray-300 shadow-md transition-transform duration-300 hover:scale-105">
                            <button class="absolute top-1 right-1 bg-red-500 text-white text-md rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-300 py-2 px-2.5 text-md" onclick="removeExistingImage('${photo}')"><i class="fas fa-times"></i></button>
                        `;
                        photoPreviewContainer.appendChild(img);
                    });
            
                    // Tampilkan pratinjau untuk file yang baru diunggah
                    uploadedFiles.forEach((file, index) => {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            const img = document.createElement('div');
                            img.classList.add('relative', 'group');
                            img.innerHTML = `
                                <img src="${e.target.result}" class="h-auto w-60 object-cover rounded-lg border border-gray-300 shadow-md transition-transform duration-300 hover:scale-105">
                                <button class="absolute top-1 right-1 bg-red-500 text-white text-md rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-300 py-2 px-2.5 text-md" onclick="removeUploadedFile(${index})"><i class="fas fa-times"></i></button>
                            `;
                            photoPreviewContainer.appendChild(img);
                        };
                        reader.readAsDataURL(file);
                    });
                }
            
                // Fungsi untuk memperbarui visibilitas ikon SVG
                function updateUploadIconVisibility() {
                    // Jika tidak ada foto yang ditampilkan, tampilkan ikon
                    if (existingPhotos.length === 0 && uploadedFiles.length === 0) {
                        uploadIcon.classList.remove('hidden');
                    } else {
                        // Jika ada foto, sembunyikan ikon
                        uploadIcon.classList.add('hidden');
                    }
                }
            </script>

            </form>
        </div>
    </div>
</main>
</div>
</div>
</body>
<?= $this->endSection(); ?>