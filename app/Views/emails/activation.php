<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aktivasi Akun</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto; padding: 20px;">
    <div style="background-color: #f4f4f4; padding: 20px; border-radius: 5px; text-align: center;">
        <h1 style="color: #4a4a4a;">Selamat Datang!</h1>
        <p style="font-size: 16px;">Anda hanya selangkah lagi untuk mengaktifkan akun Anda.</p>
    </div>
    
    <div style="margin-top: 30px; background-color: #ffffff; padding: 20px; border-radius: 5px; box-shadow: 0 2px 5px rgba(0,0,0,0.1);">
        <h2 style="color: #3498db; text-align: center;">Aktivasi Akun</h2>
        <p style="text-align: center;">Untuk mengaktifkan akun Anda, silakan klik tombol di bawah ini:</p>
        <div style="text-align: center; margin-top: 30px;">
            <a href="<?= $activationLink ?>" style="background-color: #3498db; color: #ffffff; padding: 12px 20px; text-decoration: none; border-radius: 5px; font-weight: bold;">Aktifkan Akun</a>
        </div>
    </div>
    
    <div style="margin-top: 30px; text-align: center; color: #888;">
        <p>Jika Anda tidak mendaftar, silakan abaikan email ini.</p>
        <p>Jika Anda mengalami masalah dengan tombol di atas, salin dan tempel URL di bawah ini ke browser Anda:</p>
        <p style="word-break: break-all;"><?= $activationLink ?></p>
    </div>
    
    <div style="margin-top: 30px; border-top: 1px solid #ddd; padding-top: 20px; text-align: center; font-size: 12px; color: #888;">
        <p>Email ini dikirim secara otomatis. Harap tidak membalas email ini.</p>
        <p>&copy; <?= date('Y') ?> Unit Layanan Terpadu untuk Kekerasan Seksual dan Perundungan</p>
    </div>
</body>
</html>
