<?php
namespace App\Controllers;
use CodeIgniter\Controller;
class Inicio extends BaseController
{
	public function __construct() 
	{
		helper(['form', 'url']);
       	    	            	
    }
	public function index()
	{
		
		return view('inicio');
	}


}