<?php

namespace App\Models;

use CodeIgniter\Model;

class ProyectosModel extends Model
{
    protected $table = 'proyectos';
    protected $primaryKey = 'idProyectos';
    protected $allowedFields = ['nombrep', 'clientep', 'Fechi', 'Fechf', 'duracion', 'estado', 'presupuesto', 'porcentaje'];

      public function getCliente()
    {
        return $this->db->table('clientes')->get()->getResult();
    }


    public function countProyectosPorEstado($estado)
{
    return $this->where('estado', $estado)->countAllResults();
}



public function updatePorcentaje($idProyecto, $porcentaje)
{
    $data = [
        'porcentaje' => $porcentaje
    ];

    $this->update($idProyecto, $data);
}
}