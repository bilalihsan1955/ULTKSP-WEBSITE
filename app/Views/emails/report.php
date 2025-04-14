<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pemberitahuan Laporan</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            box-sizing: border-box;
        }

        .email-container {
            background-color: #f4f4f4;
            padding: 20px;
            border-radius: 5px;
            margin-bottom: 20px;
            box-sizing: border-box;
        }

        .email-detail {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
            box-sizing: border-box;
        }

        .btn-view-report {
            background-color: #3498db;
            color: #ffffff;
            padding: 12px 20px;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            display: inline-block;
            margin-top: 30px;
            text-align: center;
        }

        .footer {
            margin-top: 30px;
            text-align: center;
            color: #888;
            font-size: 12px;
            padding: 20px;
            box-sizing: border-box;
        }
    </style>
</head>

<body>
    <div class="email-container">
        <p>Dear <?= esc($admin) ?>,</p>
        <p>Anda telah menerima laporan baru tentang <strong><?= esc($laporan_title) ?></strong>.</p>
    </div>
    <div class="email-detail">
        <h1 style="color: #4a4a4a; text-align: center;">Detail Laporan</h1>
        <p><strong>Pemberi Laporan:</strong> <?= esc($owner_name) ?></p>
        <p><strong>Tanggal Laporan:</strong> <?= date('l, d F Y H:i', strtotime($report_date)) ?></p>
        <p><strong>Judul:</strong> <?= esc($laporan_title) ?></p>
        <p><strong>Isi Laporan:</strong></p>
        <p style="background-color: #f4f4f4; padding: 10px; border-radius: 5px;"><?= nl2br(htmlspecialchars($report_content)) ?></p>
        <p>Untuk melihat laporan lengkap, klik tombol di bawah ini:</p>
        <div style="text-align: center; margin-top: 30px;">
            <a href="<?= $url ?>" style="background-color: #3498db; color: #ffffff; padding: 12px 20px; text-decoration: none; border-radius: 5px; font-weight: bold; display: inline-block;">Lihat Respon</a>
        </div>
    </div>

    <div class="footer">
        <p>Jika Anda tidak mengharapkan email ini, silakan abaikan.</p>
        <p>Jika Anda mengalami masalah dengan tombol di atas, salin dan tempel URL di bawah ini ke browser Anda:</p>
        <p style="word-break: break-all;"><?= $url ?></p>
        <div style="margin: 20px 0; border-top: 1px solid #ddd;"></div>
        <p>Email ini dikirim secara otomatis. Harap tidak membalas email ini.</p>
        <p>&copy; <?= date('Y') ?> Unit Layanan Terpadu untuk Kekerasan Seksual dan Perundungan</p>
    </div>
</body>

</html>