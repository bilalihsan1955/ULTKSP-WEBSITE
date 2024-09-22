<?php

namespace App\Models;

use CodeIgniter\Model;

class Auth_Model extends Model
{
    protected $allowedFields = ['username', 'nama', 'email', 'password', 'token', 'flag', 'status', 'role', 'prodi', 'nim', 'nomor_hp', 'foto'];
    protected $useTimestamps = true;
    protected $createdField = 'date_create';
    protected $updatedField = 'date_edit';
    protected $table = 'users';
    protected $primaryKey = 'id';

    public function getUserByUsername($username)
    {
        return $this->where('username', $username)->first();
    }

    public function updateUser($id, $data)
    {
        return $this->where('id', $id)->set($data)->update();
    }

    public function removeExpiredTokens()
    {
        return $this->where('token IS NOT NULL', null, false)
                    ->where('DATE_ADD(token_created_at, INTERVAL 1 HOUR) < NOW()', null, false)
                    ->update(['token' => null]);
    }

    // New method to find user by token and check expiration
    public function getUserByToken($token)
    {
        return $this->where('token', $token)
                    ->where('DATE_ADD(token_created_at, INTERVAL 1 HOUR) >= NOW()', null, false)
                    ->first();
    }
}
