<?php

namespace App\Models;

use CodeIgniter\Model;

class DocumentacionModel extends Model
{
    protected $table = 'documentacion';
    protected $primaryKey = 'idDocumentacion';
    protected $allowedFields = ['Proyectodoc', 'Tipodoc', 'Fechadoc', 'documento'];

     public function getProyecto()
    {
        return $this->db->table('proyectos')->get()->getResult();
    }


    public function getDocporproyecto()
{
    return $this->select('proyectos.nombrep as proyecto, COUNT(documento) as documento')
        ->join('proyectos', 'proyectos.idProyectos = documentacion.Proyectodoc')
        ->groupBy('proyecto')
        ->findAll();
}
}
