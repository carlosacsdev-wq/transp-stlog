<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreContaRequest;
use App\Http\Requests\UpdateContaRequest;
use App\Models\Conta;
use App\Models\Motorista;
use Illuminate\Http\Request;

class ContaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $contas = Conta::with('motorista')->paginate(10);
        return view('contas.index', compact('contas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $motoristas = Motorista::all();
        return view('contas.create', compact('motoristas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'motorista_id' => 'required|exists:motoristas,id',
            'titular' => 'required|string|max:255',
            'cpf_cnpj_titular' => 'required|string|max:20',
            'banco' => 'required|string|max:100',
            'agencia' => 'required|string|max:20',
            'tipo_conta' => 'required|string|max:50',
            'nro_conta' => 'required|string|max:50',
            'tipo_chave' => 'nullable|string|max:50',
            'chave_pix' => 'nullable|string|max:255',
        ]);

        Conta::create($validatedData);

        return redirect()->route('contas.index', ['tenant' => request()->route('tenant')])->with('success', 'Conta cadastrada com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        $conta = Conta::findOrFail(request()->route('conta'));
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit()
    {
        $conta = Conta::findOrFail(request()->route('conta'));
        $motoristas = Motorista::all();
        return view('contas.edit', compact('conta', 'motoristas'));
    }

    public function update(Request $request)
    {
        $conta = Conta::findOrFail(request()->route('conta'));
        $validatedData = $request->validate([
            'motorista_id' => 'required|exists:motoristas,id',
            'titular' => 'required|string|max:255',
            'cpf_cnpj_titular' => 'required|string|max:20',
            'banco' => 'required|string|max:100',
            'agencia' => 'required|string|max:20',
            'tipo_conta' => 'required|string|max:50',
            'nro_conta' => 'required|string|max:50',
            'tipo_chave' => 'nullable|string|max:50',
            'chave_pix' => 'nullable|string|max:255',
        ]);

        $conta->update($validatedData);

        return redirect()->route('contas.index', ['tenant' => request()->route('tenant')])->with('success', 'Conta atualizada com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy()
    {
        $conta = Conta::findOrFail(request()->route('conta'));
        $conta->delete();
        return redirect()->route('contas.index', ['tenant' => request()->route('tenant')])->with('success', 'Conta excluída com sucesso!');
    }
}
