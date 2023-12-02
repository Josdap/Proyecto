<?php

namespace App\Controllers;
use CodeIgniter\Controller;
use App\Models\RecursosModel;
use Dompdf\Dompdf;
use Dompdf\Options;
require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Recursos extends BaseController
{
    public function __construct()
    {
        helper(['form', 'url']);
        $this->recursoModel = new RecursosModel();
    }

    public function index()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to(base_url('Login'));
        }
        
        $data['tipos'] = $this->recursoModel->getTipo();

        $data['recursos'] = $this->recursoModel
            ->select('recursos.idRecursos, recursos.Nombre, recursos.Stock, tiporecursos.Tiporecurso as tipo')
            ->join('tiporecursos', 'tiporecursos.idTiporecursos = recursos.Tipo')
            ->findAll();

        return view('recursos', $data);
    }

public function Registrar()
{
    $validationRules = [
        'Nombre' => 'required',
        'Tipo' => 'required',
        'Stock' => 'required'
    ];

    if ($this->validate($validationRules)) {
        $nombre = $this->request->getPost('Nombre');
        $tipo = $this->request->getPost('Tipo');
        $stock = $this->request->getPost('Stock');


        $existingResource = $this->recursoModel->where('Nombre', $nombre)->first();

        if ($existingResource) {
            
            $newStock = $existingResource['Stock'] + $stock;
            $this->recursoModel->update($existingResource['idRecursos'], ['Stock' => $newStock]);
        } else {
            
            $recursodata = [
                'Nombre' => $nombre,
                'Tipo' => $tipo,
                'Stock' => $stock
            ];

            $this->recursoModel->insert($recursodata);
        }

        session()->setFlashdata('success', 'Recurso registrado exitosamente.');
        return redirect()->to(base_url('/Recursos'));
    } else {
        return redirect()->to(base_url('/Recursos'))->withInput()->with('errors', $this->validator->getErrors());
    }
}


        public function editar($recursosId)
{
    $validationRules = [
        'Nombre' => 'required',
        'Tipo' => 'required',
        'Stock' => 'required|numeric',

       
    ];

    if ($this->validate($validationRules)) {
        $recursodata = [
            'Nombre' => $this->request->getPost('Nombre'),
            'Tipo' => $this->request->getPost('Tipo'),
            'Stock' => $this->request->getPost('Stock'),
        ];

        $recursoModel = new RecursosModel();
        $recursoModel->update($recursosId, $recursodata);

        
        session()->setFlashdata('success', 'Recurso actualizado exitosamente.');

        return redirect()->to(base_url('/Recursos'));
    } else {
        return redirect()->to(base_url('/Recursos'))->withInput()->with('errors', $this->validator->getErrors());
    }
}

    public function Eliminar($recursosId)
    {
        $recursoModel = new RecursosModel();
        $recursoModel->delete($recursosId);

        return redirect()->back()->with('success', 'El recurso se eliminó correctamente.');
    }

    public function generarPDF()
    {   $recursoModel = new RecursosModel();
        $data['tipos'] = $this->recursoModel->getTipo();
        $data['recursos'] = $this->recursoModel
            ->select('recursos.idRecursos, recursos.Nombre, recursos.Stock, tiporecursos.Tiporecurso as tipo')
            ->join('tiporecursos', 'tiporecursos.idTiporecursos = recursos.Tipo')
            ->findAll();

        $html = view('reporte_recursos', $data);

        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
         $dompdf->set_option('isRemoteEnabled', true);
        $dompdf->render();

        $dompdf->stream('reporte_recursos.pdf', ['Attachment' => true]);
    }

}
