<html>

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title) ?></title>
    <link href="<?= base_url('/css/style.css') ?>" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <link rel="icon" type="image/png" href="<?= base_url('Assets/images/logo vokasi UB vertikal-01 - Crop.png') ?>">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&family=Poppins:wght@400;600&display=swap"
        rel="stylesheet" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" />
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body {
            font-family: "Poppins", sans-serif;
        }

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

<?= $this->include('layout/admin/home/nav-home'); ?>
<?= $this->renderSection('content'); ?>
<?= $this->include('layout/admin/footer'); ?>