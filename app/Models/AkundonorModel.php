<?php

namespace App\Models;

use CodeIgniter\Model;

class AkundonorModel extends Model
{
    protected $table = 'akundonor';
    protected $primaryKey = 'idAkun';
    protected $allowedFields = [
        'namaLengkap','tempatLahir','tglLahir','jnsKelamin','alamat','noTelepon', 'noKTP','email', 'password', 'idGoldar', 'profile',
      ];
}
