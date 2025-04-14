<?php

namespace App\Models;

use CodeIgniter\Model;

class PostModel extends Model
{
    protected $table = 'laporan';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'id_user', 'subject', 'isi', 'date_create',
        'date_edit', 'foto_file'
    ];
    protected $useTimestamps = true;
    protected $createdField = 'date_create';
    protected $updatedField = 'date_edit';

    public function getLaporanByUserId($userId)
    {
        return $this->where('id_user', $userId)->findAll();
    }

    public function getLaporanWithUser($userId)
    {
        return $this->select('laporan.*, users.nama')
            ->join('users', 'users.id = laporan.id_user')
            ->where('laporan.id_user', $userId)
            ->orderBy('laporan.date_create', 'DESC') // Urutkan berdasarkan date_create terbaru
            ->findAll();
    }

    // Tambahkan metode untuk menyimpan foto
    public function saveReportWithPhoto($reportData, $photoData)
    {
        // Simpan laporan dan ambil ID laporan yang baru disimpan
        $this->save($reportData);
        $lastInsertedId = $this->insertID();

        // Simpan data foto
        $photoData['id_laporan'] = $lastInsertedId; // Tambahkan relasi ke ID laporan
        $this->db->table('foto')->insert($photoData); // Pastikan menggunakan tabel 'foto'
    }
}
