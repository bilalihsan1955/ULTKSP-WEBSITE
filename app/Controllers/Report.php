<?php

namespace App\Controllers;

use App\Models\Auth_Model;
use App\Models\FotoModel;
use App\Models\PostModel;

class Report extends BaseController
{
    protected $session;
    protected $userM;
    protected $postM;
    protected $fotoM;
    protected $encrypter;

    public function __construct()
    {
        $this->session = \Config\Services::session();
        $this->userM = new Auth_Model();
        $this->postM = new PostModel();
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

        // Set title secara dinamis
        $data['title'] = "Add Report"; // Gantilah sesuai kebutuhan

        return view("User/Laporan/index",  $data);
    }

    public function addReport()
    {
        $validation = $this->validate([
            'subject' => 'required',
            'editor' => 'required',
            'photo' => [
                'uploaded[photo]',
                'mime_in[photo,image/jpg,image/jpeg,image/png]',
                'max_size[photo,1024]' // ukuran maksimal 1MB
            ]
        ]);

        if (!$validation) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $userId = $this->session->get('user_id');
        if (!$userId) {
            return redirect()->back()->with('errors', 'User not found');
        }

        // Handle multiple photos
        $photoFiles = $this->request->getFiles(); // Get all uploaded files
        if (empty($photoFiles['photo']) || count($photoFiles['photo']) === 0) {
            return redirect()->back()->with('errors', 'No photos uploaded');
        }

        // Get the uploaded files
        $photos = $photoFiles['photo'];
        if (!is_array($photos)) {
            // If it's not an array, make it an array to handle both single and multiple uploads
            $photos = [$photos];
        }

        // Ensure there are valid files
        $photoNames = [];
        foreach ($photos as $file) {
            if ($file->isValid() && !$file->hasMoved()) {
                // Generate a random name for each file
                $newName = $file->getRandomName();
                $file->move('uploads/reports/', $newName); // Save the file to the desired directory
                $photoNames[] = $newName; // Store the new name in the array
            }
        }

        // If no valid files are uploaded, return error
        if (count($photoNames) === 0) {
            return redirect()->back()->with('errors', 'No valid photos uploaded');
        }

        // Optional: Handle the removal of old photos
        $oldPhoto = $this->request->getPost('old_foto_file');
        if (!empty($oldPhoto) && file_exists('uploads/reports/' . $oldPhoto)) {
            unlink('uploads/reports/' . $oldPhoto); // Remove old photo
        }

        // Data laporan (Report data)
        $reportData = [
            'id_user' => $userId,
            'subject' => esc($this->request->getPost('subject')),
            'isi' => esc($this->request->getPost('editor')),
            'foto_file' => $photoNames[0], // Save the first uploaded file in 'foto_file'
        ];

        // Save the report
        $this->postM->save($reportData);
        $lastInsertedId = $this->postM->insertID();

        // Tambahkan ID laporan ke $reportData
        $reportData['id'] = $lastInsertedId;  // Ini untuk memastikan ID disertakan

        // Save all uploaded photos into the 'foto' table
        foreach ($photoNames as $photoName) {
            $photoData = [
                'file_name' => $photoName,
                'id_laporan' => $lastInsertedId,
                'date_create' => date('Y-m-d H:i:s'),
            ];
            $this->fotoM->insert($photoData); // Save each photo to 'foto' table using FotoModel
        }

    // Get active user data
        $activeUserData = $this->userM->find($userId);
    
        // Send email to all admins
        $admins = $this->userM->where('role', 'admin')->findAll();
        foreach ($admins as $admin) {
            $this->_sendReportEmail($admin['email'], $admin['nama'], $reportData, $this->session->get('nama'), $activeUserData['nama'], $reportData['isi'], $photoNames, $activeUserData);
        }
    
        return redirect()->to('/Dashboard')->with('success', 'Report submitted successfully');
    }
    
    private function _sendReportEmail($adminEmail, $admin, $reportData, $reporterName, $ownerName, $reportContent, $uploadedPhotos = [], $activeUserData = [])
    {
        $email = \Config\Services::email();
        $email->setFrom('moko1@dotsnusa.com', 'ULTKSP VOKASI UB');
        $email->setTo($adminEmail);
        $email->setSubject('Laporan Baru: ' . $reportData['subject']);
        $encrypter = \Config\Services::encrypter();
        $encryptedLaporanId = bin2hex($encrypter->encrypt(base64_encode($reportData['id'])));
        // Create a link to the report detail page
        $reportLink = site_url("/Admin/Detail-Laporan/" . url_title(ucwords($reportData['subject']), '-', FALSE). '/' . $encryptedLaporanId);
    
        // Prepare the email content
        $emailContent = view('emails/report', [
            'laporan_title' => $reportData['subject'],
            'reporter_name' => $reporterName,
            'owner_name' => $ownerName,
            'admin' => $admin,
            'report_date' => date('Y-m-d H:i:s'),
            'report_content' => $reportContent,
            'url' => $reportLink,
            'photos' => $uploadedPhotos,
            // Include active user data in the email content
            'active_user_data' => $activeUserData,
        ]);
    
        $email->setMessage($emailContent);
    
        if (!empty($uploadedPhotos)) {
            foreach ($uploadedPhotos as $photoName) {
                $email->attach(FCPATH . 'uploads/reports/' . esc($photoName));
            }
        }
    
        // Send email
        if (!$email->send()) {
            return redirect()->back()->with('error', 'Failed to send report email to: ' . $adminEmail);
        }
    }

