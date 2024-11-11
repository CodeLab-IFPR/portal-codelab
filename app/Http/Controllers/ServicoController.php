<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Servico;

class ServicoController extends Controller
{
    public function index()
    {
        $servicos = Servico::all();
        $servicos = Servico::paginate(10);
        return view('servicos.index', compact('servicos'));
    }

    public function create()
    {
        return view('servicos.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'descricao' => 'required|max:255',
        ],[
            'descricao.required' => 'O campo descrição é obrigatório.',
            'descricao.max' => 'O campo descrição deve ter no máximo 255 caracteres.',
        ]);

        Servico::create($request->all());

        return redirect()->route('servicos.index')
                         ->with('success', 'Serviço criado com sucesso.');
    }

    public function show(Servico $servico)
    {
        return view('servicos.show', compact('servico'));
    }

    public function edit(Servico $servico)
    {
        return view('servicos.edit', compact('servico'));
    }

    public function update(Request $request, Servico $servico)
    {
        $request->validate([
            'descricao' => 'required|max:255',
        ],[
            'descricao.required' => 'O campo descrição é obrigatório.',
            'descricao.max' => 'O campo descrição deve ter no máximo 255 caracteres.',
        ]);

        $servico->update($request->all());

        return redirect()->route('servicos.index')
                         ->with('success', 'Serviço atualizado com sucesso.');
    }

    public function destroy(Servico $servico)
    {
        $servico->delete();

        return redirect()->route('servicos.index')
                         ->with('success', 'Serviço deletado com sucesso.');
    }
}