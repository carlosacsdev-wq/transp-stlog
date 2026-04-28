<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Carga;

class CargaController extends Controller
{
    public function index()
    {
        $cargas = Carga::all();
        return view('cargas.index', compact('cargas'));
    }

    public function create()
    {
        return view('cargas.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'numero_dt' => 'required',
            'data_carregamento' => 'required|date',
            'data_agendamento_descarga' => 'required|date',
            'cliente' => 'required',
            'valor_frete' => 'required|numeric',
        ]);

        Carga::create($request->all());
        return redirect()->route('cargas.index')->with('success', 'Carga criada com sucesso.');
    }

    public function edit(Carga $carga)
    {
        return view('cargas.edit', compact('carga'));
    }

    public function update(Request $request, Carga $carga)
    {
        $request->validate([
            'numero_dt' => 'required',
            'data_carregamento' => 'required|date',
            'data_agendamento_descarga' => 'required|date',
            'cliente' => 'required',
            'valor_frete' => 'required|numeric',
        ]);

        $carga->update($request->all());
        return redirect()->route('cargas.index')->with('success', 'Carga atualizada com sucesso.');
    }

    public function destroy(Carga $carga)
    {
        $carga->delete();
        return redirect()->route('cargas.index')->with('success', 'Carga excluída com sucesso.');
    }
}
