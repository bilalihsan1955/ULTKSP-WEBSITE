<?php

namespace App\Models;

use CodeIgniter\Model;

class Comment_Model extends Model
{
    protected $table = 'komentar_laporan';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'id_laporan', 'id_user', 'isi', 'date_create',
        'date_edit'
    ];
    protected $useTimestamps = true;
    protected $createdField = 'date_create';
    protected $updatedField = 'date_edit';

    public function getLaporanById($laporanId)
    {
        return $this->find($laporanId); // Menggunakan metode find dari Model
    }
    // Method untuk mengambil laporan dengan detail user
    public function getCommentsByLaporanId($laporanId)
    {
        return $this->db->table('komentar_laporan')
            ->select('komentar_laporan.*, users.nama, users.foto, users.username, users.id as user_id')
            ->join('users', 'users.id = komentar_laporan.id_user', 'left')
            ->where('komentar_laporan.id_laporan', $laporanId)
            ->get()
            ->getResultArray();
    }
}
