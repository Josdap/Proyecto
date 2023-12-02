<?php
namespace App\Controllers;
use CodeIgniter\Controller;
use App\Models\AsigPersonalModel;
use App\Models\ProyectosModel;
class AsigPersonal extends BaseController
{
	public function __construct() 
	{
		helper(['form', 'url']);
		$this->asigpersonalmodel = new AsigPersonalModel();
       	    	            	
    }
	public function index()
	{
		if (!session()->get('isLoggedIn')) {
            
            return redirect()->to(base_url('Login'));
        }
         $data['proyectos'] = $this->asigpersonalmodel->getProyecto();
         $data['personal'] = $this->asigpersonalmodel->getPersonal();
         $data['asigpersonal'] = $this->asigpersonalmodel
        ->select('asignacionper.idAsignacionper, asignacionper.Fecha, proyectos.nombrep as proyecto, empleados.Nombre as empleado')
        ->join('proyectos', 'proyectos.idProyectos = asignacionper.Proyectoper')
        ->join('empleados', 'empleados.idEmpleado = asignacionper.Empleadoper')
        ->findAll();
		return view('asigpersonal',$data);
	}

	public function Registrar()
{
    $validationRules = [
        'Proyectoper' => 'required',
        'Empleadoper' => 'required'
    ];

    if ($this->validate($validationRules)) {
        $proyectoModel = new ProyectosModel();
        $proyectoId = $this->request->getPost('Proyectoper');
        $empleado = $this->request->getPost('Empleadoper');

        $proyecto = $proyectoModel->find($proyectoId);

        if ($proyecto) {
            $estadoProyecto = $proyecto['estado'];

            if ($estadoProyecto === 'Completado') {
                session()->setFlashdata('error', 'No se pueden asignar personal a un proyecto "Completado".');
                return redirect()->to(base_url('/AsigPersonal'))->withInput();
            }
        }

        $existingAssignment = $this->asigpersonalmodel
            ->where('Proyectoper', $proyectoId)
            ->where('Empleadoper', $empleado)
            ->first();

        if ($existingAssignment) {
            session()->setFlashdata('error', 'El empleado ya está asignado a este proyecto.');
            return redirect()->to(base_url('/AsigPersonal'))->withInput();
        }

        $fecha = date('Y-m-d');

        $asigpersonaldata = [
            'Proyectoper' => $proyectoId,
            'Empleadoper' => $empleado,
            'Fecha' => $fecha
        ];

        $this->asigpersonalmodel->insert($asigpersonaldata);

        session()->setFlashdata('success', 'Asignacion registrada exitosamente.');
        return redirect()->to(base_url('/AsigPersonal'));
    } else {
        return redirect()->to(base_url('/AsigPersonal'))->withInput()->with('errors', $this->validator->getErrors());
    }
}


public function editar($asigpersonalId)
{
    $validationRules = [
        'Proyectoper' => 'required',
        'Empleadoper' => 'required'
    ];

    if ($this->validate($validationRules)) {
        $proyectoId = $this->request->getPost('Proyectoper');
        $empleado = $this->request->getPost('Empleadoper');

        $proyectoModel = new ProyectosModel();
        $proyecto = $proyectoModel->find($proyectoId);

        if ($proyecto) {
            $estadoProyecto = $proyecto['estado'];

            if ($estadoProyecto === 'Completado') {
                session()->setFlashdata('error', 'No se puede asignar personal a un proyecto "Completado".');
                return redirect()->to(base_url('/AsigPersonal'))->withInput();
            }
        }

        $existingAssignment = $this->asigpersonalmodel
            ->where('Proyectoper', $proyectoId)
            ->where('Empleadoper', $empleado)
            ->where('idAsignacionper !=', $asigpersonalId)
            ->first();

        if ($existingAssignment) {
            session()->setFlashdata('error', 'El empleado ya está asignado a este proyecto.');
            return redirect()->to(base_url('/AsigPersonal'))->withInput();
        }
        $fecha = date('Y-m-d');
        $asigpersonaldata = [
            'Proyectoper' => $proyectoId,
            'Empleadoper' => $empleado,
            'Fecha' => $fecha
        ];

        $this->asigpersonalmodel->update($asigpersonalId, $asigpersonaldata);

        session()->setFlashdata('success', 'Asignación de personal actualizada exitosamente.');

        return redirect()->to(base_url('/AsigPersonal'));
    } else {
        return redirect()->to(base_url('/AsigPersonal'))->withInput()->with('errors', $this->validator->getErrors());
    }
}

public function Eliminar($asigpersonalId)
{
    $asigpersonalmodel = new AsigPersonalModel();
    $asignacion = $asigpersonalmodel->find($asigpersonalId);

    if (!$asignacion) {
        return $this->response->setJSON(['success' => false, 'message' => 'La asignación de personal no existe.']);
    }

    $proyectoModel = new ProyectosModel();
    $proyecto = $proyectoModel->find($asignacion['Proyectoper']);

    if (!$proyecto) {
        return $this->response->setJSON(['success' => false, 'message' => 'El proyecto asociado no existe.']);
    }

    if ($proyecto['estado'] === 'Completado') {
        return $this->response->setJSON(['success' => false, 'message' => 'No se puede eliminar la asignación porque el proyecto está completado.']);
    }

    try {
        $asigpersonalmodel->delete($asigpersonalId);
        return $this->response->setJSON(['success' => true, 'message' => 'La asignación de personal se eliminó correctamente.']);
    } catch (\Exception $e) {
        return $this->response->setJSON(['success' => false, 'message' => $e->getMessage()]);
    }
}

}
