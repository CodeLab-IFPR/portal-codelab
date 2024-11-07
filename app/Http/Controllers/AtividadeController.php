<?php
// app/Http/Controllers/AtividadeController.php
namespace App\Http\Controllers;

use App\Models\Tarefa;
use App\Models\Atividade;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class AtividadeController extends Controller
{
    public function create(Tarefa $tarefa): View
    {
        $projeto = $tarefa->projeto;
        return view('tarefas.atividades.create', compact('tarefa', 'projeto'));
    }

    public function index(Tarefa $tarefa): View
{
    $projeto = $tarefa->projeto;
    return view('tarefas.atividades.index', compact('tarefa', 'projeto'));
}
public function store(Request $request, Tarefa $tarefa): RedirectResponse
{
    $request->validate([
        'data_inicio' => 'required|date',
        'data_final' => 'required|date|after_or_equal:data_inicio',
        'horas_trabalhadas' => 'required|integer|min:1',
        'link' => 'required|url',
    ],[
        'data_inicio.required' => 'O campo data de início é obrigatório.',
        'data_inicio.date' => 'O campo data de início deve ser uma data válida.',
        'data_final.required' => 'O campo data final é obrigatório.',
        'data_final.date' => 'O campo data final deve ser uma data válida.',
        'data_final.after_or_equal' => 'A data final deve ser maior ou igual a data de início.',
        'horas_trabalhadas.required' => 'O campo horas trabalhadas é obrigatório.',
        'horas_trabalhadas.integer' => 'O campo horas trabalhadas deve ser um número inteiro.',
        'horas_trabalhadas.min' => 'O campo horas trabalhadas deve ser no mínimo 1.',
        'link.required' => 'O campo link é obrigatório.',
        'link.url' => 'O campo link deve ser uma URL válida.',
    ]);

    $atividade = new Atividade($request->only('data_inicio', 'data_final', 'horas_trabalhadas', 'link'));
    $atividade->tarefa_id = $tarefa->id;
    $atividade->save();

    $tarefa->status = 'concluido';
    $tarefa->save();

    return redirect()->route('tarefas.atividades.index', $tarefa->id)
        ->with('success', 'Atividade criada com sucesso e a tarefa foi concluída.');
}

public function update(Request $request, Atividade $atividade): RedirectResponse
{
    $request->validate([
        'data_inicio' => 'required|date',
        'data_final' => 'required|date|after_or_equal:data_inicio',
        'horas_trabalhadas' => 'required|integer|min:1',
        'link' => 'required|url',
    ],[
        'data_inicio.required' => 'O campo data de início é obrigatório.',
        'data_inicio.date' => 'O campo data de início deve ser uma data válida.',
        'data_final.required' => 'O campo data final é obrigatório.',
        'data_final.date' => 'O campo data final deve ser uma data válida.',
        'data_final.after_or_equal' => 'A data final deve ser maior ou igual a data de início.',
        'horas_trabalhadas.required' => 'O campo horas trabalhadas é obrigatório.',
        'horas_trabalhadas.integer' => 'O campo horas trabalhadas deve ser um número inteiro.',
        'horas_trabalhadas.min' => 'O campo horas trabalhadas deve ser no mínimo 1.',
        'link.required' => 'O campo link é obrigatório.',
        'link.url' => 'O campo link deve ser uma URL válida.',
    ]);

    $atividade->update($request->only('data_inicio', 'data_final', 'horas_trabalhadas', 'link'));

    return redirect()->route('tarefas.atividades.index', $atividade->tarefa_id)
        ->with('success', 'Atividade atualizada com sucesso.');
}

    public function edit(Atividade $atividade): View
    {
        return view('tarefas.atividades.edit', compact('atividade'));
    }
    
    public function destroy(Atividade $atividade): RedirectResponse
{
    $tarefa = $atividade->tarefa;
    $atividade->delete();
    $tarefa->status = 'em aberto';
    $tarefa->save();
    return redirect()->route('tarefas.atividades.index', $tarefa->id)
        ->with('success', 'Atividade deletada e status atualizado');
}
}