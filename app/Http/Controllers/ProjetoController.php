<?php
// app/Http/Controllers/ProjetoController.php
namespace App\Http\Controllers;

use App\Models\Membro;
use App\Models\Projeto;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class ProjetoController extends Controller
{
    public function createTarefa($id)
{
    $projeto = Projeto::findOrFail($id);
    $membros = Membro::all();
    return view('tarefas.create', compact('projeto', 'membros'));
}

public function indexTarefas($id)
{
    $projeto = Projeto::findOrFail($id);
    return view('tarefas.index', compact('projeto'));
}

    public function index(): View
    {
        $projetos = Projeto::with('membros')->paginate(10);
        return view('projetos.index', compact('projetos'));
    }

    public function create(): View
    {
        $membros = Membro::all();
        return view('projetos.create', compact('membros'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'nome' => 'required|min:3|max:255',
            'descricao' => 'required|min:5',
            'membros' => 'required|array',
        ],[
            'nome.required' => 'O campo nome é obrigatório.',
            'nome.min' => 'O campo nome deve ter no mínimo 3 caracteres.',
            'nome.max' => 'O campo nome deve ter no máximo 255 caracteres.',
            'descricao.required' => 'O campo descrição é obrigatório.',
            'descricao.min' => 'O campo descrição deve ter no mínimo 5 caracteres.',
            'membros.array' => 'Selecione pelo menos um membro.',
            'membros.required' => 'Selecione pelo menos um membro.',
        ]);

        $status = $request->has('status') ? 'concluido' : 'em aberto';

        $projeto = Projeto::create([
            'nome' => $request->input('nome'),
            'descricao' => $request->input('descricao'),
            'status' => $status,
        ]);

        $projeto->membros()->sync($request->input('membros'));

        return redirect()->route('projetos.index')
            ->with('success', 'Projeto criado com sucesso.');
    }
    
    public function show(Projeto $projeto): View
    {
        $projeto->load('tarefas', 'membros');
        $membros = Membro::all();
        return view('projetos.show', compact('projeto', 'membros'));
    }
    
    public function edit(Projeto $projeto): View
    {
        $membros = Membro::all();
        return view('projetos.edit', compact('projeto', 'membros'));
    }

    public function update(Request $request, Projeto $projeto): RedirectResponse
    {
        $request->validate([
            'nome' => 'required|min:3|max:255',
            'descricao' => 'required|min:5',
            'membros' => 'required|array',
        ],[
            'nome.required' => 'O campo nome é obrigatório.',
            'nome.min' => 'O campo nome deve ter no mínimo 3 caracteres.',
            'nome.max' => 'O campo nome deve ter no máximo 255 caracteres.',
            'descricao.required' => 'O campo descrição é obrigatório.',
            'descricao.min' => 'O campo descrição deve ter no mínimo 5 caracteres.',
            'membros.array' => 'Selecione pelo menos um membro.',
            'membros.required' => 'Selecione pelo menos um membro.',
        ]);

        $status = $request->has('status') ? 'concluido' : 'em aberto';

        $projeto->update([
            'nome' => $request->input('nome'),
            'descricao' => $request->input('descricao'),
            'status' => $status,
        ]);

        $projeto->membros()->sync($request->input('membros'));

        return redirect()->route('projetos.index')
            ->with('success', 'Projeto atualizado com sucesso.');
    }

    public function destroy(Projeto $projeto): RedirectResponse
    {
        $projeto->delete();
        return redirect()->route('projetos.index')
            ->with('success', 'Projeto deletado.');
    }
}