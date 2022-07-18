<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Datasample extends Seeder
{
    public function run()
    {
        $news_data = [
			[
				'nama_produk' => 'Kaos pria',
				'harga'  => '50000'
			],
			[
				'nama_produk' => 'Culotte Highwaist',
				'harga'  => '78000'
			],
			[
				'nama_produk' => 'Jaket',
				'harga'  => '150000'
			],
			[
				'nama_produk' => 'Hoodie',
				'harga'  => '100000'
			],
			[
				'nama_produk' => 'Blouse',
				'harga'  => '125000'
			],
			[
				'nama_produk' => 'Kemeja Flanel',
				'harga'  => '111000'
			],
			[
				'nama_produk' => 'Skinny Jeans',
				'harga'  => '90000'
			]
		];

		foreach($news_data as $data){
			$this->db->table('data_sample')->insert($data);
		}
    }
}
