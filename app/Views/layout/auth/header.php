<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title><?= esc($title) ?></title>
    <!-- icon tab -->
    <link rel="icon" type="image/png" href="<?= base_url('Assets/images/logo vokasi UB vertikal-01 - Crop.png') ?>">
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet" />
    <link href="<?= base_url('/css/style.css') ?>" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" />
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        Poppins: ['Poppins'],
                    },
                },
            },
        };
    </script>
    <style>
        /* Style scrollbar */
        ::-webkit-scrollbar {
            width: 0.75rem;
            /* height: 0.75rem; */
        }

        /* Track of the scrollbar */
        ::-webkit-scrollbar-track {
            background-color: #FFC6C4;
            /* Soft pink */
        }

        /* Thumb of the scrollbar */
        ::-webkit-scrollbar-thumb {
            background-color: #e77b8c;
            /* Light pink */
            border-radius: 0.175rem;
            /* border: 0.25rem solid #f8e1e7; */
        }

        /* Hover effect */
        ::-webkit-scrollbar-thumb:hover {
            background-color: #d95c73;
            /* Slightly darker pink on hover */
        }
    </style>
</head>

<body class="bg-white max-h-screen">
    <div class="absolute top-0 -z-10 h-full w-full bg-white overflow-hidden">
        <div
            class="absolute bottom-auto left-auto right-0 top-0 h-[300px] w-[300px] translate-x-[-20%] translate-y-[50%] md:h-[500px] md:w-[500px] md:-translate-x-[80%] md:translate-y-[10%] rounded-full bg-[#F98B88] opacity-20 blur-[80px]"></div>
        <div
            class="absolute top-[20%] left-0 h-[200px] w-[200px] md:h-[400px] md:w-[400px] translate-x-[-30%] translate-y-[0%] rounded-full bg-[#F98B88] opacity-20 blur-[80px]">
        </div>
        <div
            class="absolute bottom-[20%] right-[20%] h-[150px] w-[150px] md:h-[300px] md:w-[300px] translate-x-[50%] translate-y-[50%] rounded-full bg-[#FFC6C4] opacity-20 blur-[80px]">
        </div>
        <div
            class="absolute top-[10%] right-0 h-[100px] w-[100px] md:h-[250px] md:w-[250px] translate-x-[30%] translate-y-[10%] rounded-full bg-[#87CEFA] opacity-30 blur-[50px]">
        </div>
        <div
            class="absolute bottom-0 left-[10%] h-[120px] w-[120px] md:h-[220px] md:w-[220px] translate-x-[-50%] translate-y-[30%] rounded-full bg-[#98FB98] opacity-25 blur-[60px]">
        </div>
        <div
            class="absolute top-[70%] left-[30%] h-[80px] w-[80px] md:h-[180px] md:w-[180px] translate-x-[-20%] translate-y-[-40%] rounded-full bg-[#FFD700] opacity-30 blur-[40px]">
        </div>
        <div
            class="absolute bottom-[10%] right-0 h-[90px] w-[90px] md:h-[200px] md:w-[200px] translate-x-[40%] translate-y-[20%] rounded-full bg-[#8A2BE2] opacity-25 blur-[70px]">
        </div>
        <div
            class="absolute top-[50%] left-[60%] h-[110px] w-[110px] md:h-[220px] md:w-[220px] translate-x-[-40%] translate-y-[-20%] rounded-full bg-[#FFB6C1] opacity-30 blur-[50px]">
        </div>
    </div>

    <?= $this->renderSection('content'); ?>
    <?= $this->include('layout/auth/footer'); ?>