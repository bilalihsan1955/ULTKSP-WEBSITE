<?php

namespace App\Controllers;

use App\Models\Auth_Model;
use App\Models\PostModel;
use App\Models\Comment_Model;
use App\Models\FotoModel;

class post extends BaseController
{
    protected $session;
    protected $userM;
    protected $postM;
    protected $commentM;
    protected $fotoM;
    protected $encrypter;

    public function __construct()
    {
        $this->session = \Config\Services::session();
        $this->userM = new Auth_Model();
        $this->postM = new PostModel();
        $this->commentM = new Comment_Model();
        $this->fotoM = new FotoModel();
        $this->encrypter = \Config\Services::encrypter();
    }

    public function index($encryptedLaporanId)
    {
        $userId = $this->session->get('user_id');

        // Dekode ID laporan yang dienkripsi
        $laporanId = base64_decode($this->encrypter->decrypt(hex2bin($encryptedLaporanId)));

        // Ambil data user berdasarkan ID
        $user = $this->userM->find($userId);

        // Ambil data laporan berdasarkan ID
        $laporan = $this->postM->find($laporanId);

        if ($laporan) {
            // Ambil komentar terkait laporan
            $comments = $this->commentM->select('komentar_laporan.*, users.nama, users.foto, users.username, users.id as user_id')
                ->join('users', 'users.id = komentar_laporan.id_user', 'left')
                ->where('komentar_laporan.id_laporan', $laporanId)
                ->findAll();

            // Ambil foto terkait laporan
            $photos = $this->fotoM->where('id_laporan', $laporanId)->findAll();

            // Kirim data ke view
            $data = [
                'user' => $user,
                'laporan' => $laporan,
                'comments' => $comments, // Tambahkan data komentar
                'photos' => $photos, // Tambahkan data foto
                'title' => esc($laporan['subject'])
            ];

            return view("User/Laporan/post", $data);
        } else {
            return redirect()->to('Dashboard/')->with('error', 'Laporan tidak ditemukan.');
        }
    }

    public function addComment($encryptedLaporanId)
    {
        $validation = $this->validate([
            'editor' => 'required',
        ]);

        if (!$validation) {
            return redirect()->back()->withInput()->with('error', $this->validator->getErrors());
        }

        // Ambil user ID dari session
        $userId = $this->session->get('user_id');

        // Dekode ID laporan yang dienkripsi
        $laporanId = base64_decode($this->encrypter->decrypt(hex2bin($encryptedLaporanId)));

        // Ambil data laporan berdasarkan ID
        $laporan = $this->postM->find($laporanId);

        if (!$userId) {
            return redirect()->back()->with('error', 'User not found');
        }

        // Ambil data user yang berkomentar
        $user = $this->userM->find($userId);

        // Data komentar
        $reportData = [
            'id_user' => $userId,
            'id_laporan' => $laporanId,
            'isi' => esc($this->request->getPost('editor')),
        ];

        // Simpan komentar
        $this->commentM->save($reportData);

        // Kirim email ke semua admin
        $admins = $this->userM->where('role', 'admin')->findAll();
        foreach ($admins as $admin) {
            $this->_sendCommentEmail($admin['email'], $laporan, $user['nama'], $admin['nama'], $reportData['isi']);
        }

        return redirect()->back()->with('success', 'Comment submitted and emails sent to all admins successfully.');
    }

    private function _sendCommentEmail($recipientEmail, $laporan, $commenter, $ownername, $commentContent)
    {
        $email = \Config\Services::email();

        // Konfigurasi email
        $email->setFrom('moko1@dotsnusa.com', 'ULTKSP VOKASI UB');
        $email->setTo($recipientEmail);
        $encrypter = \Config\Services::encrypter();
        $encryptedLaporanId = bin2hex($encrypter->encrypt(base64_encode($laporan['id'])));
        $email->setSubject('Laporan Baaru :' . $laporan['subject']);

        // Generate link ke laporan
        $reportLink = site_url("/Admin/Detail-Laporan/" . url_title(ucwords($laporan['subject']), '-', FALSE) . '/' . $encryptedLaporanId);

        // Siapkan konten email
        $emailContent = view('emails/comment_notification', [
            'laporan_title' => $laporan['subject'],
            'commenter' => $commenter,
            'ownername' => $ownername,
            'comment_date' => date('Y-m-d H:i:s'),
            'comment_content' => $commentContent,
            'url' => $reportLink
        ]);

        // Set konten email
        $email->setMessage($emailContent);

        // Kirim email
        if (!$email->send()) {
            // Log error jika gagal
            return redirect()->back()->with('error', 'Failed to send comment email to: ' . $recipientEmail);
        }
    }

    public function delete($encryptedLaporanId)
    {
        // Dekode ID laporan yang dienkripsi
        $laporanId = base64_decode($this->encrypter->decrypt(hex2bin($encryptedLaporanId)));
        $laporan = $this->postM->find($laporanId);

        if ($laporan) {
            // Path ke folder tempat foto disimpan
            $fotoPath = 'uploads/reports/';

            // Ambil semua foto terkait laporan dari tabel foto
            $fotoList = $this->fotoM->where('id_laporan', $laporanId)->findAll();

            // Loop melalui setiap foto untuk menghapus file dan data dari tabel
            foreach ($fotoList as $foto) {
                $filePath = $fotoPath . $foto['file_name'];

                // Cek apakah file foto ada, jika ada maka hapus
                if (is_file($filePath)) {
                    unlink($filePath);
                }

                // Hapus data foto dari tabel
                $this->fotoM->delete($foto['id']);
            }

            // Hapus komentar terkait dari database
            $this->commentM->where('id_laporan', $laporanId)->delete();

            // Hapus data laporan dari database
            $this->postM->delete($laporanId);

            return redirect()->to('Dashboard/')->with('success', 'Laporan dan foto terkait berhasil dihapus.');
        } else {
            return redirect()->to('Dashboard/')->with('error', 'Laporan tidak ditemukan.');
        }
    }


    public function deleteComment($encryptedcommentId)
    {
        // $decodedcommentId = rawurldecode($encryptedcommentId);
        $commentId = base64_decode($this->encrypter->decrypt(hex2bin($encryptedcommentId)));

        // Cari komentar berdasarkan ID komentar
        $komentar = $this->commentM->find($commentId);

        if ($komentar) {
            // Dapatkan ID comment terkait komentar ini
            $id_laporan = $komentar['id_laporan'];

            // Hapus komentar berdasarkan ID komentar
            if ($this->commentM->delete($commentId)) {
                // Redirect kembali ke halaman comment setelah komentar dihapus
                return redirect()->back()->with('success', 'Komentar berhasil dihapus.');
            } else {
                // Jika penghapusan gagal
                return redirect()->back()->with('error', 'Gagal menghapus komentar.');
            }
        } else {
            // Jika komentar tidak ditemukan, kembalikan ke halaman laporan
            return redirect()->back()->with('error', 'Komentar tidak ditemukan.');
        }
    }
}