    public function editpost($encryptedLaporanId)
    {
        $userId = $this->session->get('user_id');

        // Decode the encrypted ID
        $laporanId = base64_decode($this->encrypter->decrypt(hex2bin($encryptedLaporanId)));

        // Get user data
        $user = $this->userM->find($userId);

        // Get report data based on ID
        $laporan = $this->postM->find($laporanId);

        // Fetch associated photos from the 'foto' table
        $photos = $this->fotoM->where('id_laporan', $laporanId)->findAll();

        if ($laporan) {
            // Pass data to the view
            $data = [
                'user' => $user,
                'laporan' => $laporan,
                'photos' => $photos, // Include all photos
                'title' => "Edit Report: " . esc($laporan['subject']),
            ];

            return view("User/Laporan/ReportEdit", $data);
        } else {
            return redirect()->to('/')->with('errors', 'Laporan tidak ditemukan.');
        }
    }

    public function updatepost($encryptedLaporanId)
    {
        // Decode the encrypted ID
        $laporanId = base64_decode($this->encrypter->decrypt(hex2bin($encryptedLaporanId)));

        $validation = $this->validate([
            'subject' => 'required',
            'editor' => 'required',
        ]);

        if (!$validation) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Ambil data dari form
        $existingPhotos = $this->request->getPost('existing_photos');
        $existingPhotos = !empty($existingPhotos) ? explode(',', $existingPhotos) : [];

        // Ambil foto lama dari database
        $oldPhotos = $this->fotoM->where('id_laporan', $laporanId)->findAll();
        $oldPhotoNames = array_map(fn($photo) => $photo['file_name'], $oldPhotos);

        // Hapus foto lama yang tidak ada dalam daftar existingPhotos
        foreach ($oldPhotos as $oldPhoto) {
            if (!in_array($oldPhoto['file_name'], $existingPhotos)) {
                // Hapus file dari server
                if (file_exists('uploads/reports/' . esc($oldPhoto['file_name']))) {
                    if (!unlink('uploads/reports/' . esc($oldPhoto['file_name']))) {
                        return redirect()->back()->with('error', 'Gagal menghapus file: ' . esc($oldPhoto['file_name'])); // Logging error
                    }
                }
                // Hapus dari database
                $this->fotoM->delete($oldPhoto['id']);
            }
        }

        // Upload foto baru
        $files = $this->request->getFiles();
        $firstPhotoFileName = null; // Menyimpan nama file foto pertama
        $isFileUploaded = false; // Flag untuk mengecek apakah ada file yang berhasil diupload

        if ($files && isset($files['photo'])) {
            foreach ($files['photo'] as $index => $file) {
                if (
                    $file->isValid() && !$file->hasMoved() && in_array($file->getMimeType(), ['image/jpeg', 'image/png', 'image/jpg']) &&
                    $file->getSize() <= 10048576
                ) {
                    $newFileName = $file->getRandomName();
                    $file->move('uploads/reports', $newFileName);

                    // Simpan informasi foto ke database
                    $this->fotoM->insert([
                        'id_laporan' => $laporanId,
                        'file_name' => esc($newFileName),
                    ]);

                    // Simpan file foto pertama untuk kolom 'foto_file' di tabel laporan
                    if ($index === 0) {
                        $firstPhotoFileName = $newFileName;
                    }

                    $isFileUploaded = true; // Set flag ke true jika ada file yang berhasil diupload
                }
            }
        }

        // Jika tidak ada file yang berhasil diupload dan tidak ada foto yang tersisa
        if (!$isFileUploaded && empty($existingPhotos)) {
            return redirect()->back()->with('error', 'Anda harus mengunggah setidaknya satu foto.')->withInput();
        }

        // Update laporan, termasuk kolom 'foto_file' dengan file foto pertama yang baru diupload
        $this->postM->update($laporanId, [
            'subject' => esc($this->request->getPost('subject')), // Escaping input
            'isi' => esc($this->request->getPost('editor')), // Escaping input
            'foto_file' => esc($firstPhotoFileName ?? (count($existingPhotos) > 0 ? $existingPhotos[0] : null)), // Escaping file
        ]);

        // Redirect ke halaman detail laporan jika sukses
        return redirect()->to(base_url("Dashboard/Detail-Laporan/" . $this->request->getPost('subject') . "/" . $encryptedLaporanId))
            ->with('success', 'Laporan berhasil diperbarui.');
    }
}
