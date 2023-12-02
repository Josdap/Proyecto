<?php
namespace App\Controllers;
use CodeIgniter\Controller;
use App\Models\ClientesModel;
use Dompdf\Dompdf;
use Dompdf\Options;
require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;



class Clientes extends BaseController
{
	public function __construct() 
	{
		helper(['form', 'url']);
		$this->clientesModel = new ClientesModel();
       	    	            	
    }
	public function index()
	{
		if (!session()->get('isLoggedIn')) {
           
            return redirect()->to(base_url('Login'));
        }
		$data['clientes'] = $this->clientesModel->findAll();
		return view('clientes',$data);
	}

		public function Registrar(){
		$validationRules=[
			'Nombre' => 'required',
			'Direccion' => 'required',
			'Telefono' => 'required|numeric',
			'Correo' => 'required|valid_email'

		];

		if ($this->validate($validationRules)) {
            $clientesdata = [
                'Nombre' => $this->request->getPost('Nombre'),
                'Direccion' => $this->request->getPost('Direccion'),
                'Telefono' => $this->request->getPost('Telefono'),
                'Correo' => $this->request->getPost('Correo')

                
            ];

             $this->clientesModel->insert($clientesdata);

              session()->setFlashdata('success', 'Cliente registrado exitosamente.');
              return redirect()->to(base_url('/Clientes'));
               } else {
               	return redirect()->to(base_url('/Clientes'))->withInput()->with('errors', $this->validator->getErrors());
        }

	}



	public function editar($clientesId)
{
    $validationRules = [
        'Nombre' => 'required',
        'Direccion' => 'required',
        'Telefono' => 'required|numeric',
        'Correo' => 'required|valid_email'
    ];

    if ($this->validate($validationRules)) {
        $clientesdata = [
            'Nombre' => $this->request->getPost('Nombre'),
            'Direccion' => $this->request->getPost('Direccion'),
            'Telefono' => $this->request->getPost('Telefono'),
            'Correo' => $this->request->getPost('Correo')
        ];

        $clientesModel = new ClientesModel();
        $clientesModel->update($clientesId, $clientesdata);

        
        session()->setFlashdata('success', 'Cliente actualizado exitosamente.');

        return redirect()->to(base_url('/Clientes'));
    } else {
        return redirect()->to(base_url('/Clientes'))->withInput()->with('errors', $this->validator->getErrors());
    }
}

       public function Eliminar($clientesId)
    {
        $clientesModel = new ClientesModel();
        $clientesModel->delete($clientesId);

        return redirect()->back()->with('success', 'El cliente se eliminó correctamente.');
    }
    


         public function generarPDF()
    {   $clientesModel = new ClientesModel();
        $data['clientes'] = $this->clientesModel->findAll();

        $html = view('reporte_clientes', $data);

        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
         $dompdf->set_option('isRemoteEnabled', true);
        $dompdf->render();

        $dompdf->stream('reporte_clientes.pdf', ['Attachment' => true]);
    }


}