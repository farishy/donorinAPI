<?php

namespace App\Models;

use CodeIgniter\Model;

class ArtikelModel extends Model
{
    protected $table = 'artikel';
    protected $primaryKey = 'idArtikel';
    protected $allowedFields = [
        'tglRilis','tipeArtikel','viewCount','likeCount','commentCount','judulArtikel', 'gambarArtikel', 'sinopsisArtikel','kontenArtikel', 'idPenulis', 'statusArtikel',
      ];
}
