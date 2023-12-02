<?php

namespace App\Controllers;
use CodeIgniter\Controller;
use App\Models\CargoModel;
class Cargos extends BaseController
{
    public function __construct() 
    {
        helper(['form', 'url']);
        $this->cargoModel = new CargoModel();
    }

    public function index()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to(base_url('Login'));
        }

      
        $data['roles'] = $this->cargoModel->findAll();

        return view('cargos', $data);
    }

        public function Registrar(){
        $validationRules=[
            'Cargo' => 'required',
            'descripcion' => 'required',
            
        ];

        if ($this->validate($validationRules)) {
            $cargosdata = [
                'Cargo' => $this->request->getPost('Cargo'),
                'descripcion' => $this->request->getPost('descripcion'),


                
            ];

             $this->cargoModel->insert($cargosdata);

              session()->setFlashdata('success', 'Cargo registrado exitosamente.');
              return redirect()->to(base_url('/Cargos'));
               } else {
                return redirect()->to(base_url('/Cargos'))->withInput()->with('errors', $this->validator->getErrors());
        }

    }

        public function editar($cargosId)
{
    $validationRules = [
        'Cargo' => 'required',
        'descripcion' => 'required'

    ];

    if ($this->validate($validationRules)) {
        $cargosdata = [
            'Cargo' => $this->request->getPost('Cargo'),
            'descripcion' => $this->request->getPost('descripcion'),

        ];

        $cargoModel = new CargoModel();
        $cargoModel->update($cargosId, $cargosdata);

        
        session()->setFlashdata('success', 'Cargo actualizado exitosamente.');

        return redirect()->to(base_url('/Cargos'));
    } else {
        return redirect()->to(base_url('/Cargos'))->withInput()->with('errors', $this->validator->getErrors());
    }
}


   public function Eliminar($cargosId)
    {
        $cargoModel = new CargoModel();
        $cargoModel->delete($cargosId);

        return redirect()->back()->with('success', 'El cargo se eliminó correctamente.');
    }
}


