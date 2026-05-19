<?php

namespace App\Http\Controllers;

use App\Models\Carga;
use Illuminate\Http\Request;

class CarregamentoController extends Controller
{
    public function index(Request $request)
    {
        $query = Carga::with(['motorista', 'veiculo'])
            ->where('status', 'Comprometida');

        if ($request->filled('fabrica')) {
            $query->where('fabrica', $request->fabrica);
        }

        $cargas = $query->paginate(10);

        return view('carregamentos.index', compact('cargas'));
    }

    public function edit(Carga $carregamento) // Parameter named carregamento due to route resource naming
    {
        return view('carregamentos.edit', compact('carregamento'));
    }

    public function update(Request $request, Carga $carregamento)
    {
        $request->validate([
            'cte' => 'nullable|string|max:255',
            'mdfe' => 'nullable|string|max:255',
            'data_carregamento' => 'nullable|date',
        ]);

        $carregamento->update($request->only(['cte', 'mdfe', 'data_carregamento']));

        return redirect()->route('carregamentos.index')->with('success', 'Documentos salvos com sucesso.');
    }

    public function coleta(Carga $carregamento)
    {
        $carregamento->load(['motorista', 'veiculo']);
        return view('carregamentos.coleta', ['carga' => $carregamento]);
    }
}
