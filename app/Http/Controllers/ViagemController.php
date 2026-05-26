<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Carga;
use App\Models\Motorista;
use App\Models\Veiculo;

class ViagemController extends Controller
{
    public function index(Request $request)
    {
        $query = Carga::with(['motorista', 'veiculo'])
            ->whereNotNull('cte')
            ->where('cte', '!=', '');
 
        if ($request->filled('fabrica')) {
            $query->where('fabrica', $request->fabrica);
        }
 
        $viagens = $query->paginate(10);
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
            'data_carregamento' => 'required|date',
            'cte' => 'required',
        ]);

        Carga::create($request->all());
        return redirect()->route('viagens.index', ['tenant' => request()->route('tenant')])->with('success', 'Viagem criada com sucesso.');
    }

    public function edit()
    {
        $viagem = Carga::findOrFail(request()->route('viagem'));
        $motoristas = Motorista::all();
        $veiculos = Veiculo::with('motorista')->get();
        return view('viagens.edit', compact('viagem', 'motoristas', 'veiculos'));
    }

    public function update(Request $request)
    {
        $viagem = Carga::findOrFail(request()->route('viagem'));
        $request->validate([
            'motorista_id' => 'required|exists:motoristas,id',
            'veiculo_id' => 'required|exists:veiculos,id',
            'data_carregamento' => 'required|date',
            'data_hora_chegada' => 'nullable|date',
            'data_hora_descarga' => 'nullable|date',
            'cte' => 'required',
        ]);

        $viagem->update($request->all());
        return redirect()->route('viagens.index', ['tenant' => request()->route('tenant')])->with('success', 'Viagem atualizada com sucesso.');
    }

    public function destroy()
    {
        $viagem = Carga::findOrFail(request()->route('viagem'));
        $viagem->delete();
        return redirect()->route('viagens.index', ['tenant' => request()->route('tenant')])->with('success', 'Viagem excluída com sucesso.');
    }
}
