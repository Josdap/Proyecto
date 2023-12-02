<?php

namespace App\Controllers;

use App\Models\DocumentacionModel;
use CodeIgniter\Controller;

class Documentacion extends BaseController
{

    public function __construct()
    {
        helper(['form', 'url']);
        $this->documentacionmodel = new DocumentacionModel();
    }

    public function index()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to(base_url('Login'));
        }

        

        $data['proyectos'] = $this->documentacionmodel->getProyecto();
        $data['documentos'] = $this->documentacionmodel
            ->select('documentacion.idDocumentacion, documentacion.Tipodoc, documentacion.Fechadoc, documentacion.documento, proyectos.nombrep as proyecto')
            ->join('proyectos', 'proyectos.idProyectos = documentacion.Proyectodoc')
            ->findAll();

        return view('documentacion', $data);
    }

public function Registrar()
{
    $validationRules = [
        'Proyectodoc' => 'required',
        'Tipodoc' => 'required',
        'documento' => 'uploaded[documento]|max_size[documento,30720]'
        
    ];

    $fecha = date('Y-m-d');

    if ($this->validate($validationRules)) {
        $documentoFile = $this->request->getFile('documento');

        if ($documentoFile && $documentoFile->isValid() && !$documentoFile->hasMoved()) {
            $uploadPath = ROOTPATH . 'public/uploads/documents';

            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }

            
            $newName = $documentoFile->getName();

            
            $documentoFile->move($uploadPath, $newName);

            $documentodata = [
                'Proyectodoc' => $this->request->getPost('Proyectodoc'),
                'Tipodoc' => $this->request->getPost('Tipodoc'),
                'documento' => $newName,
                'Fechadoc' => $fecha
            ];

            $this->documentacionmodel->insert($documentodata);

            session()->setFlashdata('success', 'Documentacion registrado exitosamente.');
            return redirect()->to(base_url('/Documentacion'));
        }
    } else {
        return redirect()->to(base_url('/Documentacion'))->withInput()->with('errors', $this->validator->getErrors());
    }
}

public function editar($documentacionId)
{
    $validationRules = [
        'Proyectodoc' => 'required',
        'Tipodoc' => 'required',
        'documento' => 'max_size[documento,30720]'
    ];

    $fecha = date('Y-m-d');

    if ($this->validate($validationRules)) {
        $documentoFile = $this->request->getFile('documento');

        if ($documentoFile && $documentoFile->isValid() && !$documentoFile->hasMoved()) {
            $uploadPath = ROOTPATH . 'public/uploads/documents';

            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }

            $newName = $documentoFile->getName();

            $documentoFile->move($uploadPath, $newName);

            $documentodata = [
                'Proyectodoc' => $this->request->getPost('Proyectodoc'),
                'Tipodoc' => $this->request->getPost('Tipodoc'),
                'documento' => $newName,
                'Fechadoc' => $fecha
            ];
        } else {
            
            $documentodata = [
                'Proyectodoc' => $this->request->getPost('Proyectodoc'),
                'Tipodoc' => $this->request->getPost('Tipodoc'),
                'Fechadoc' => $fecha
            ];
        }

        $documentacionmodel = new DocumentacionModel();
        $documentacionmodel->update($documentacionId, $documentodata);

        session()->setFlashdata('success', 'Documentación actualizada exitosamente.');
        return redirect()->to(base_url('/Documentacion'));
    } else {
        return redirect()->to(base_url('/Documentacion'))->withInput()->with('errors', $this->validator->getErrors());
    }
}


public function Eliminar($documentacionId)
{
    $documentacionmodel = new DocumentacionModel();
    $documento = $documentacionmodel->find($documentacionId)['documento'];
    $documentacionmodel->delete($documentacionId);
    $uploadPath = ROOTPATH . 'public/uploads/documents';
    $documentoPath = $uploadPath . '/' . $documento;

    if (file_exists($documentoPath)) {
        unlink($documentoPath);
    }

    return redirect()->back()->with('success', 'La documentación se eliminó correctamente.');
}

}

