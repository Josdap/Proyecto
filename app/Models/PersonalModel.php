<?php

namespace App\Models;

use CodeIgniter\Model;

class PersonalModel extends Model
{
    protected $table = 'empleados';
    protected $primaryKey = 'idEmpleado';
    protected $allowedFields = ['Nombre', 'Cargoe', 'Telefono'];

    public function getRol()
    {
        return $this->db->table('cargos')->get()->getResult();
    }
}