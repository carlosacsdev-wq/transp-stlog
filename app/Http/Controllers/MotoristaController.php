<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Motorista;

class MotoristaController extends Controller
{
    public function index()
    {
        $motoristas = Motorista::paginate(10);
        return view('motoristas.index', compact('motoristas'));
    }

    public function create()
    {
        return view('motoristas.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required',
            'nome_mae' => 'required|string|max:255',
            'cpf' => 'required|unique:motoristas,cpf,NULL,id,tenant_id,' . auth()->user()->tenant_id,
        ]);

        Motorista::create($request->all());
        return redirect()->route('motoristas.index', ['tenant' => request()->route('tenant')])->with('success', 'Motorista criado com sucesso.');
    }

    public function edit()
    {
        $motorista = Motorista::findOrFail(request()->route('motorista'));
        return view('motoristas.edit', compact('motorista'));
    }

    public function update(Request $request)
    {
        $motorista = Motorista::findOrFail(request()->route('motorista'));

        $request->validate([
            'nome' => 'required',
            'nome_mae' => 'required|string|max:255',
            'cpf' => 'required|unique:motoristas,cpf,' . $motorista->id . ',id,tenant_id,' . auth()->user()->tenant_id,
        ]);

        $motorista->update($request->all());
        return redirect()->route('motoristas.index', ['tenant' => request()->route('tenant')])->with('success', 'Motorista atualizado com sucesso.');
    }

    public function destroy()
    {
        $motorista = Motorista::findOrFail(request()->route('motorista'));
        $motorista->delete();
        return redirect()->route('motoristas.index', ['tenant' => request()->route('tenant')])->with('success', 'Motorista excluído com sucesso.');
    }
}
