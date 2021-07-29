<?php

namespace App\Models;

use CodeIgniter\Model;

class TransaksiModel extends Model
{
    protected $table = 'transaksidonor';
    protected $primaryKey = 'idTransaksi';
    protected $allowedFields = [
        'idAkun','tglTransaksi','statusTransaksi','keterangan', 'idKuesioner'
      ];
}
