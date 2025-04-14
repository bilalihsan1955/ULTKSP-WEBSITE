<?php

namespace App\Controllers;

use App\Models\Auth_Model;
use App\Models\PostModel;
use App\Models\Comment_Model;
use App\Models\FotoModel;

class Admin extends BaseController
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

    public function index(): string
    {
        // Ambil user ID dari session
        $userId = $this->session->get('user_id');

        // Ambil data user berdasarkan ID
        $user = $this->userM->find($userId);

        // Ambil data laporan hanya untuk user yang sedang login
        $data['user'] = $user;

        // Fetch reports with creator's name and email
        $data['laporans'] = $this->postM->select('laporan.*, users.nama as creator_name, users.email, users.username, users.foto')
            ->join('users', 'users.id = laporan.id_user', 'left')
            ->orderBy('laporan.date_create', 'DESC')
            ->findAll();


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

        // Decode the encrypted Laporan ID
        $laporanId = base64_decode($this->encrypter->decrypt(hex2bin($encryptedLaporanId)));

        // Ambil data laporan berdasarkan ID
        $laporan = $this->postM->find($laporanId);

        if ($laporan) {
            // Ambil komentar terkait laporan
            $comments = $this->commentM->select('komentar_laporan.*, users.nama, users.foto, users.username, users.id as user_id')
                ->join('users', 'users.id = komentar_laporan.id_user', 'left')
                ->where('komentar_laporan.id_laporan', $laporanId)
                ->findAll();

            // Ambil foto terkait laporan
            $photos = $this->fotoM->where('id_laporan', $laporanId)->findAll(); // Assuming you have a photo model to fetch photos

            // Kirim data ke view
            $data = [
                'user' => $user,
                'laporan' => $laporan,
                'comments' => $comments, // Tambahkan data komentar
                'photos' => $photos, // Tambahkan data foto
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

        // Kirim email ke user yang membuat laporan
        $reportOwner = $this->userM->find($laporan['id_user']);
        if ($reportOwner) {
            $this->_sendCommentEmail($reportOwner['email'], $laporan, $user['nama'], $reportOwner['nama'], $reportData['isi']);
            return redirect()->back()->with('success', 'Admin comment submitted and email sent to the report owner successfully.');
        } else {
            return redirect()->back()->with('error', 'Report owner not found.');
        }
    }

    private function _sendCommentEmail($recipientEmail, $laporan, $commenter, $ownername, $commentContent)
    {
        $email = \Config\Services::email();

        // Konfigurasi email
        $email->setFrom('moko1@dotsnusa.com', 'ULTKSP VOKASI UB');
        $email->setTo($recipientEmail);
        $encrypter = \Config\Services::encrypter();
        $encryptedLaporanId = bin2hex($encrypter->encrypt(base64_encode($laporan['id'])));
        $email->setSubject('Komentar Baru Di Laporan : ' . $laporan['subject']);

        // Generate link ke laporan
        $reportLink = site_url("/Dashboard/Detail-Laporan/" . url_title(ucwords($laporan['subject']), '-', FALSE) . '/' . $encryptedLaporanId);

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
    public function user(): string
    {
        // Ambil user ID dari session
        $userId = $this->session->get('user_id');

        // Ambil data user yang sedang login berdasarkan ID
        $user = $this->userM->find($userId);

        // Ambil data semua pengguna dengan role "user" dan flag = 1
        $data['users'] = $this->userM->where('role', 'user')->where('flag', 1)->findAll();

        // Menyimpan data user yang sedang login untuk ditampilkan
        $data['user'] = $user;

        // Judul halaman
        $data['title'] = "Dashboard Admin - Manajemen Pengguna";

        return view("Admin/user_management", $data);
    }

    public function Users($encryptedUserId)
    {
        // Ambil user ID dari session
        $userId = $this->session->get('user_id');

        // Ambil data user yang sedang login berdasarkan ID
        $user = $this->userM->find($userId);

        // Dekripsi ID pengguna yang dienkripsi
        try {
            $userpenggunaId = base64_decode($this->encrypter->decrypt(hex2bin($encryptedUserId)));
        } catch (\Exception $e) {
            // Redirect ke halaman User-Management jika dekripsi gagal
            return redirect()->to('Admin/User-Management')->with('error', 'ID pengguna tidak valid.');
        }

        // Ambil data pengguna berdasarkan ID
        $pengguna = $this->userM->find($userpenggunaId);

        if (!$pengguna) {
            // Redirect jika pengguna tidak ditemukan
            return redirect()->to('Admin/User-Management')->with('error', 'Pengguna tidak ditemukan.');
        }

        // Ambil semua laporan yang dibuat oleh pengguna tersebut
        $laporans = $this->postM->where('id_user', $userpenggunaId)->orderBy('date_create', 'DESC')->findAll();

        // Kirim data pengguna dan laporan ke view
        return view('Admin/detail_user', [
            'user' => $user, // Variabel admin yang dikirim ke view
            'pengguna' => $pengguna,
            'laporans' => $laporans,
            'title' => esc($pengguna['nama'])
        ]);
    }
}
