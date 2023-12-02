<?php
namespace App\Controllers;
use CodeIgniter\Controller;
use App\Models\AsigPersonalModel;
use App\Models\AsigRecursoModel;
use Dompdf\Dompdf;
use Dompdf\Options;
require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Asignaciones extends BaseController
{
	public function __construct() 
	{
		helper(['form', 'url']);
		$this->asigrecursomodel = new AsigRecursoModel();
		$this->asigpersonalmodel = new AsigPersonalModel();	 	            	
    }
	public function index()
	{
		if (!session()->get('isLoggedIn')) {
            
            return redirect()->to(base_url('Login'));
        }
        $data['proyectos'] = $this->asigrecursomodel->getProyecto();
        $data['recursos'] = $this->asigrecursomodel->getRecurso();
        $data['cantidad'] = $this->asigrecursomodel->findAll();
        $data['personal'] = $this->asigpersonalmodel->getPersonal();
        $data['asigpersonal'] = $this->asigpersonalmodel
        ->select('asignacionper.idAsignacionper, asignacionper.Fecha, proyectos.nombrep as proyecto, empleados.Nombre as empleado')
        ->join('proyectos', 'proyectos.idProyectos = asignacionper.Proyectoper')
        ->join('empleados', 'empleados.idEmpleado = asignacionper.Empleadoper')
        ->findAll();
         $data['asigrecurso'] = $this->asigrecursomodel
            ->select('asignacionre.idAsignacionre, asignacionre.Cantidad, asignacionre.Fecha, proyectos.nombrep as proyecto, recursos.Nombre as recurso')
            ->join('proyectos', 'proyectos.idProyectos = asignacionre.Proyectosre')
            ->join('recursos', 'recursos.idRecursos = asignacionre.Recursosre')
            ->findAll();

$combinedData = [];
foreach ($data['asigpersonal'] as $asignacionPersonal) {
    $proyecto = $asignacionPersonal['proyecto'];
    $combinedData[$proyecto]['proyecto'] = $proyecto;
    $combinedData[$proyecto]['empleado'][] = $asignacionPersonal['empleado'];
}

foreach ($data['asigrecurso'] as $asignacionRecurso) {
    $proyecto = $asignacionRecurso['proyecto'];
    $recurso = $asignacionRecurso['recurso'];
    $cantidad = $asignacionRecurso['Cantidad'];

    if (isset($combinedData[$proyecto]['recurso'][$recurso])) {

        $combinedData[$proyecto]['Cantidad'][$recurso] += $cantidad;
    } else {

        $combinedData[$proyecto]['proyecto'] = $proyecto;
        $combinedData[$proyecto]['recurso'][$recurso] = $recurso;
        $combinedData[$proyecto]['Cantidad'][$recurso] = $cantidad;
        $combinedData[$proyecto]['Fecha'][$recurso] = date('d/m/Y', strtotime($asignacionRecurso['Fecha']));
    }
}

$data['combinedData'] = array_values($combinedData);

		return view('asignaciones',$data);
	}


public function generarPDF()
{
    $asigrecursomodel = new AsigRecursoModel();
    $asigpersonalmodel = new AsigPersonalModel();
    $data['proyectos'] = $this->asigrecursomodel->getProyecto();
    $data['recursos'] = $this->asigrecursomodel->getRecurso();
    $data['cantidad'] = $this->asigrecursomodel->findAll();
    $data['personal'] = $this->asigpersonalmodel->getPersonal();
    $data['asigpersonal'] = $this->asigpersonalmodel
        ->select('asignacionper.idAsignacionper, asignacionper.Fecha, proyectos.nombrep as proyecto, empleados.Nombre as empleado')
        ->join('proyectos', 'proyectos.idProyectos = asignacionper.Proyectoper')
        ->join('empleados', 'empleados.idEmpleado = asignacionper.Empleadoper')
        ->findAll();
    $data['asigrecurso'] = $this->asigrecursomodel
        ->select('asignacionre.idAsignacionre, asignacionre.Cantidad, asignacionre.Fecha, proyectos.nombrep as proyecto, recursos.Nombre as recurso')
        ->join('proyectos', 'proyectos.idProyectos = asignacionre.Proyectosre')
        ->join('recursos', 'recursos.idRecursos = asignacionre.Recursosre')
        ->findAll();

    $combinedData = [];
    foreach ($data['asigpersonal'] as $asignacionPersonal) {
        $proyecto = $asignacionPersonal['proyecto'];
        $combinedData[$proyecto]['proyecto'] = $proyecto;
        $combinedData[$proyecto]['empleado'][] = $asignacionPersonal['empleado'];
    }

    foreach ($data['asigrecurso'] as $asignacionRecurso) {
        $proyecto = $asignacionRecurso['proyecto'];
        $recurso = $asignacionRecurso['recurso'];
        $cantidad = $asignacionRecurso['Cantidad'];

        if (isset($combinedData[$proyecto]['recurso'][$recurso])) {
            $combinedData[$proyecto]['Cantidad'][$recurso] += $cantidad;
        } else {
            $combinedData[$proyecto]['proyecto'] = $proyecto;
            $combinedData[$proyecto]['recurso'][$recurso] = $recurso;
            $combinedData[$proyecto]['Cantidad'][$recurso] = $cantidad;
            $combinedData[$proyecto]['Fecha'][$recurso] = date('d/m/Y', strtotime($asignacionRecurso['Fecha']));
        }
    }

    $data['combinedData'] = array_values($combinedData);

    $html = view('reporte_general', $data);

    $dompdf = new Dompdf();
    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'landscape');
    $dompdf->set_option('isRemoteEnabled', true);
    $dompdf->render();

    $dompdf->stream('reporte_general.pdf', ['Attachment' => true]);
}

}