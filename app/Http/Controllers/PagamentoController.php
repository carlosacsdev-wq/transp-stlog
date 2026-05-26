<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Carga;

class PagamentoController extends Controller
{
    public function index()
    {
        // Pega as cargas que possuem CTE (ou seja, estão prontas para pagamento)
        $pagamentos = Carga::with(['motorista', 'veiculo'])
            ->whereNotNull('cte')
            ->where('cte', '!=', '')
            ->paginate(10);

        return view('pagamentos.index', compact('pagamentos'));
    }

    public function edit()
    {
        $pagamento = Carga::with(['motorista', 'veiculo'])->findOrFail(request()->route('pagamento'));
        return view('pagamentos.edit', compact('pagamento'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'data_pagamento' => 'required|date',
            'valor_adiantamento' => 'nullable|numeric',
            'valor_saldo' => 'nullable|numeric',
            'tipo_solicitacao' => 'required|string|in:Adiantamento,Saldo,Ambos,Pago',
        ]);

        $pagamento = Carga::findOrFail(request()->route('pagamento'));

        // Regra de negócio: Saldo só pode ser solicitado se o canhoto estiver entregue
        if (in_array($request->tipo_solicitacao, ['Saldo', 'Ambos']) && $pagamento->status_canhoto != 'Entregue') {
            return redirect()->back()
                ->withInput()
                ->withErrors(['tipo_solicitacao' => 'O pagamento do Saldo não pode ser solicitado sem que o canhoto esteja marcado como Entregue.']);
        }

        $status = 'Solicitado (' . $request->tipo_solicitacao . ')';
        if ($request->tipo_solicitacao == 'Pago') {
            $status = 'Finalizado';
        }

        $pagamento->update([
            'data_pagamento' => $request->data_pagamento,
            'valor_adiantamento' => $request->valor_adiantamento,
            'valor_saldo' => $request->valor_saldo,
            'tipo_solicitacao' => $request->tipo_solicitacao,
            'status_pagamento' => $status,
        ]);

        return redirect()->route('pagamentos.index', ['tenant' => request()->route('tenant')])->with('success', 'Status de pagamento atualizado com sucesso.');
    }

    public function show()
    {
        $pagamento = Carga::with(['motorista.contas', 'veiculo'])->findOrFail(request()->route('pagamento'));
        return view('pagamentos.show', compact('pagamento'));
    }
}
