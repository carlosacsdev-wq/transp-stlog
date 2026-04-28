<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PagamentoController extends Controller
{
    public function index()
    {
        $pagamentos = \App\Models\Pagamento::all();
        return view('pagamentos.index', compact('pagamentos'));
    }

    public function create()
    {
        return view('pagamentos.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'cte' => 'required',
            'dt' => 'required',
            'data_pagamento' => 'required|date',
            'valor_frete' => 'required|numeric',
            'nome_motorista' => 'required',
        ]);

        \App\Models\Pagamento::create($request->all());
        return redirect()->route('pagamentos.index')->with('success', 'Pagamento criado com sucesso.');
    }

    public function edit(\App\Models\Pagamento $pagamento)
    {
        return view('pagamentos.edit', compact('pagamento'));
    }

    public function update(Request $request, \App\Models\Pagamento $pagamento)
    {
        $request->validate([
            'cte' => 'required',
            'dt' => 'required',
            'data_pagamento' => 'required|date',
            'valor_frete' => 'required|numeric',
            'nome_motorista' => 'required',
        ]);

        $pagamento->update($request->all());
        return redirect()->route('pagamentos.index')->with('success', 'Pagamento atualizado com sucesso.');
    }

    public function destroy(\App\Models\Pagamento $pagamento)
    {
        $pagamento->delete();
        return redirect()->route('pagamentos.index')->with('success', 'Pagamento excluído com sucesso.');
    }}
