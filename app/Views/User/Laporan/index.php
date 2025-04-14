<?= $this->extend('layout/user/home/header'); ?>

<?= $this->section('content'); ?>

<!-- Add Form-->
<main class="flex-1 p-6 sm:ml-20">
    <div class="bg-white rounded-lg shadow-sm">
        <!-- Gradient Banner -->
        <div class="bg-gradient-to-r from-[#F98B88] to-[#FFC6C4] h-16 w-full rounded-t-lg"></div>
        <!-- Title -->
        <h2 class="text-center text-2xl font-bold text-gray-800 p-6 md:text-4xl">Form Tambah Laporan</h2>
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

            <form action="<?= base_url('Dashboard/Add-Report') ?>" method="post" enctype="multipart/form-data">
                <?= csrf_field() ?>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <!-- Subject -->
                    <div class="col-span-full">
                        <label class="block text-gray-600 mb-2 text-md font-bold">Subject</label>
                        <input
                            class="w-full p-3 rounded bg-gray-50 text-gray-500 focus:outline-none focus:ring-2 focus:ring-[#fba7a6]"
                            placeholder="Subject Lengkap Kamu" type="text" name="subject" />
                    </div>

                    <!-- isi -->
                    <div class="col-span-full">
                        <label for="Isi" class="block text-gray-600 mb-2 text-md font-bold">Kronologi</label>
                        <div class="mt-2">
                            <textarea id="editor" name="editor" rows="3"
                                class="block w-full p-3 rounded bg-gray-50 text-gray-500 focus:outline-none focus:ring-2 focus:ring-[#fba7a6] placeholder:text-gray-400"
                                placeholder="Tuliskan Segala Masalahmu dan Keluh Kesahmu"></textarea>
                        </div>
                    </div>

                    <!-- Upload Foto -->
                    <div class="col-span-full">
                        <label for="cover-photo" class="block text-gray-600 mb-2 text-md font-bold">Foto</label>
                        <div id="drop-area" class="mt-2 flex justify-center rounded-lg border border-dashed border-gray-900/25 px-6 py-10 max-w-full">
                            <div class="text-center">
                                <div id="photo-preview-container" class="grid grid-cols-1 md:grid-cols-4 lg:grid-cols-4 gap-6 max-w-full mt-4 justify-items-center pb-4"></div>
                                <svg id="upload-icon" class="mx-auto h-12 w-12 text-gray-300 mb-12" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M1.5 6a2.25 2.25 0 012.25-2.25h16.5A2.25 2.25 0 0122.5 6v12a2.25 2.25 0 01-2.25 2.25H3.75A2.25 2.25 0 011.5 18V6zM3 16.06V18c0 .414.336.75.75.75h16.5A.75.75 0 0021 18v-1.94l-2.69-2.689a1.5 1.5 0 00-2.12 0l-.88.879.97.97a.75.75 0 11-1.06 1.06l-5.16-5.159a1.5 1.5 0 00-2.12 0L3 16.061zm10.125-7.81a1.125 1.125 0 112.25 0 1.125 1.125 0 01-2.25 0z" clip-rule="evenodd" />
                                </svg>
                                <div class="mt-4 flex flex-col md:flex-row text-sm leading-6 text-gray-600 mt-12 justify-center">
                                    <label for="file-upload" class="relative cursor-pointer rounded-md bg-white font-semibold text-[#F98B88] focus-within:outline-none focus-within:ring-2 focus-within:ring-[#F98B88] focus-within:ring-offset-2 hover:text-[#F98B88]">
                                        <span>Unggah File Foto Kamu</span>
                                        <input id="file-upload" name="photo[]" type="file" class="sr-only" accept=".jpg,.jpeg,.png" multiple onchange="previewFiles(event)">
                                    </label>
                                    <p class="pl-1">Atau Seret dan Jatuhkan</p>
                                </div>
                                <p class="text-xs leading-5 text-gray-600">PNG, JPG, JPEG up to 10MB</p>
                            </div>
                        </div>
                    </div>



                    <!-- Submit button -->
                    <div class="col-span-full mt-8">
                        <button type="submit"
                            class="w-full p-3 rounded bg-[#F98B88] text-white hover:bg-[#e07574] transition duration-300">
                            Submit
                        </button>
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
    const fileNamesInput = document.createElement('input'); // Hidden input to store filenames
    fileNamesInput.setAttribute('type', 'hidden');
    fileNamesInput.setAttribute('name', 'photo_names'); // Name that will be sent to the backend
    document.forms[0].appendChild(fileNamesInput);

    let uploadedFiles = []; // Array to store uploaded file objects

    // Drag-and-drop event listeners
    dropArea.addEventListener('dragover', (event) => {
        event.preventDefault();
        dropArea.classList.add('border-blue-500');
    });

    dropArea.addEventListener('dragleave', () => {
        dropArea.classList.remove('border-blue-500');
    });

    dropArea.addEventListener('drop', (event) => {
        event.preventDefault();
        dropArea.classList.remove('border-blue-500');
        const files = event.dataTransfer.files;
        if (files.length > 0) {
            handleFileUpload(files);
        }
    });

    fileInput.addEventListener('change', (event) => {
        const files = event.target.files;
        if (files.length > 0) {
            handleFileUpload(files);
        }
    });

    function handleFileUpload(files) {
        const allowedExtensions = ['image/jpeg', 'image/png', 'image/jpg'];
        const maxSize = 10 * 1024 * 1024; // 10MB

        for (let i = 0; i < files.length; i++) {
            const file = files[i];

            if (allowedExtensions.includes(file.type) && file.size <= maxSize) {
                // Create FileReader to preview the image
                const reader = new FileReader();
                reader.onload = function(e) {
                    const img = document.createElement('div');
                    img.classList.add('relative', 'group');
                    img.innerHTML = `
                        <img src="${e.target.result}" class="h-auto w-60 object-cover rounded-lg border border-gray-300 shadow-md transition-transform duration-300 hover:scale-105">
                        <button class="absolute top-1 right-1 bg-red-500 text-white text-md rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-300 py-2 px-2.5 text-md" onclick="removeImage(${uploadedFiles.length})"><i class="fas fa-times"></i></button>
                    `;
                    photoPreviewContainer.appendChild(img);
                };
                reader.readAsDataURL(file);

                // Store the file and its name
                uploadedFiles.push(file);
                updateFileNamesInput();
                uploadIcon.classList.add('hidden'); // Hide upload icon when image is uploaded
            } else {
                alert('File harus berupa PNG, JPG, JPEG, dan ukurannya tidak lebih dari 10MB');
            }
        }

        // Update the file input value to match the new files
        updateFileInput();
    }

    // Remove image from preview and array
    function removeImage(index) {
        uploadedFiles.splice(index, 1);
        updatePreview();
        updateFileNamesInput();
        updateFileInput();

        // Show upload icon if no images left
        if (uploadedFiles.length === 0) {
            uploadIcon.classList.remove('hidden');
        }
    }

    // Update file preview when an image is removed
    function updatePreview() {
        photoPreviewContainer.innerHTML = '';
        uploadedFiles.forEach((file, index) => {
            const reader = new FileReader();
            reader.onload = function(e) {
                const img = document.createElement('div');
                img.classList.add('relative', 'group');
                img.innerHTML = `
                    <img src="${e.target.result}" class="h-auto w-60 object-cover rounded-lg border border-gray-300 shadow-md transition-transform duration-300 hover:scale-105">
                    <button class="absolute top-1 right-1 bg-red-500 text-white text-md rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-300 py-2 px-2.5 text-md" onclick="removeImage(${index})"><i class="fas fa-times"></i></button>
                `;
                photoPreviewContainer.appendChild(img);
            };
            reader.readAsDataURL(file);
        });
    }

    // Update the hidden input with the list of filenames
    function updateFileNamesInput() {
        const fileNames = uploadedFiles.map(file => file.name);
        fileNamesInput.value = JSON.stringify(fileNames); // Send as JSON string
    }

    // Create a new FileList object to update the file input
    function updateFileInput() {
        const dataTransfer = new DataTransfer();

        uploadedFiles.forEach(file => {
            dataTransfer.items.add(file); // Add each file to the DataTransfer object
        });

        fileInput.files = dataTransfer.files; // Update the file input with the new FileList
    }
</script>
<?= $this->endSection(); ?>