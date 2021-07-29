<?php

namespace App\Models;

use CodeIgniter\Model;

class PenulisModel extends Model
{
    protected $table = 'penulis';
    protected $primaryKey = 'idPenulis';
    protected $allowedFields = [
        'namaPenulis','gambarPenulis','deskripsiPenulis', 'statusPenulis',
      ];
}
