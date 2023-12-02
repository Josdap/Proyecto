<?php

namespace App\Models;

use CodeIgniter\Model;

class LoginModel extends Model
{
    protected $table = 'login';
    protected $primaryKey = 'idLogin';
    protected $allowedFields = ['usuario', 'Contraseña'];

    public function validateLogin($usuario, $password)
    {
        $query = $this->where('usuario', $usuario)
                      ->where('contraseña', $password)
                      ->first();

        return ($query !== null);
    }
}


