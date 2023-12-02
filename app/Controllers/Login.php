<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\LoginModel;

class Login extends Controller
{
    public function index()
    {
        $data['error'] = session()->getFlashdata('error');
        return view('login', $data);
    }

public function validateLogin()
{
    $usuario = $this->request->getPost('usuario');
    $password = $this->request->getPost('password');

    $model = new LoginModel();
    $result = $model->validateLogin($usuario, $password);

    if ($result) {
        session()->set('isLoggedIn', true);
        session()->set('username', $usuario);
        return $this->response->setJSON(['success' => true, 'redirect' => base_url('DashboardController')]);
    } else {
        return $this->response->setJSON(['success' => false, 'error' => 'Usuario o Contraseña incorrecta']);
    }
}


public function logout()
{
    session()->destroy();
    return redirect()->to(base_url('Login'));
}

    
}

