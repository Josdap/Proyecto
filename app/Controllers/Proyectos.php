<?php
namespace App\Controllers;
use CodeIgniter\Controller;
use App\Models\AsigRecursoModel;
use App\Models\AsigPersonalModel;
use App\Models\ProyectosModel;
use Dompdf\Dompdf;
use Dompdf\Options;
require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
class Proyectos extends BaseController
{
    public function __construct() 
    {
        helper(['form', 'url']);
        $this->proyectosModel = new ProyectosModel();
    }

    public function index()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to(base_url('Login'));
        }
        $data['clientes'] = $this->proyectosModel->getCliente();
        $data['proyectos'] = $this->proyectosModel
        ->select('proyectos.idProyectos, proyectos.nombrep, proyectos.Fechi, proyectos.Fechf, proyectos.duracion, proyectos.estado, proyectos.presupuesto, proyectos.porcentaje, clientes.Nombre as clientes')
        ->join('clientes', 'clientes.idClientes = proyectos.clientep')
        ->findAll();
        return view('proyectos', $data);
    }

    public function Registrar()
    {
        $validationRules = [
            'nombrep' => 'required',
            'clientep' => 'required',
            'presupuesto' => 'required'
        ];

        if ($this->validate($validationRules)) {
            $estado = 'No iniciado';
            $fechi = null;
            $fechf = null;
            $duracion = null;
            $porcentaje = null;

            $proyectodata = [
                'nombrep' => $this->request->getPost('nombrep'),
                'clientep' => $this->request->getPost('clientep'),
                'Fechi' => $fechi,
                'Fechf' => $fechf,
                'duracion' => $duracion,
                'estado' => $estado,
                'presupuesto' => $this->request->getPost('presupuesto'),
                'porcentaje' => $porcentaje
            ];

            $this->proyectosModel->insert($proyectodata);
            session()->setFlashdata('success', 'Proyecto registrado exitosamente.');
            return redirect()->to(base_url('/Proyectos'));
        } else {
            return redirect()->to(base_url('/Proyectos'))->withInput()->with('errors', $this->validator->getErrors());
        }
    }



public function editar($proyectoID)
{
    $validationRules = [
        'presupuesto' => 'required'
    ];

    $estado = $this->proyectosModel->find($proyectoID)['estado'];

    if ($estado === 'Completado') {
        session()->setFlashdata('error', 'No se puede editar un proyecto completado.');
        return redirect()->to(base_url('/Proyectos'));
    }

    if ($this->validate($validationRules)) {
        $proyectodata = [
            'presupuesto' => $this->request->getPost('presupuesto'),
        ];

        if ($estado == 'No iniciado') {
            $proyectodata['nombrep'] = $this->request->getPost('nombrep');
            $proyectodata['clientep'] = $this->request->getPost('clientep');
        }

        $proyectosModel = new ProyectosModel();
        $proyectosModel->update($proyectoID, $proyectodata);

        session()->setFlashdata('success', 'Proyecto actualizado exitosamente.');
        return redirect()->to(base_url('/Proyectos'));
    } else {
        return redirect()->to(base_url('/Proyectos'))->withInput()->with('errors', $this->validator->getErrors());
    }
}



public function CambiarEstado($idProyecto, $nuevoEstado)
{
    $proyecto = $this->proyectosModel->find($idProyecto);

    if (!$proyecto) {
        return redirect()->to(base_url('/Proyectos'))->with('error', 'Proyecto no encontrado.');
    }

    if ($nuevoEstado === 'Iniciado') {

        $asignacionRecursoModel = new AsigRecursoModel();
        $recursosAsignados = $asignacionRecursoModel->where('Proyectosre', $idProyecto)->findAll();

       
        $asigPersonalModel = new AsigPersonalModel();
        $personalAsignado = $asigPersonalModel->where('Proyectoper', $idProyecto)->findAll();

        if (empty($recursosAsignados) || empty($personalAsignado)) {
            return redirect()->to(base_url('/Proyectos'))->with('error', 'El inicio de proyectos requiere la asignación de recursos y personal.');
        }

        $proyecto['estado'] = 'Iniciado';
        $proyecto['porcentaje'] = 0;
        $proyecto['Fechi'] = date('Y-m-d');
    } elseif ($nuevoEstado === 'Completado' && $proyecto['estado'] === 'Iniciado') {

        if ($proyecto['porcentaje'] != 100) {
            return redirect()->to(base_url('/Proyectos'))->with('error', 'El porcentaje debe ser 100% para completar el proyecto.');
        }

        $fechai = strtotime($proyecto['Fechi']);
        $fechaf = strtotime(date('Y-m-d'));
        $duracion = ($fechaf - $fechai) / (60 * 60 * 24);
        $proyecto['duracion'] = $duracion;
        $proyecto['estado'] = 'Completado';
        $proyecto['Fechf'] = date('Y-m-d');
        $proyecto['porcentaje'] = 100;

    } else {
        return redirect()->to(base_url('/Proyectos'))->with('error', 'No se puede cambiar el estado del proyecto.');
    }

    $this->proyectosModel->update($idProyecto, $proyecto);
    return redirect()->to(base_url('/Proyectos'))->with('success', 'Estado del proyecto actualizado.');
}



public function actualizarPorcentaje($proyectoID)
{
          $validationRules = [
            'porcentaje' => 'required'
    ];

    if ($this->validate($validationRules)) {
        $proyectodata = [

            'porcentaje' => $this->request->getPost('porcentaje'),
        ];

        $proyectosModel = new ProyectosModel();
        $proyectosModel->update($proyectoID, $proyectodata);
   
        session()->setFlashdata('success', 'porcentaje actualizado exitosamente.');

        return redirect()->to(base_url('/Proyectos'));
    } else {
        return redirect()->to(base_url('/Proyectos'))->withInput()->with('errors', $this->validator->getErrors());
    }
}


         public function generarPDF()
    {   $proyectosModel = new ProyectosModel();
        $data['clientes'] = $this->proyectosModel->getCliente();
        $data['proyectos'] = $this->proyectosModel
        ->select('proyectos.idProyectos, proyectos.nombrep, proyectos.Fechi, proyectos.Fechf, proyectos.duracion, proyectos.estado, proyectos.presupuesto, proyectos.porcentaje, clientes.Nombre as clientes')
        ->join('clientes', 'clientes.idClientes = proyectos.clientep')
        ->findAll();


        $html = view('reporte_proyectos', $data);

        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
         $dompdf->set_option('isRemoteEnabled', true);
        $dompdf->render();

        $dompdf->stream('reporte_proyectos.pdf', ['Attachment' => true]);
    }
    
}
