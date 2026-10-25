<?php

namespace App\Http\Controllers;

use App\Models\Carga;
use Illuminate\Http\Request;

class DiariasController extends Controller
{
    public function index(Request $request)
    {
        $query = Carga::with(['motorista.veiculos', 'veiculo'])
            ->whereNotNull('cte')
            ->where('cte', '!=', '')
            ->where(function ($query) {
                $query->where('diarias', '>', 0)
                    ->orWhere(function ($query) {
                        $query->whereNull('diarias')
                            ->whereNotNull('data_hora_chegada')
                            ->whereRaw('COALESCE(data_hora_descarga, CURRENT_TIMESTAMP) > DATE_ADD(data_hora_chegada, INTERVAL 24 HOUR)');
                    });
            });

        if ($request->filled('fabrica')) {
            $query->where('fabrica', $request->fabrica);
        }

        $viagens = $query->paginate(10);

        return view('financeiro.diarias.index', compact('viagens'));
    }

    public function edit(string $tenant, int $viagem)
    {
        $viagem = Carga::with(['motorista.veiculos', 'veiculo'])->findOrFail($viagem);

        if ($viagem->diarias_aprovadas_em) {
            return redirect()
                ->route('financeiro.diarias.index', ['tenant' => $tenant])
                ->with('error', 'Diárias aprovadas não podem ser editadas.');
        }

        return view('financeiro.diarias.edit', compact('viagem'));
    }

    public function update(Request $request, string $tenant, int $viagem)
    {
        $dados = $request->validate([
            'diarias' => ['required', 'integer', 'min:0'],
        ]);

        $viagem = Carga::findOrFail($viagem);

        if ($viagem->diarias_aprovadas_em) {
            return redirect()
                ->route('financeiro.diarias.index', ['tenant' => $tenant])
                ->with('error', 'Diárias aprovadas não podem ser editadas.');
        }

        $viagem->update(['diarias' => $dados['diarias']]);

        return redirect()
            ->route('financeiro.diarias.index', ['tenant' => $tenant])
            ->with('success', 'Quantidade de diárias atualizada com sucesso.');
    }

    public function approve(string $tenant, int $viagem)
    {
        $viagem = Carga::findOrFail($viagem);

        if ($viagem->diarias_aprovadas_em) {
            return redirect()
                ->route('financeiro.diarias.index', ['tenant' => $tenant])
                ->with('error', 'Estas diárias já foram aprovadas.');
        }

        if (! $viagem->data_hora_chegada || $viagem->diarias < 1) {
            return redirect()
                ->route('financeiro.diarias.index', ['tenant' => $tenant])
                ->with('error', 'É necessário haver chegada registrada e pelo menos uma diária para aprovar.');
        }

        $viagem->diarias = $viagem->diarias;
        $viagem->diarias_aprovadas_em = now();
        $viagem->save();

        return redirect()
            ->route('financeiro.diarias.index', ['tenant' => $tenant])
            ->with('success', 'Diárias aprovadas para pagamento.');
    }

    public function pay(string $tenant, int $viagem)
    {
        $viagem = Carga::findOrFail($viagem);

        if (! $viagem->diarias_aprovadas_em) {
            return redirect()
                ->route('financeiro.diarias.index', ['tenant' => $tenant])
                ->with('error', 'Aprove as diárias antes de marcá-las como pagas.');
        }

        if ($viagem->diarias_status_pagamento === 'Pago') {
            return redirect()
                ->route('financeiro.diarias.index', ['tenant' => $tenant])
                ->with('error', 'Estas diárias já estão marcadas como pagas.');
        }

        $viagem->update(['diarias_status_pagamento' => 'Pago']);

        return redirect()
            ->route('financeiro.diarias.index', ['tenant' => $tenant])
            ->with('success', 'Diárias marcadas como pagas.');
    }
}
