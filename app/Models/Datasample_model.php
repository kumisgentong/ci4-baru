<?php
 
namespace App\Models;
 
use CodeIgniter\Model;
 
class Datasample_model extends Model
{
    protected $table = 'data_sample';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nama_produk', 'harga'];
}