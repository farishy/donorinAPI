<?php

namespace App\Models;

use CodeIgniter\Model;

class KomentarModel extends Model
{
    protected $table = 'komentar';
    protected $primaryKey = 'idKomentar';
    protected $allowedFields = [
        'idAkun','idArtikel','tglKomentar','komentar',
      ];
}
