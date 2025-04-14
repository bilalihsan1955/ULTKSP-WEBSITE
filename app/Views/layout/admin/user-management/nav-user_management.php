<body class="relative bg-slate-50 overflow-x-hidden w-full">
    <div class="absolute inset-0 -z-10 overflow-hidden flex flex-col justify-between">
        <!-- Background Blur Circles -->
        <div class="absolute -top-16 -left-16 w-40 h-40 bg-teal-300 opacity-30 rounded-full blur-3xl sm:w-32 sm:h-32 sm:-top-8 sm:-left-8"></div>
        <div class="absolute top-32 left-20 w-72 h-72 bg-[#ffabf0] opacity-40 rounded-full blur-2xl sm:w-52 sm:h-52 sm:left-10"></div>
        <div class="absolute top-16 right-16 w-64 h-64 bg-[#ffd700] opacity-20 rounded-full blur-2xl sm:w-48 sm:h-48 sm:right-8"></div>
        <div class="absolute top-60 -left-20 w-96 h-96 bg-teal-400 opacity-15 rounded-full blur-3xl sm:w-72 sm:h-72 sm:-left-10"></div>
        <div class="absolute bottom-32 left-8 w-48 h-48 bg-[#8affc1] opacity-50 rounded-full blur-3xl sm:w-36 sm:h-36 sm:left-4"></div>
        <div class="absolute bottom-16 right-24 w-64 h-64 bg-[#ff90ff] opacity-25 rounded-full blur-3xl sm:w-48 sm:h-48 sm:right-12"></div>
        <div class="absolute bottom-0 -right-40 w-80 h-80 bg-[#ffa07a] opacity-30 rounded-full blur-2xl sm:w-64 sm:h-64 sm:-right-24"></div>

        <!-- Additional Colors for Background Blur Circles -->
        <div class="absolute top-24 right-40 w-56 h-56 bg-[#7fffd4] opacity-30 rounded-full blur-2xl sm:w-40 sm:h-40 sm:right-20"></div>
        <div class="absolute bottom-48 left-16 w-72 h-72 bg-[#ffc0cb] opacity-35 rounded-full blur-2xl sm:w-52 sm:h-52 sm:left-8"></div>
        <div class="absolute top-0 right-12 w-48 h-48 bg-[#98fb98] opacity-20 rounded-full blur-3xl sm:w-36 sm:h-36 sm:right-6"></div>
        <div class="absolute bottom-24 left-32 w-64 h-64 bg-[#87ceeb] opacity-40 rounded-full blur-3xl sm:w-48 sm:h-48 sm:left-16"></div>

        <!-- New Ornaments on the Right -->
        <div class="absolute top-16 right-10 w-72 h-72 bg-[#add8e6] opacity-25 rounded-full blur-2xl sm:w-56 sm:h-56 sm:right-5"></div>
        <div class="absolute bottom-32 right-10 w-56 h-56 bg-[#d3d3d3] opacity-30 rounded-full blur-3xl sm:w-44 sm:h-44 sm:right-5"></div>
    </div>

    <div class="min-h-screen flex flex-col">
        <!-- Header -->
        <header class="py-4 px-8 pb-0 flex justify-between w-full items-center md:pr-8 md:pl-20 sm:px-2 sm:mr-0">
            <div class="flex items-center sm:pl-6">
                <div class="flex flex-row items-center">
                    <img alt="Logo" class="w-16 h-16 rounded-m mr-2 lg:mb-0 p-2 sm:w-16 sm:h-16"
                        src="<?= base_url('/Assets/images/LogoUB.png') ?>" />
                    <div class="flex flex-col text-xl text-gray-800 font-bold md:text-lg lg:text-2xl md:flex-row">
                        <h6 class="text-[#F98B88] pr-1">ULTKSP</h6>
                        <h6>Vokasi UB</h6>
                    </div>
                </div>
            </div>
            <div class="flex items-center md:pr-0 sm:pr-0">
                <button
                    class="block hover:text-[#ee4645] sm:hidden text-gray-500 pr-0 p-4 rounded-full focus:outline-none"
                    id="hamburger">
                    <span class="material-symbols-rounded text-3xl">menu</span>
                </button>
                <div class="flex items-center">
                    <?php if (!empty($user['foto'])) : ?>
                        <a href="<?= base_url('Admin/Profile/' . $user['username']) ?>">
                            <img alt="User profile picture" class="w-12 h-12 rounded-md hidden sm:block object-cover aspect-square"
                                src="<?= base_url('uploads/profile/' . $user['foto']) ?>" />
                        </a>
                    <?php else : ?>
                        <a href="<?= base_url('Admin/Profile/' . $user['username']) ?>">
                            <div class="bg-red-500 text-white w-12 h-12 rounded-md hidden sm:flex items-center justify-center text-lg">
                                <?= strtoupper($user['username'][0]); ?>
                            </div>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <div class="flex flex-1 relative">
            <!-- Sidebar -->
            <aside id="sidebar"
                class="fixed top-1/2 left-0 transform -translate-y-1/2 flex flex-col items-center z-10 w-20 hidden sm:flex rounded-r-lg sm:w-20">
                <a href="<?= base_url('/Admin') ?>"
                    class="bg-slate-50/20 text-gray-500 rounded-r-lg text-xl hover:text-[#ee4645] focus:text-pink-700 hover:bg-[#fef2f2]/40 focus:bg-[#fee2e2] w-full py-6 transition duration-300 flex justify-center transition-transform duration-300 hover:scale-125"
                    aria-current="page">
                    <button class="w-full h-full">
                        <span class="material-symbols-rounded">home</span>
                    </button>
                </a>
                <a href="<?= base_url('/Admin') ?>"
                    class="text-[#ee4645] bg-[#fee2e2] backdrop-blur-sm rounded-r-lg text-xl focus:text-pink-700 focus:bg-[#fee2e2] w-full py-6 transition duration-300 flex justify-center transition-transform transform hover:scale-125"
                    aria-current="page">
                    <button class="w-full h-full">
                        <span class="material-symbols-rounded">groups</span>
                    </button>
                </a>
                <a href="<?= base_url('Admin/Profile/' . $user['username']) ?>"
                    class="bg-slate-50/20 text-gray-500 rounded-r-lg text-xl hover:text-[#ee4645] focus:text-pink-700 hover:bg-[#fef2f2]/40 focus:bg-[#fee2e2] w-full py-6 transition duration-300 flex justify-center transition-transform transform hover:scale-125">
                    <button class="w-full h-full">
                        <span class="material-symbols-rounded">account_circle</span>
                    </button>
                </a>
                <a href=""
                    class="signout-btn bg-slate-50/20 text-gray-500 rounded-r-lg text-xl hover:text-[#ee4645] focus:text-pink-700 hover:bg-[#fef2f2]/40 focus:bg-[#fee2e2] w-full py-6 transition duration-300 flex justify-center transition-transform transform hover:scale-125">
                    <button class="w-full h-full">
                        <span class="material-symbols-rounded">logout</span>
                    </button>
                </a>
            </aside>

            <!-- Mobile Sidebar -->
            <aside id="mobile-sidebar"
                class="fixed top-1/2 right-0 transform -translate-y-1/2 bg-white/20 backdrop-blur-md shadow-xl rounded-l-lg flex flex-col items-center z-10 w-20 hidden pt-4 md:hidden sm:hidden">
                <img alt="User profile picture" class="w-10 h-10 rounded-full mb-4" height="40" src="<?= base_url('/Assets/images/LogoUB.png') ?>"
                    width="40" />

                <a href="<?= base_url('Admin/Admin/') ?>"
                    class="text-gray-400 text-xl hover:text-[#ee4645] focus:text-pink-700 hover:bg-[#fee2e2]/20 backdrop-blur-sm w-full py-4 transition duration-300 flex justify-center items-center h-16">
                    <span class="material-symbols-rounded">home</span>
                </a>

                <a href="<?= base_url('/Admin') ?>"
                    class="text-[#ee4645] text-xl hover:text-[#ee4645] focus:text-pink-700 bg-[#fee2e2]/60 backdrop-blur-sm w-full py-4 transition duration-300 flex justify-center items-center h-16">
                    <span class="material-symbols-rounded">groups</span>
                </a>

                <a href="<?= base_url('Admin/Profile/' . $user['username']) ?>"
                    class="text-gray-400 text-xl hover:text-[#ee4645] focus:text-pink-700 hover:bg-[#fee2e2]/20 backdrop-blur-sm w-full py-4 transition duration-300 flex justify-center items-center h-16">
                    <span class="material-symbols-rounded">account_circle</span>
                </a>

                <a href=""
                    class="signout-btn text-gray-400 text-xl hover:text-[#ee4645] focus:text-pink-700 hover:bg-[#fee2e2]/20 backdrop-blur-sm w-full py-4 transition duration-300 flex justify-center items-center h-16">
                    <span class="material-symbols-rounded">logout</span>
                </a>
            </aside>
        </div>