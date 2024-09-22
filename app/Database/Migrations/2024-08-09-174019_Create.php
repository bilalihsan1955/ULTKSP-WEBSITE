<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Create extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true
            ],
            'username' => [
                'type' => 'VARCHAR',
                'constraint' => 255
            ],
            'nama' => [
                'type' => 'VARCHAR',
                'constraint' => 255
            ],
            'nim' => [
                'type' => 'VARCHAR',
                'constraint' => 50
            ],
            'nomor_hp' => [
                'type' => 'VARCHAR',
                'constraint' => 20
            ],
            'email' => [
                'type' => 'VARCHAR',
                'constraint' => 255
            ],
            'prodi' => [
                'type' => 'VARCHAR',
                'constraint' => 255
            ],
            'foto' => [
                'type' => 'VARCHAR',
                'constraint' => 255
            ],
            'password' => [
                'type' => 'VARCHAR',
                'constraint' => 255
            ],
            'token' => [
                'type' => 'VARCHAR',
                'constraint' => 255
            ],
            'status' => [
                'type' => 'VARCHAR',
                'constraint' => 255
            ],
            'flag' => [
                'type' => 'INT',
                'constraint' => 11
            ],
            'date_create' => [
                'type' => 'TIMESTAMP',
                'null' => false,
                'default' => null,
                'use_current' => true
            ],
            'date_edit' => [
                'type' => 'TIMESTAMP',
                'null' => false,
                'default' => null,
                'use_current' => true,
                'on update' => 'CURRENT_TIMESTAMP'
            ],
            'role' => [
                'type' => 'ENUM',
                'constraint' => ['user', 'admin'],
                'default' => 'user'
            ]
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('users');

        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true
            ],
            'id_user' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true
            ],
            'subject' => [
                'type' => 'VARCHAR',
                'constraint' => 255
            ],
            'isi' => [
                'type' => 'TEXT'
            ],
            'date_create' => [
                'type' => 'TIMESTAMP',
                'null' => false,
                'default' => null,
                'use_current' => true
            ],
            'date_edit' => [
                'type' => 'TIMESTAMP',
                'null' => false,
                'default' => null,
                'use_current' => true,
                'on update' => 'CURRENT_TIMESTAMP'
            ],
            'foto_file' => [
                'type' => 'VARCHAR',
                'constraint' => 255
            ]
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('id_user', 'users', 'id');
        $this->forge->createTable('laporan');

        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true
            ],
            'id_laporan' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true
            ],
            'id_user' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true
            ],
            'isi' => [
                'type' => 'TEXT'
            ],
            'date_create' => [
                'type' => 'TIMESTAMP',
                'null' => false,
                'default' => null,
                'use_current' => true
            ],
            'date_edit' => [
                'type' => 'TIMESTAMP',
                'null' => false,
                'default' => null,
                'use_current' => true,
                'on update' => 'CURRENT_TIMESTAMP'
            ]
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('id_laporan', 'laporan', 'id');
        $this->forge->addForeignKey('id_user', 'users', 'id');
        $this->forge->createTable('komentar_laporan');
    }

    public function down()
    {
        $this->forge->dropTable('komentar_laporan');
        $this->forge->dropTable('laporan');
        $this->forge->dropTable('users');
    }
}
