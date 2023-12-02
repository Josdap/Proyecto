<?php

namespace App\Controllers;
use CodeIgniter\Controller;
use App\Models\RecursosModel;
use App\Models\ProyectosModel;
use App\Models\PersonalModel;
use App\Models\AsigPersonalModel;
use App\Models\DocumentacionModel;

class DashboardController extends BaseController
{
    protected $recursoModel;


    public function __construct()
    {
        helper(['form', 'url']);
        $this->recursoModel = new RecursosModel();
        $this->proyectosModel = new ProyectosModel();
        $this->personalModel = new PersonalModel();
        $this->asigPersonalModel = new AsigPersonalModel();
        $this->documentacionmodel= new DocumentacionModel();
    }

    public function index()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to(base_url('Login'));
        }

        
        $productosBajosStock = $this->recursoModel->getProductosBajosStock();

        if (!empty($productosBajosStock)) {
          
            $recursos['productosBajosStock'] = $productosBajosStock;
          
            session()->setFlashdata('alertaStockBajo', true);
        }

        $recursoModel = new RecursosModel();

        $proyectosModel = new ProyectosModel();
        $personalModel = new PersonalModel();
        $numProyectosIniciados = $this->proyectosModel->countProyectosPorEstado('Iniciado');
        $numProyectosNoIniciados = $this->proyectosModel->countProyectosPorEstado('No iniciado');
        $numProyectosCompletados = $this->proyectosModel->countProyectosPorEstado('Completado');
        $empleadosProyectos = $this->asigPersonalModel->countProyectosPorEmpleado();
        $stockRecursos = $this->recursoModel->getStockRecursos();
        $cantidaddoc = $this->documentacionmodel->getDocporproyecto();

        $data = [
            'numRecursos' => $recursoModel->countAll(),
            'numProyectos' => $proyectosModel->countAll(),
            'numPersonal' => $personalModel->countAll(),
            'numProyectosIniciados' => $numProyectosIniciados,
            'numProyectosNoIniciados' => $numProyectosNoIniciados,
            'numProyectosCompletados' => $numProyectosCompletados,
            'empleadosProyectos' => $empleadosProyectos,
            'stockRecursos' => $stockRecursos,
            'cantidaddoc' => $cantidaddoc,
        ];

        return view('dashboard',$data);
    }
}
