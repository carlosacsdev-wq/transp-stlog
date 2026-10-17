<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Carga;
use App\Models\Motorista;
use App\Models\Veiculo;

class CargaController extends Controller
{
    public function index()
    {
        $cargas = Carga::with(['motorista.veiculos', 'veiculo'])
            ->where(function($query) {
                $query->whereNull('cte')->orWhere('cte', '');
            })
            ->paginate(10);
        return view('cargas.index', compact('cargas'));
    }

    public function create()
    {
        $motoristas = Motorista::all();
        $veiculos = Veiculo::with('motorista')->get();
        return view('cargas.create', compact('motoristas', 'veiculos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'motorista_id' => 'nullable|exists:motoristas,id',
            'veiculo_id' => 'nullable|exists:veiculos,id',
            'numero_dt' => 'required',
            'data_carregamento' => 'required|date',
            'data_agendamento_descarga' => 'required|date',
            'cliente' => 'required',
            'valor_frete' => 'required|numeric',
            'status' => 'required|string|in:Pendente,Comprometida,Cancelada,Declinada,Retirada'
        ]);

        Carga::create($request->all());
        return redirect()->route('cargas.index', ['tenant' => request()->route('tenant')])->with('success', 'Carga criada com sucesso.');
    }

    public function edit()
    {
        $carga = Carga::findOrFail(request()->route('carga'));
        $motoristas = Motorista::all();
        $veiculos = Veiculo::with('motorista')->get();
        return view('cargas.edit', compact('carga', 'motoristas', 'veiculos'));
    }

    public function update(Request $request)
    {
        $carga = Carga::findOrFail(request()->route('carga'));
        $request->validate([
            'motorista_id' => 'nullable|exists:motoristas,id',
            'veiculo_id' => 'nullable|exists:veiculos,id',
            'numero_dt' => 'required',
            'data_carregamento' => 'required|date',
            'data_agendamento_descarga' => 'required|date',
            'cliente' => 'required',
            'valor_frete' => 'required|numeric',
            'status' => 'required|string|in:Pendente,Comprometida,Cancelada,Declinada,Retirada',
        ]);

        $carga->update($request->all());
        return redirect()->route('cargas.index', ['tenant' => request()->route('tenant')])->with('success', 'Carga atualizada com sucesso.');
    }

    public function destroy()
    {
        $carga = Carga::findOrFail(request()->route('carga'));
        $carga->delete();
        return redirect()->route('cargas.index', ['tenant' => request()->route('tenant')])->with('success', 'Carga excluída com sucesso.');
    }
}
