<?php

namespace App\Models;

use CodeIgniter\Model;

class AsigPersonalModel extends Model
{
    protected $table = 'asignacionper';
    protected $primaryKey = 'idAsignacionper';
    protected $allowedFields = ['Proyectoper', 'Empleadoper', 'Fecha'];

     public function getProyecto()
    {
        return $this->db->table('proyectos')->get()->getResult();
    }
     public function getPersonal()
    {
        return $this->db->table('empleados')->get()->getResult();
    }

    public function countProyectosPorEmpleado()
{
    $builder = $this->db->table('asignacionper');
    $builder->select('empleados.Nombre as nombre, COUNT(asignacionper.idAsignacionper) as numProyectos');
    $builder->join('empleados', 'empleados.idEmpleado = asignacionper.Empleadoper');
    $builder->groupBy('empleados.Nombre');
    return $builder->get()->getResultArray();
}

    
}