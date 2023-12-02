<?php
namespace App\Controllers;
use CodeIgniter\Controller;
use App\Models\PersonalModel;
use Dompdf\Dompdf;
use Dompdf\Options;
require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
class Personal extends BaseController
{
	public function __construct() 
	{
		helper(['form', 'url']);
       	$this->personalModel = new PersonalModel();	            	
    }
	public function index()
	{
		if (!session()->get('isLoggedIn')) {
            
            return redirect()->to(base_url('Login'));
        }
        $data['roles'] = $this->personalModel->getRol();

        $data['empleado'] = $this->personalModel
        ->select('empleados.idEmpleado, empleados.Nombre, empleados.Telefono, cargos.Cargo as Cargo')
    ->join('cargos', 'cargos.idCargo = empleados.Cargoe')
    ->findAll();

		return view('personal',$data);
	}

	public function Registrar(){
		$validationRules=[
			'Nombre' => 'required',
			'Cargoe' => 'required',
			'Telefono' => 'required|numeric'

		];

		if ($this->validate($validationRules)) {
            $personaldata = [
                'Nombre' => $this->request->getPost('Nombre'),
                'Cargoe' => $this->request->getPost('Cargoe'),
                'Telefono' => $this ->request->getPost('Telefono')
            ];

             $this->personalModel->insert($personaldata);

              session()->setFlashdata('success', 'Trabajador registrado exitosamente.');
              return redirect()->to(base_url('/Personal'));
               } else {
               	return redirect()->to(base_url('/Personal'))->withInput()->with('errors', $this->validator->getErrors());
        }

	}

		public function editar($personalId)
   {
    $validationRules = [
        'Nombre' => 'required',
        'Cargoe' => 'required',
        'Telefono' => 'required|numeric', 
    ];

    if ($this->validate($validationRules)) {
        $personaldata = [
            'Nombre' => $this->request->getPost('Nombre'),
            'Cargoe' => $this->request->getPost('Cargoe'),
            'Telefono' => $this->request->getPost('Telefono'),
        ];

        $personalModel = new PersonalModel();
        $personalModel->update($personalId, $personaldata);

        session()->setFlashdata('success', 'Trabajador actualizado exitosamente.');

        return redirect()->to(base_url('/Personal'));
    } else {
        return redirect()->to(base_url('/Personal'))->withInput()->with('errors', $this->validator->getErrors());
    }
}

           public function Eliminar($personalId)
    {
        $personalModel = new PersonalModel();
        $personalModel->delete($personalId);

        return redirect()->back()->with('success', 'El trabajador se eliminó correctamente.');
    }



         public function generarPDF()
    {   $personalModel = new PersonalModel();
        $data['roles'] = $this->personalModel->getRol();
        $data['empleado'] = $this->personalModel
        ->select('empleados.idEmpleado, empleados.Nombre, empleados.Telefono, cargos.Cargo as Cargo')
        ->join('cargos', 'cargos.idCargo = empleados.Cargoe')
        ->findAll();

        $html = view('reporte_personal', $data);

        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
         $dompdf->set_option('isRemoteEnabled', true);
        $dompdf->render();

        $dompdf->stream('reporte_personal.pdf', ['Attachment' => true]);
    }


}