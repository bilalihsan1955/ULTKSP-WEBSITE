<footer class="bg-white shadow-sm py-6 px-6 mt-4">
    <div class="flex flex-col lg:flex-row justify-between mt-4 space-y-2 lg:space-y-0 lg:items-center">
        <p class="text-gray-500 text-sm lg:text-base">Developed by <span
                class="text-[#fcc153] font-semibold">Provoks</span> Community</p>
        <p class="text-gray-500 text-sm lg:text-base">Copyright 2024. Tim ULTKSP Vokasi UB. All Rights
            Reserved.</p>
    </div>
</footer>

<script>
    document.getElementById('hamburger').addEventListener('click', function() {
        var sidebar = document.getElementById('mobile-sidebar');
        sidebar.classList.toggle('hidden'); // Toggles visibility of the sidebar
    });

    // Menutup sidebar ketika mengklik di luar sidebar
    document.addEventListener('click', function(event) {
        var sidebar = document.getElementById('mobile-sidebar');
        var hamburger = document.getElementById('hamburger');

        // Memeriksa jika klik terjadi di luar sidebar dan tombol hamburger
        if (!sidebar.contains(event.target) && !hamburger.contains(event.target) && !sidebar.classList.contains('hidden')) {
            sidebar.classList.add('hidden'); // Menutup sidebar
        }
    });

    // Dapatkan elemen dengan id masing-masing
    const hariElement = document.getElementById("hari");
    const tanggalElement = document.getElementById("tanggal");
    const bulanElement = document.getElementById("bulan");
    const tahunElement = document.getElementById("tahun");

    // Fungsi untuk mendapatkan dan menampilkan hari, tanggal, bulan, dan tahun
    function tampilkanTanggalLengkap() {
        const sekarang = new Date();

        // Mendapatkan hari, tanggal, bulan, dan tahun
        const hari = sekarang.toLocaleDateString("id-ID", {
            weekday: "long"
        });
        const tanggal = sekarang.getDate();
        const bulan = sekarang.toLocaleDateString("id-ID", {
            month: "long"
        });
        const tahun = sekarang.getFullYear();

        // Menampilkan hasil di halaman
        hariElement.textContent = hari;
        tanggalElement.textContent = tanggal;
        bulanElement.textContent = bulan;
        tahunElement.textContent = tahun;
    }

    // Panggil fungsi untuk menampilkan tanggal lengkap
    tampilkanTanggalLengkap();

    function tampilkanSalam() {
        const sekarang = new Date();
        const jam = sekarang.getHours();
        let salam;

        // Tentukan salam berdasarkan waktu
        if (jam >= 4 && jam < 12) {
            salam = "Selamat Pagi";
        } else if (jam >= 12 && jam < 15) {
            salam = "Selamat Siang";
        } else if (jam >= 15 && jam < 18) {
            salam = "Selamat Sore";
        } else {
            salam = "Selamat Malam";
        }

        // Tampilkan salam di elemen #salam
        document.getElementById('salam').textContent = salam;
    }

    // Panggil fungsi untuk menampilkan salam
    tampilkanSalam();
</script>

<script>
    // Menambahkan event listener ke semua elemen dengan kelas 'signout-btn'
    document.querySelectorAll('.signout-btn').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault(); // Mencegah aksi default link

            Swal.fire({
                title: '<span class="text-lg md:text-xl lg:text-2xl font-bold">Apakah Anda yakin ingin keluar?</span>',
                html: '<p class="text-sm md:text-base lg:text-lg">Kami ada di sini untuk membantu. Anda selalu dapat kembali kapan saja.</p>',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: '<span class="text-sm md:text-base lg:text-lg">Ya, keluar</span>',
                cancelButtonText: '<span class="text-sm md:text-base lg:text-lg">Tidak, tetap di sini</span>',
                customClass: {
                    confirmButton: 'bg-red-500 hover:bg-red-600 text-white rounded px-4 py-2 text-sm md:text-base lg:text-lg',
                    cancelButton: 'bg-green-500 hover:bg-green-600 text-white rounded px-4 py-2 text-sm md:text-base lg:text-lg'
                },
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: '<span class="text-lg md:text-xl lg:text-2xl font-bold">Anda telah keluar</span>',
                        html: '<p class="text-sm md:text-base lg:text-lg">Kami harap Anda baik-baik saja. Jangan ragu untuk kembali jika membutuhkan bantuan.</p>',
                        icon: 'info',
                        confirmButtonText: '<span class="text-sm md:text-base lg:text-lg">Oke, terima kasih</span>',
                        customClass: {
                            confirmButton: 'bg-blue-500 hover:bg-blue-600 text-white rounded px-4 py-2 text-sm md:text-base lg:text-lg',
                        },
                    }).then(() => {
                        window.location.href = '<?= base_url('/SignOut') ?>'; // Redirect ke URL logout
                    });
                }
            });
        });
    });
