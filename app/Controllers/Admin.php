<?php

namespace App\Controllers;

use App\Models\Auth_Model;
use App\Models\PostModel;
use App\Models\Comment_Model;

class Admin extends BaseController
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

    public function index(): string
    {
        // Ambil user ID dari session
        $userId = $this->session->get('user_id');

        // Ambil data user berdasarkan ID
        $user = $this->userM->find($userId);

        // Ambil data laporan hanya untuk user yang sedang login
        $data['user'] = $user;
        $data['laporans'] = $this->postM->orderBy('date_create', 'DESC')->findAll();
        $data['title'] = "Dashboard Admin";


        return view("Admin/index.php", $data);
    }
    public function profile()
    {
        // Ambil user ID dari session
        $userId = $this->session->get('user_id');

        // Ambil data user berdasarkan ID
        $user = $this->userM->find($userId);

        $data['user'] = $user;
        $data['title'] = "Profile Admin"; // Gantilah sesuai kebutuhan

        // Kirim data ke view
        return view('Admin/profile', $data);
    }
    public function updateProfile()
    {

        // Validasi input
        $validation = $this->validate([
            'username' => 'required',
            'nama' => 'required',
            'email' => 'required',
            'nomor_hp' => 'required',
            'nim' => 'required',
            'prodi' => 'required',
            'foto' => [
                'mime_in[foto,image/jpg,image/jpeg,image/png]',
                'max_size[foto,1024]',
            ]
        ]);

        if (!$validation) {
            // Jika validasi gagal
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Ambil user ID dari session
        $userId = $this->session->get('user_id'); // Pastikan ID pengguna ada di session

        if (!$userId) {
            return redirect()->back()->with('error', 'User not found');
        }

        // Proses upload file
        $file = $this->request->getFile('foto');

        // Mendapatkan nama foto lama
        $oldPhoto = $this->request->getPost('foto_old');

        if ($file->isValid() && !$file->hasMoved()) {
            // Hapus foto lama jika ada
            if (!empty($oldPhoto) && file_exists('uploads/profile/' . $oldPhoto)) {
                unlink('uploads/profile/' . $oldPhoto);
            }

            // Simpan foto baru
            $newName = $file->getRandomName();
            $file->move('uploads/profile/', $newName);
        } else {
            // Jika tidak ada foto baru, gunakan foto lama
            $newName = $oldPhoto;
        }

        // Update data pengguna di database
        $updateData = [
            'username' => esc($this->request->getPost('username')),
            'nama' => esc($this->request->getPost('nama')),
            'email' => esc($this->request->getPost('email')),
            'nomor_hp' => esc($this->request->getPost('nomor_hp')),
            'nim' => esc($this->request->getPost('nim')),
            'prodi' => esc($this->request->getPost('prodi')),
            'foto' => $newName
        ];

        // Pastikan ID pengguna ada
        if ($userId) {
            $this->userM->update($userId, $updateData);
            return redirect()->to('Admin/Profile')->with('success', 'Profile updated successfully');
        } else {
            return redirect()->back()->with('error', 'User not found');
        }
    }

    public function report_post($encryptedLaporanId)
    {
        $userId = $this->session->get('user_id');

        // Ambil data user berdasarkan ID
        $user = $this->userM->find($userId);

        // $decodedLaporanId = rawurldecode($encryptedLaporanId);
        $laporanId = base64_decode($this->encrypter->decrypt(hex2bin($encryptedLaporanId)));

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

            return view("Admin/comment", $data);
        } else {
            return redirect()->to('/Admin')->with('error', 'Laporan tidak ditemukan.');
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

    public function deleteComment($encryptedId)
    {
        // $decodedLaporanId = rawurldecode($encryptedId);
        $id = base64_decode($this->encrypter->decrypt(hex2bin($encryptedId)));

        // Cari komentar berdasarkan ID komentar
        $komentar = $this->commentM->find($id);

        if ($komentar) {
            // Dapatkan ID laporan terkait komentar ini
            $id_laporan = $komentar['id_laporan'];

            // Hapus komentar berdasarkan ID komentar
            if ($this->commentM->delete($id)) {
                // Redirect kembali ke halaman laporan setelah komentar dihapus
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
