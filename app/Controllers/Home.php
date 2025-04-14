<?php

namespace App\Controllers;

use App\Models\Auth_Model;
use App\Models\PostModel;
use CodeIgniter\HTTP\RedirectResponse;

class Home extends BaseController
{
    protected $session;
    protected $userM;
    protected $postM;

    public function __construct()
    {
        $this->session = \Config\Services::session();
        $this->userM = new Auth_Model();
        $this->postM = new PostModel();
    }
    public function index(): string
    {
        // Ambil user ID dari session
        $userId = $this->session->get('user_id');

        // Ambil data user berdasarkan ID
        $user = $this->userM->find($userId);

        // Ambil data laporan hanya untuk user yang sedang login
        $data['laporans'] = $this->postM->getLaporanWithUser($userId);
        $data['user'] = $user;

        // Set title secara dinamis
        $data['title'] = "Dashboard User"; // Gantilah sesuai kebutuhan

        return view("User/index", $data);
    }

    public function profile()
    {
        // Ambil user ID dari session
        $userId = $this->session->get('user_id');

        // Ambil data user berdasarkan ID
        $user = $this->userM->find($userId);

        // Set title secara dinamis
        $data['user'] = $user;
        $data['title'] = "Profile User"; // Gantilah sesuai kebutuhan

        // Kirim data ke view
        return view('User/profile', $data);
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
            $username = session()->get('username');
            return redirect()->to('Dashboard/Profile/' . $username)->with('success', 'Profile updated successfully');
        } else {
            return redirect()->back()->with('error', 'User not found');
        }
    }
}
