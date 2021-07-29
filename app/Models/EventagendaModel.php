<?php

namespace App\Models;

use CodeIgniter\Model;

class EventagendaModel extends Model
{
    protected $table = 'eventagenda';
    protected $primaryKey = 'idAgenda';
    protected $allowedFields = [
        'tglAgenda','judulAgenda','sinopsisAgenda','kontenAgenda','gambarAgenda','statusAgenda', 'idLokasi',
      ];
}
