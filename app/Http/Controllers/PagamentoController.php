<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pagamento;
use App\Models\Motorista;
use App\Models\Veiculo;

class PagamentoController extends Controller
{
    public function index()
    {
        $pagamentos = Pagamento::with(['motorista', 'veiculo'])->get();
        return view('pagamentos.index', compact('pagamentos'));
    }

    public function create()
    {
        $motoristas = Motorista::all();
        $veiculos = Veiculo::with('motorista')->get();
        return view('pagamentos.create', compact('motoristas', 'veiculos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'motorista_id' => 'required|exists:motoristas,id',
            'veiculo_id' => 'required|exists:veiculos,id',
            'cte' => 'required',
            'dt' => 'required',
            'data_pagamento' => 'required|date',
            'valor_frete' => 'required|numeric',
        ]);

        Pagamento::create($request->all());
        return redirect()->route('pagamentos.index')->with('success', 'Pagamento criado com sucesso.');
    }

    public function edit(Pagamento $pagamento)
    {
        $motoristas = Motorista::all();
        $veiculos = Veiculo::with('motorista')->get();
        return view('pagamentos.edit', compact('pagamento', 'motoristas', 'veiculos'));
    }

    public function update(Request $request, Pagamento $pagamento)
    {
        $request->validate([
            'motorista_id' => 'required|exists:motoristas,id',
            'veiculo_id' => 'required|exists:veiculos,id',
            'cte' => 'required',
            'dt' => 'required',
            'data_pagamento' => 'required|date',
            'valor_frete' => 'required|numeric',
        ]);

        $pagamento->update($request->all());
        return redirect()->route('pagamentos.index')->with('success', 'Pagamento atualizado com sucesso.');
    }

    public function destroy(Pagamento $pagamento)
    {
        $pagamento->delete();
        return redirect()->route('pagamentos.index')->with('success', 'Pagamento excluído com sucesso.');
    }
}
