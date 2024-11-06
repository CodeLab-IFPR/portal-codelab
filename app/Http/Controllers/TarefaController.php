<?php
// app/Http/Controllers/TarefaController.php
namespace App\Http\Controllers;

use App\Models\Membro;
use App\Models\Projeto;
use App\Models\Tarefa;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class TarefaController extends Controller
{
    public function index($projetoId)
    {
        $projeto = Projeto::findOrFail($projetoId);
        return view('tarefas.index', compact('projeto'));
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
        ]);

        return redirect()->route('projetos.show', $projeto->id)
            ->with('success', 'Tarefa criada com sucesso.');
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Erro ao criar a tarefa: ' . $e->getMessage());
    }
}

    public function update(Request $request, Projeto $projeto, Tarefa $tarefa): RedirectResponse
    {
        $request->validate([
            'nome' => 'required|min:3|max:255',
            'membro_id' => 'required|exists:membros,id',
        ], [
            'nome.required' => 'O campo nome é obrigatório.',
            'nome.min' => 'O campo nome deve ter no mínimo 3 caracteres.',
            'nome.max' => 'O campo nome deve ter no máximo 255 caracteres.',
            'membro_id.required' => 'O campo membro é obrigatório.',
            'membro_id.exists' => 'O membro selecionado não existe.',
        ]);

        // Atualização da tarefa
        $tarefa->update([
            'nome' => $request->input('nome'),
            'status' => $request->has('status') ? 'concluido' : 'em aberto',
            'membro_id' => $request->input('membro_id'),
        ]);

        return redirect()->route('projetos.show', $projeto->id)
            ->with('success', 'Tarefa atualizada com sucesso.');
    }

    public function show(Projeto $projeto, Tarefa $tarefa): View
    {
        $tarefa->load('atividades');
        $membros = Membro::all();
        return view('tarefas.show', compact('projeto', 'tarefa', 'membros'));
    }

    public function edit(Projeto $projeto, Tarefa $tarefa): View
    {
        $membros = Membro::all();
        return view('tarefas.edit', compact('projeto', 'tarefa', 'membros'));
    }

    public function destroy(Projeto $projeto, Tarefa $tarefa): RedirectResponse
    {
        $tarefa->delete();
        return redirect()->route('projetos.show', $projeto->id)
            ->with('success', 'Tarefa deletada.');
    }
}
