<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Viagem;
use App\Models\Motorista;
use App\Models\Veiculo;

class ViagemController extends Controller
{
    public function index()
    {
        $viagens = Viagem::with(['motorista', 'veiculo'])->get();
        return view('viagens.index', compact('viagens'));
    }

    public function create()
    {
        $motoristas = Motorista::all();
        $veiculos = Veiculo::with('motorista')->get();
        return view('viagens.create', compact('motoristas', 'veiculos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'motorista_id' => 'required|exists:motoristas,id',
            'veiculo_id' => 'required|exists:veiculos,id',
            'data_hora_carregamento' => 'required|date',
            'cte' => 'required',
        ]);

        Viagem::create($request->all());
        return redirect()->route('viagens.index')->with('success', 'Viagem criada com sucesso.');
    }

    public function edit(Viagem $viagem)
    {
        $motoristas = Motorista::all();
        $veiculos = Veiculo::with('motorista')->get();
        return view('viagens.edit', compact('viagem', 'motoristas', 'veiculos'));
    }

    public function update(Request $request, Viagem $viagem)
    {
        $request->validate([
            'motorista_id' => 'required|exists:motoristas,id',
            'veiculo_id' => 'required|exists:veiculos,id',
            'data_hora_carregamento' => 'required|date',
            'cte' => 'required',
        ]);

        $viagem->update($request->all());
        return redirect()->route('viagens.index')->with('success', 'Viagem atualizada com sucesso.');
    }

    public function destroy(Viagem $viagem)
    {
        $viagem->delete();
        return redirect()->route('viagens.index')->with('success', 'Viagem excluída com sucesso.');
    }
}
