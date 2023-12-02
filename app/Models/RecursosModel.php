<?php

namespace App\Models;

use CodeIgniter\Model;

class RecursosModel extends Model
{
    protected $table = 'recursos';
    protected $primaryKey = 'idRecursos';
    protected $allowedFields = ['Nombre', 'Tipo', 'Stock'];

    public function getTipo()
    {
        return $this->db->table('tiporecursos')->get()->getResult();
    }

    public function getProductosBajosStock()
    {
     
        $bajo = 40;

        return $this->where('Stock <=', $bajo)->findAll();
    }

    public function getStockRecursos()
{
    return $this->select('Nombre, Stock')->findAll();
}
}
