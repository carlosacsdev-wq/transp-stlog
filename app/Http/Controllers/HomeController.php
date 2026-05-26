<?php

namespace App\Http\Controllers;

use App\Models\Carga;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $query = Carga::query();

        if ($request->filled('data_inicio')) {
            $query->whereDate('data_carregamento', '>=', $request->data_inicio);
        }

        if ($request->filled('data_fim')) {
            $query->whereDate('data_carregamento', '<=', $request->data_fim);
        }

        if ($request->filled('fabrica')) {
            $query->where('fabrica', $request->fabrica);
        }

        $atendidas = (clone $query)->whereNotNull('data_hora_descarga')->count();
        $canceladas = (clone $query)->where('status', 'Cancelada')->count();
        $declinadas = (clone $query)->where('status', 'Declinada')->count();
        $retiradas = (clone $query)->where('status', 'Retirada')->count();

        $cargasAtendidasPorMes = (clone $query)
            ->whereNotNull('data_hora_descarga')
            ->selectRaw('MONTH(data_carregamento) as mes, count(*) as total')
            ->groupBy('mes')
            ->pluck('total', 'mes')
            ->toArray();

        $meses = [];
        for ($i = 1; $i <= 12; $i++) {
            $meses[] = $cargasAtendidasPorMes[$i] ?? 0;
        }

        $fabricas = Carga::select('fabrica')->distinct()->whereNotNull('fabrica')->pluck('fabrica');

        return view('home', compact(
            'atendidas', 'canceladas', 'declinadas', 'retiradas',
            'meses', 'fabricas', 'request'
        ));
    }
}
