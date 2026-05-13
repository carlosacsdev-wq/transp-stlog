<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Veiculo;

class VeiculoController extends Controller
{
    public function index()
    {
        $veiculos = Veiculo::with('motorista')->get();
        return view('veiculos.index', compact('veiculos'));
    }

    public function create()
    {
        $motoristas = \App\Models\Motorista::all();
        return view('veiculos.create', compact('motoristas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'motorista_id' => 'required',
            'placa_cavalo' => 'required',
            'placa_carreta' => 'required',
        ]);

        Veiculo::create($request->all());
        return redirect()->route('veiculos.index')->with('success', 'Veículo criado com sucesso.');
    }

    public function edit(Veiculo $veiculo)
    {
        $motoristas = \App\Models\Motorista::all();
        return view('veiculos.edit', compact('veiculo', 'motoristas'));
    }

    public function update(Request $request, Veiculo $veiculo)
    {
        $request->validate([
            'motorista_id' => 'required',
            'placa_cavalo' => 'required',
            'placa_carreta' => 'required',
        ]);

        $veiculo->update($request->all());
        return redirect()->route('veiculos.index')->with('success', 'Veículo atualizado com sucesso.');
    }

    public function destroy(Veiculo $veiculo)
    {
        $veiculo->delete();
        return redirect()->route('veiculos.index')->with('success', 'Veículo excluído com sucesso.');
    }
}
