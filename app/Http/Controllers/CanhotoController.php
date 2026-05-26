<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Carga;

class CanhotoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Listamos as cargas que já foram descarregadas (onde data_hora_descarga não é nulo)
        // ou que possuem CTE emitido, pois o canhoto é o comprovante do CTE.
        $canhotos = Carga::with(['motorista', 'veiculo'])
            ->whereNotNull('data_hora_descarga')
            ->orderBy('data_hora_descarga', 'desc')
            ->paginate(10);

        return view('canhotos.index', compact('canhotos'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit()
    {
        $canhoto = Carga::findOrFail(request()->route('canhoto'));
        return view('canhotos.edit', compact('canhoto'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $request->validate([
            'status_canhoto' => 'required|in:Pendente,Entregue',
        ]);

        $carga = Carga::findOrFail(request()->route('canhoto'));
        $carga->update([
            'status_canhoto' => $request->status_canhoto,
        ]);

        return redirect()->route('canhotos.index', ['tenant' => request()->route('tenant')])->with('success', 'Status do canhoto atualizado com sucesso.');
    }
}
