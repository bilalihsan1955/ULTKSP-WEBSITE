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
}
