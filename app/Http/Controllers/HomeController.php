<?php

namespace App\Http\Controllers;

use App\Models\Carga;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $atendidas = Carga::whereNotNull('data_hora_descarga')->count();
        $canceladas = Carga::where('status', 'Cancelada')->count();
        $declinadas = Carga::where('status', 'Declinada')->count();
        $retiradas = Carga::where('status', 'Retirada')->count();

        return view('home', compact('atendidas', 'canceladas', 'declinadas', 'retiradas'));
    }
}
