<?php
namespace App\Controllers;
use CodeIgniter\Controller;
use App\Models\TipoRecursoModel;
class TipoRecursos extends BaseController
{
	public function __construct() 
	{
		helper(['form', 'url']);
		$this->tiporecursomodel = new TipoRecursoModel();
       	    	            	
    }
	public function index()
	{
		if (!session()->get('isLoggedIn')) {
           
            return redirect()->to(base_url('Login'));
        }
		
		$data['tipos'] = $this->tiporecursomodel->findAll();
		return view('tiporecurso', $data);
	}

		public function Registrar(){
		$validationRules=[
			'Tiporecurso' => 'required'
			

		];

		if ($this->validate($validationRules)) {
            $tiporecursodata = [
                'Tiporecurso' => $this->request->getPost('Tiporecurso')
                
            ];

             $this->tiporecursomodel->insert($tiporecursodata);

              session()->setFlashdata('success', 'Tipo de Recurso registrado exitosamente.');
              return redirect()->to(base_url('/TipoRecursos'));
               } else {
               	return redirect()->to(base_url('/TipoRecursos'))->withInput()->with('errors', $this->validator->getErrors());
        }

	}

	public function editar($tiporecursoId)
{
    $validationRules = [
        'Tiporecurso' => 'required'

    ];

    if ($this->validate($validationRules)) {
        $tiporecursodata = [
            'Tiporecurso' => $this->request->getPost('Tiporecurso'),

        ];

        $tiporecursomodel = new TipoRecursoModel();
        $tiporecursomodel->update($tiporecursoId, $tiporecursodata);

        
        session()->setFlashdata('success', 'Tipo de Recurso actualizado exitosamente.');

        return redirect()->to(base_url('/TipoRecursos'));
    } else {
        return redirect()->to(base_url('/TipoRecursos'))->withInput()->with('errors', $this->validator->getErrors());
    }
}


    public function Eliminar($tiporecursoId)
    {
        $tiporecursomodel = new TipoRecursoModel();
        $tiporecursomodel->delete($tiporecursoId);

        return redirect()->back()->with('success', 'El tipo de recurso se eliminó correctamente.');
    }

}