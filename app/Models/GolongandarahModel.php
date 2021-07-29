<?php

namespace App\Models;

use CodeIgniter\Model;

class StokdarahModel extends Model
{
    protected $table = 'golongandarah';
    protected $primaryKey = 'idGoldar';
    protected $allowedFields = [
        'golonganDarah','rhesusGoldar',
    ];
}
