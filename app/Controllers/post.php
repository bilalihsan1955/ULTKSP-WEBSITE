<?php

namespace App\Controllers;

use App\Models\Auth_Model;
use App\Models\PostModel;
use App\Models\Comment_Model;

class post extends BaseController
{
    protected $session;
    protected $userM;
    protected $postM;
    protected $commentM;
    protected $encrypter;

    public function __construct()
    {
        $this->session = \Config\Services::session();
        $this->userM = new Auth_Model();
        $this->postM = new PostModel();
        $this->commentM = new Comment_Model();
        $this->encrypter = \Config\Services::encrypter();
    }

    public function index($encryptedLaporanId)
    {
        $userId = $this->session->get('user_id');

        // $decodedLaporanId = rawurldecode($encryptedLaporanId);
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

            // Kirim data ke view
            $data = [
                'user' => $user,
                'laporan' => $laporan,
                'comments' => $comments, // Tambahkan data komentar
                'title' => esc($laporan['subject'])
            ];

            return view("Report/post", $data);
        } else {
            return redirect()->to('/')->with('error', 'Laporan tidak ditemukan.');
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
        $userId = $this->session->get('user_id'); // Pastikan ID pengguna ada di session

        // $decodedLaporanId = rawurldecode($encryptedLaporanId);
        $laporanId = base64_decode($this->encrypter->decrypt(hex2bin($encryptedLaporanId)));

        // Ambil data laporan berdasarkan ID
        $laporan = $this->postM->find($laporanId);

        if (!$userId) {
            return redirect()->back()->with('error', 'User not found');
        }

        $reportData = [
            'id_user' => $userId,
            'id_laporan' => $laporanId,
            'isi' => esc($this->request->getPost('editor')),
        ];

        $this->commentM->save($reportData);

        return redirect()->back()->with('success', 'Comments submitted successfully');
    }

    public function addReport()
    {
        $validation = $this->validate([
            'subject' => 'required',
            'editor' => 'required',
            'photo' => [
                'uploaded[photo]',
                'mime_in[photo,image/jpg,image/jpeg,image/png]',
                'max_size[photo,1024]',
            ]
        ]);

        if (!$validation) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Ambil user ID dari session
        $userId = $this->session->get('user_id'); // Pastikan ID pengguna ada di session

        if (!$userId) {
            return redirect()->back()->with('error', 'User not found');
        }

        $file = $this->request->getFile('photo');
        $newName = $file->isValid() && !$file->hasMoved() ? $file->getRandomName() : '';

        if ($file->isValid() && !$file->hasMoved()) {
            $file->move('uploads/reports/', $newName);
        }

        $reportData = [
            'id_user' => $userId,
            'subject' => esc($this->request->getPost('subject')),
            'isi' => esc($this->request->getPost('editor')),
            'foto_file' => $newName,
        ];

        $this->postM->save($reportData);
        return redirect()->to('/')->with('success', 'Report submitted successfully');
    }

    public function post(): string
    {
        // return view('welcome_message');
        return view("report/post");
    }

    public function delete($encryptedLaporanId)
    {
        // $decodedLaporanId = rawurldecode($encryptedLaporanId);
        $laporanId = base64_decode($this->encrypter->decrypt(hex2bin($encryptedLaporanId)));
        $laporan = $this->postM->find($laporanId);

        if ($laporan) {
            // Path ke folder tempat foto disimpan
            $fotoPath = 'uploads/reports/' . $laporan['foto_file'];

            // Cek apakah file foto ada, jika ada maka hapus
            if (is_file($fotoPath)) {
                unlink($fotoPath);
            }

            // Hapus komentar terkait dari database
            $this->commentM->where('id_laporan', $laporanId)->delete();

            // Hapus data laporan dari database
            $this->postM->delete($laporanId);

            return redirect()->to('/')->with('success', 'Laporan deleted successfully.');
        } else {
            return redirect()->to('/')->with('error', 'Laporan not found.');
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
