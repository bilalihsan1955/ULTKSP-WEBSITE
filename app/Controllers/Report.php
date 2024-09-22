<?php

namespace App\Controllers;

use App\Models\Auth_Model;
use App\Models\PostModel;

class Report extends BaseController
{
    protected $session;
    protected $userM;
    protected $postM;
    protected $encrypter;

    public function __construct()
    {
        $this->session = \Config\Services::session();
        $this->userM = new Auth_Model();
        $this->postM = new PostModel();
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

        // Set title secara dinamis
        $data['title'] = "Add Report"; // Gantilah sesuai kebutuhan

        return view("Report/index",  $data);
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

    public function editpost($encryptedLaporanId)
    {
        $userId = $this->session->get('user_id');

        // $decodedLaporanId = rawurldecode($encryptedLaporanId);
        $laporanId = base64_decode($this->encrypter->decrypt(hex2bin($encryptedLaporanId)));

        // Ambil data user berdasarkan ID
        $user = $this->userM->find($userId);

        // Ambil data laporan berdasarkan ID
        $laporan = $this->postM->find($laporanId);

        if ($laporan) {

            // Kirim data ke view
            $data = [
                'user' => $user,
                'laporan' => $laporan,
                'title' => "Edit Report: " . esc($laporan['subject'])
            ];

            return view("report/reportEdit", $data);
        } else {
            return redirect()->to('/')->with('error', 'Laporan tidak ditemukan.');
        }
    }

    public function updatepost($encryptedLaporanId)
    {
        // Validasi input
        $validation = $this->validate([
            'subject' => 'required',
            'editor' => 'required',
            'foto' => [
                'mime_in[foto,image/jpg,image/jpeg,image/png]',
                'max_size[foto,1024]',
            ]
        ]);

        if (!$validation) {
            // Jika validasi gagal
            return redirect()->back()->withInput()->with('error', $this->validator->getErrors());
        }

        // $decodedLaporanId = rawurldecode($encryptedLaporanId);
        $laporanId = base64_decode($this->encrypter->decrypt(hex2bin($encryptedLaporanId)));
        
        // Ambil user ID dari session atau dari parameter
        $postId = $laporanId;

        if (!$postId) {
            return redirect()->back()->with('error', 'Post not found');
        }

        // Proses upload file
        $file = $this->request->getFile('foto');

        // Mendapatkan nama foto lama
        $oldPhoto = $this->request->getPost('foto_old');

        if ($file->isValid() && !$file->hasMoved()) {
            // Hapus foto lama jika ada
            if (!empty($oldPhoto) && file_exists('uploads/reports/' . $oldPhoto)) {
                unlink('uploads/reports/' . $oldPhoto);
            }

            // Simpan foto baru
            $newName = $file->getRandomName();
            $file->move('uploads/reports/', $newName);
        } else {
            // Jika tidak ada foto baru, gunakan foto lama
            $newName = $oldPhoto;
        }

        // Update data pengguna di database
        $updateData = [
            'subject' => esc($this->request->getPost('subject')),
            'isi' => esc($this->request->getPost('editor')),
            'foto_file' => $newName,
            'date_edit' => date('Y-m-d H:i:s') // Simpan waktu edit
        ];

        // Pastikan ID pengguna ada
        if ($postId) {
            $this->postM->update($postId, $updateData);
            return redirect()->to('/')->with('success', 'Report Updated successfully');
        } else {
            return redirect()->back()->with('error', 'Report Updated failed');
        }
    }
}
