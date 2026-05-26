<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Veiculo;

class VeiculoController extends Controller
{
    public function index()
    {
        $veiculos = Veiculo::with('motorista')->paginate(10);
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
        return redirect()->route('veiculos.index', ['tenant' => request()->route('tenant')])->with('success', 'Veículo criado com sucesso.');
    }

    public function edit()
    {
        $veiculo = Veiculo::findOrFail(request()->route('veiculo'));
        $motoristas = \App\Models\Motorista::all();
        return view('veiculos.edit', compact('veiculo', 'motoristas'));
    }

    public function update(Request $request)
    {
        $veiculo = Veiculo::findOrFail(request()->route('veiculo'));
        $request->validate([
            'motorista_id' => 'required',
            'placa_cavalo' => 'required',
            'placa_carreta' => 'required',
        ]);

        $veiculo->update($request->all());
        return redirect()->route('veiculos.index', ['tenant' => request()->route('tenant')])->with('success', 'Veículo atualizado com sucesso.');
    }

    public function destroy()
    {
        $veiculo = Veiculo::findOrFail(request()->route('veiculo'));
        $veiculo->delete();
        return redirect()->route('veiculos.index', ['tenant' => request()->route('tenant')])->with('success', 'Veículo excluído com sucesso.');
    }
}
