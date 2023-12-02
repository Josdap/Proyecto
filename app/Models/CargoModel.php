<?php

namespace App\Models;

use CodeIgniter\Model;

class CargoModel extends Model
{
    protected $table = 'cargos';
    protected $primaryKey = 'idCargo';
    protected $allowedFields = ['Cargo', 'descripcion'];
}