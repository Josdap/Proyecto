<?php

namespace App\Models;

use CodeIgniter\Model;

class ClientesModel extends Model
{
    protected $table = 'clientes';
    protected $primaryKey = 'idClientes';
    protected $allowedFields = ['Nombre', 'Direccion', 'Telefono', 'Correo'];

}