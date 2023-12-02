<?php

namespace App\Models;

use CodeIgniter\Model;

class TipoRecursoModel extends Model
{
    protected $table = 'tiporecursos';
    protected $primaryKey = 'idTiporecursos';
    protected $allowedFields = ['Tiporecurso'];
}