<?php

namespace App\Http\Controllers;

use App\Models\Projeto;
use App\Models\Membro;
use App\Models\Tarefa;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class TarefaController extends Controller
{
    public function index($projetoId): View
    {
        $projeto = Projeto::findOrFail($projetoId);
        $tarefas = $projeto->tarefas()->paginate(10);
        return view('tarefas.index', compact('projeto', 'tarefas'));
    }
    public function create(Projeto $projeto): View
    {
        $membros = Membro::all();
        return view('tarefas.create', compact('projeto', 'membros'));
    }

    public function store(Request $request, Projeto $projeto): RedirectResponse
    {
        $request->validate([
            'nome' => 'required|min:3|max:255',
            'membro_id' => 'required|exists:membros,id',
        ]);
    
        try {
            $tarefa = $projeto->tarefas()->create([
                'nome' => $request->input('nome'),
                'status' => $request->has('status') ? 'concluido' : 'em aberto',
                'membro_id' => $request->input('membro_id'),
                'certificado_gerado' => false,
            ]);
    
            return redirect()->route('projetos.tarefas.index', $projeto->id)
                ->with('success', 'Tarefa criada com sucesso.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erro ao criar a tarefa: ' . $e->getMessage());
        }
    }

    public function edit(Projeto $projeto, Tarefa $tarefa): View
    {
        $membros = Membro::all();
        return view('tarefas.edit', compact('projeto', 'tarefa', 'membros'));
    }

    public function update(Request $request, Projeto $projeto, Tarefa $tarefa): RedirectResponse
{
    $request->validate([
        'nome' => 'required|min:3|max:255',
        'membro_id' => 'required|exists:membros,id',
    ]);

    try {
        $tarefa->update([
            'nome' => $request->input('nome'),
            'status' => $request->has('status') ? 'concluido' : 'em aberto',
            'membro_id' => $request->input('membro_id'),
        ]);

        return redirect()->route('projetos.tarefas.index', $projeto->id)
            ->with('success', 'Tarefa atualizada com sucesso.');
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Erro ao atualizar a tarefa: ' . $e->getMessage());
    }
}

    public function destroy(Projeto $projeto, Tarefa $tarefa): RedirectResponse
    {
        try {
            $tarefa->delete();

            return redirect()->route('tarefas.index', $projeto->id)
                ->with('success', 'Tarefa deletada com sucesso.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erro ao deletar a tarefa: ' . $e->getMessage());
        }
    }

    public function updateCheckbox(Request $request, Tarefa $tarefa)
    {
        $tarefa->checkbox_estado = $request->input('checkbox_estado');
        $tarefa->save();
    
        return response()->json(['success' => true]);
    }
}