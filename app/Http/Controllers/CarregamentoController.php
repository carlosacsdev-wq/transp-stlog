<?php

namespace App\Http\Controllers;

use App\Models\Carga;
use Illuminate\Http\Request;

class CarregamentoController extends Controller
{
    public function index(Request $request)
    {
        $query = Carga::with(['motorista.veiculos', 'veiculo'])
            ->where('status', 'Comprometida')
            ->where(function ($q) {
                $q->whereNull('cte')->orWhere('cte', '');
            });

        if ($request->filled('fabrica')) {
            $query->where('fabrica', $request->fabrica);
        }

        $cargas = $query->paginate(10);

        return view('carregamentos.index', compact('cargas'));
    }

    public function edit()
    {
        $carregamento = Carga::findOrFail(request()->route('carregamento'));
        return view('carregamentos.edit', compact('carregamento'));
    }

    public function update(Request $request)
    {
        $carregamento = Carga::findOrFail(request()->route('carregamento'));
        $request->validate([
            'cte' => 'nullable|string|max:255',
            'mdfe' => 'nullable|string|max:255',
            'data_carregamento' => 'nullable|date',
        ]);

        $carregamento->update($request->only(['cte', 'mdfe', 'data_carregamento']));

        return redirect()->route('carregamentos.index', ['tenant' => request()->route('tenant')])->with('success', 'Documentos salvos com sucesso.');
    }

    public function coleta()
    {
        $carregamento = Carga::findOrFail(request()->route('carregamento'));
        $carregamento->load(['motorista.veiculos', 'veiculo']);
        return view('carregamentos.coleta', ['carga' => $carregamento]);
    }
}
