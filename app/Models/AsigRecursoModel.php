<?php

namespace App\Models;

use CodeIgniter\Model;

class AsigRecursoModel extends Model
{
    protected $table = 'asignacionre';
    protected $primaryKey = 'idAsignacionre';
    protected $allowedFields = ['Proyectosre', 'Recursosre', 'Cantidad', 'Fecha'];

     public function getProyecto()
    {
        return $this->db->table('proyectos')->get()->getResult();
    }

      public function getRecurso()
    {
        return $this->db->table('recursos')->get()->getResult();
    }
}