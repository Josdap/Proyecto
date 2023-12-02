<?php

namespace App\Controllers;
use CodeIgniter\Controller;
use App\Models\AsigRecursoModel;
use App\Models\RecursosModel;
use App\Models\ProyectosModel;

class AsigRecurso extends BaseController
{
    public function __construct() 
    {
        helper(['form', 'url']);
        $this->asigrecursomodel = new AsigRecursoModel();
    }

    public function index()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to(base_url('Login'));
        }
        $data['proyectos'] = $this->asigrecursomodel->getProyecto();
        $data['recursos'] = $this->asigrecursomodel->getRecurso();
        $data['asigrecurso'] = $this->asigrecursomodel
            ->select('asignacionre.idAsignacionre, asignacionre.Cantidad, asignacionre.Fecha, proyectos.nombrep as proyecto, recursos.Nombre as recurso')
            ->join('proyectos', 'proyectos.idProyectos = asignacionre.Proyectosre')
            ->join('recursos', 'recursos.idRecursos = asignacionre.Recursosre')
            ->findAll();
        return view('asigrecurso', $data);
    }

public function Registrar()
{
    $validationRules = [
        'Proyectosre' => 'required',
        'Recursosre' => 'required',
        'Cantidad' => 'required|greater_than[0]'
    ];

    if ($this->validate($validationRules)) {
        $proyectoModel = new ProyectosModel();
        $proyectoId = $this->request->getPost('Proyectosre');
        $proyecto = $proyectoModel->find($proyectoId);

        if ($proyecto) {
            $estadoProyecto = $proyecto['estado'];

            if ($estadoProyecto === 'Completado') {
                session()->setFlashdata('error', 'No se pueden asignar recursos a un proyecto "Completado".');
                return redirect()->to(base_url('/AsigRecurso'))->withInput();
            }

            $recursoid = $this->request->getPost('Recursosre');
            $cantidadAsignada = $this->request->getPost('Cantidad');

            $recursoModel = new RecursosModel();
            $recurso = $recursoModel->find($recursoid);

            if ($recurso) {
                $stockActual = $recurso['Stock'];
                $fecha = date('Y-m-d');

               
                $existingResource = $this->asigrecursomodel->where(['Proyectosre' => $proyectoId, 'Recursosre' => $recursoid])->first();

                if ($existingResource) {
                    
                    $newStock = $existingResource['Cantidad'] + $cantidadAsignada;

                    
                    if ($cantidadAsignada <= $stockActual) {
                        $this->asigrecursomodel->update($existingResource['idAsignacionre'], ['Cantidad' => $newStock]);
                    } else {
                        session()->setFlashdata('error', 'No hay suficiente stock disponible para asignar la cantidad solicitada.');
                        return redirect()->to(base_url('/AsigRecurso'))->withInput();
                    }
                } else {
                    
                    if ($cantidadAsignada <= $stockActual) {
                        $asigrecursodata = [
                            'Proyectosre' => $proyectoId,
                            'Recursosre' => $recursoid,
                            'Cantidad' => $cantidadAsignada,
                            'Fecha' => $fecha
                        ];

                        $this->asigrecursomodel->insert($asigrecursodata);
                    } else {
                        session()->setFlashdata('error', 'No hay suficiente stock disponible para asignar la cantidad solicitada.');
                        return redirect()->to(base_url('/AsigRecurso'))->withInput();
                    }
                }

                $nuevoStock = $stockActual - $cantidadAsignada;
                $recursoModel->update($recursoid, ['Stock' => $nuevoStock]);

                session()->setFlashdata('success', 'Asignación registrada exitosamente.');
                return redirect()->to(base_url('/AsigRecurso'));
            } else {
                session()->setFlashdata('error', 'El recurso seleccionado no existe.');
                return redirect()->to(base_url('/AsigRecurso'))->withInput();
            }
        } else {
            session()->setFlashdata('error', 'El proyecto seleccionado no existe.');
            return redirect()->to(base_url('/AsigRecurso'))->withInput();
        }
    } else {
        return redirect()->to(base_url('/AsigRecurso'))->withInput()->with('errors', $this->validator->getErrors());
    }
}

}
