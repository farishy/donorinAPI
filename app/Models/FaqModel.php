<?php

namespace App\Models;

use CodeIgniter\Model;

class FaqModel extends Model
{
    protected $table = 'frequencyaskquestion';
    protected $primaryKey = 'idFaq';
    protected $allowedFields = [
        'icon','judulFaq','sinopsisFaq','kontenFaq',
      ];
}
