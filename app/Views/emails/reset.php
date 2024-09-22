<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
</head>

<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto; padding: 20px;">
    <div style="background-color: #f4f4f4; padding: 20px; border-radius: 5px; text-align: center;">
        <h1 style="color: #4a4a4a;">Forgot Password? Reset Now!</h1>
        <p style="font-size: 16px;">Create a new password to secure your account.</p>
    </div>

    <div style="margin-top: 30px; background-color: #ffffff; padding: 20px; border-radius: 5px; box-shadow: 0 2px 5px rgba(0,0,0,0.1);">
        <h2 style="color: #3498db; text-align: center;">Reset Password</h2>
        <p style="text-align: center;">To reset your password, please click the button below:</p>
        <div style="text-align: center; margin-top: 30px;">
            <a href="<?= $resetLink ?>" style="background-color: #3498db; color: #ffffff; padding: 12px 20px; text-decoration: none; border-radius: 5px; font-weight: bold;">Reset Password</a>
        </div>
    </div>

    <div style="margin-top: 30px; text-align: center; color: #888;">
        <p>If you didn't request a password reset, please ignore this email.</p>
        <p>If you're having trouble with the button above, copy and paste the URL below into your browser:</p>
        <p style="word-break: break-all;"><?= $resetLink ?></p>
    </div>

    <div style="margin-top: 30px; border-top: 1px solid #ddd; padding-top: 20px; text-align: center; font-size: 12px; color: #888;">
        <p>This email was sent automatically. Please do not reply to this email.</p>
        <p>&copy; <?= date('Y') ?> Unit Layanan Terpadu Kekerasan Seksual dan Perundungan</p>
    </div>
</body>

</html>