</script>

<script>
    function confirmDelete(id) {
        event.preventDefault();
        Swal.fire({
            title: '<span class="text-lg md:text-xl lg:text-2xl font-bold">Apakah Anda yakin ingin menghapus laporan?</span>',
            html: '<p class="text-sm md:text-base lg:text-lg">Anda tidak dapat mengembalikan data ini!</p>',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: '<span class="text-sm md:text-base lg:text-lg">Ya, hapus!</span>',
            cancelButtonText: '<span class="text-sm md:text-base lg:text-lg">Tidak, batal</span>',
            customClass: {
                confirmButton: 'bg-red-500 hover:bg-red-600 text-white rounded px-4 py-2 text-sm md:text-base lg:text-lg',
                cancelButton: 'bg-green-500 hover:bg-green-600 text-white rounded px-4 py-2 text-sm md:text-base lg:text-lg'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "" + id;
            }
        });
    }
</script>

<script>
    function confirmDeleteComment(id) {
        event.preventDefault();
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Anda tidak dapat mengembalikan data ini!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, hapus!',
            customClass: {
                confirmButton: "btn btn-success",
                cancelButton: "btn btn-danger"
            }
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "<?= base_url(''); ?>" + id;
            }
        })
    }
</script>

<?php if (session()->getFlashdata('success')) : ?>
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Sukses',
            text: '<?= session()->getFlashdata('success'); ?>'
        });
    </script>
<?php endif; ?>

<?php if (session()->getFlashdata('error')) : ?>
    <script>
        Swal.fire({
            icon: 'warning',
            title: 'Error',
            text: '<?= session()->getFlashdata('error'); ?>'
        });
    </script>
<?php endif; ?>

<script>
    document.querySelector('form').addEventListener('submit', function(event) {
        event.preventDefault(); // Mencegah form di-submit langsung

        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Anda akan mengirimkan laporan ini!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, kirim!',
            cancelButtonText: 'Batal',
            customClass: {
                confirmButton: "btn btn-success",
                cancelButton: "btn btn-danger"
            }
        }).then((result) => {
            if (result.isConfirmed) {
                // Jika user menekan tombol "Ya, kirim", submit form
                this.submit();
            }
        });
    });
</script>

<script>
    // Fungsi untuk toggle dropdown
    function toggleDropdown() {
        var dropdownOptions = document.getElementById('dropdownOptions');
        dropdownOptions.classList.toggle('hidden');
    }

    // Fungsi untuk memilih opsi
    function selectOption(value) {
        // Set nilai yang dipilih ke dalam span dropdown
        document.getElementById('dropdownSelected').textContent = value;

        // Set nilai yang dipilih ke dalam input hidden
        document.getElementById('dropdownValue').value = value;

        // Sembunyikan dropdown setelah pilihan dipilih
        document.getElementById('dropdownOptions').classList.add('hidden');
    }

    // Fungsi untuk menutup dropdown ketika klik di area luar
    document.addEventListener('click', function(event) {
        var dropdownBtn = document.getElementById('dropdownBtn');
        var dropdownOptions = document.getElementById('dropdownOptions');

        // Cek apakah klik terjadi di luar tombol dropdown dan menu dropdown
        if (!dropdownBtn.contains(event.target) && !dropdownOptions.contains(event.target)) {
            dropdownOptions.classList.add('hidden'); // Sembunyikan dropdown
        }
    });
</script>
<?php if (session()->getFlashdata('success')) : ?>
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Sukses',
            text: '<?= session()->getFlashdata('success'); ?>'
        });
    </script>
<?php endif; ?>

<?php if (session()->getFlashdata('error')) : ?>
    <script>
        Swal.fire({
            icon: 'warning',
            title: 'Error',
            text: '<?= session()->getFlashdata('error'); ?>'
        });
    </script>
<?php endif; ?>
<script>
    // Fungsi untuk menutup alert
    function closeAlert() {
        document.getElementById('alert').style.display = 'none';
    }

    // Menyembunyikan alert setelah 5 detik
    setTimeout(closeAlert, 10000);
</script>
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
<script>
    function autoResize(textarea) {
        // Reset the height to allow shrinking
        textarea.style.height = 'auto';
        // Set the height based on the content
        textarea.style.height = textarea.scrollHeight + 'px';
    }

    // Apply autoResize function when input occurs
    document.getElementById('editor').addEventListener('input', function() {
        autoResize(this);
    });

    // Call autoResize on page load for pre-filled content
    window.onload = function() {
        var textarea = document.getElementById('editor');
        autoResize(textarea);
    };
</script>

</html>