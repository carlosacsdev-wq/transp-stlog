<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ViagemController extends Controller
{
    public function index()
    {
        $viagens = \App\Models\Viagem::all();
        return view('viagens.index', compact('viagens'));
    }

    public function create()
    {
        return view('viagens.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'data_hora_carregamento' => 'required|date',
            'nome_motorista' => 'required',
            'cte' => 'required',
        ]);

        \App\Models\Viagem::create($request->all());
        return redirect()->route('viagens.index')->with('success', 'Viagem criada com sucesso.');
    }

    public function edit(\App\Models\Viagem $viagem)
    {
        return view('viagens.edit', compact('viagem'));
    }

    public function update(Request $request, \App\Models\Viagem $viagem)
    {
        $request->validate([
            'data_hora_carregamento' => 'required|date',
            'nome_motorista' => 'required',
            'cte' => 'required',
        ]);

        $viagem->update($request->all());
        return redirect()->route('viagens.index')->with('success', 'Viagem atualizada com sucesso.');
    }

    public function destroy(\App\Models\Viagem $viagem)
    {
        $viagem->delete();
        return redirect()->route('viagens.index')->with('success', 'Viagem excluída com sucesso.');
    }}
