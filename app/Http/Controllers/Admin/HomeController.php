<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Permite el acceso solo a usuarios autentificados con el rol administrador.
     */
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    /**
     * Muestra la pantalla inicial de la administración.
     */
    public function index() {
        return view('admin.index');
    }
}
