<?php

namespace App\Models;

use CodeIgniter\Model;

class StokdarahModel extends Model
{
    protected $table = 'stokdarah';
    protected $primaryKey = 'idStok';
    protected $allowedFields = [
        'idGoldar','stokDarah',
    ];
    
    public function joinWithGoldarTable(){
      return $this->db->table('stokdarah')->join('golongandarah', 'golongandarah.idGoldar=stokdarah.idGoldar')->get()->getResultArray();
    }
}
