<?php

namespace App\Models;

use CodeIgniter\Model;

class LokasiModel extends Model
{
    protected $table = 'lokasi';
    protected $primaryKey = 'idLokasi';
    protected $allowedFields = [
        'namaLokasi','latKordinat','longKordinat',
      ];
}
