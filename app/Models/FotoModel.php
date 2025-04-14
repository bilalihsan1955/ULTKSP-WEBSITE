<?php

namespace App\Models;

use CodeIgniter\Model;

class FotoModel extends Model
{
    protected $table = 'foto';
    protected $primaryKey = 'id';
    protected $allowedFields = ['id_laporan', 'file_name', 'date_create', 'date_edit'];
    
    public function deletePhotoByFileName($fileName)
    {
        return $this->where('file_name', $fileName)->delete();
    }

}
