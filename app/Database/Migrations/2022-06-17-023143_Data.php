<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class News extends Migration
{
    public function up()
    {
        $this->forge->addField([
			'id'          => [
				'type'           => 'INT',
				'constraint'     => 5,
				'unsigned'       => true,
				'auto_increment' => true
			],
			'nama_produk'       => [
				'type'           => 'VARCHAR',
				'constraint'     => 100,
                'null'          => false
			],
			'harga'      => [
				'type'           => 'VARCHAR',
				'constraint'     => 255,
				'default'        => '0'
			]
		]);

		// Membuat primary key
		$this->forge->addKey('id', TRUE);

		// Membuat tabel news
		$this->forge->createTable('data_sample', TRUE);
    }

    public function down()
    {
        $this->forge->dropTable('data_sample');
    }
}
