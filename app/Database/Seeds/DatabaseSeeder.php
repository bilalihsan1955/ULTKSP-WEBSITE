<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Tabel Users
        $this->db->table('users')->insert([
            'username' => 'bilal',
            'nama' => 'bilal al ihsan',
            'nim' => '12345678',
            'nomor_hp' => '08123456789',
            'email' => 'bilalihsan@sudent.ub.ac.id',
            // 'prodi' => 'Teknik Informatika',
            'foto' => 'default.png',
            'password' => password_hash('Kiaramas1955_', PASSWORD_DEFAULT),
            'status' => 'active',
            'flag' => 1,
            'date_create' => Time::now(),
            'date_edit' => Time::now(),
            'role' => 'admin'
        ]);
    }
}
