<?php

namespace App\Http\Controllers;

use App\Models\Membro;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Log;

class MembroController extends Controller
{
    public function index(): View
    {
        $membros = Membro::latest()->paginate(5);
        
        return view('membros.index',compact('membros'));
    }

    public function create(): View
    {
        return view('membros.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'nome' => 'required|min:3|max:255',
            'cargo' => 'required|min:5|max:100',
            'biografia' => 'required|min:10',
            'alt' => 'required|min:5|max:255',
            'imagem' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ],[
            'nome.required' => 'O nome é obrigatório.',
            'nome.min' => 'O nome deve ter no mínimo 3 caracteres.',
            'nome.max' => 'O nome deve ter no máximo 255 caracteres.',
            'cargo.required' => 'O cargo é obrigatório.',
            'cargo.min' => 'O cargo deve ter no mínimo 5 caracteres.',
            'cargo.max' => 'O cargo deve ter no máximo 100 caracteres.',
            'biografia.required' => 'A biografia é obrigatória.',
            'biografia.min' => 'A biografia deve ter no mínimo 10 caracteres.',
            'alt.required' => 'O texto alternativo é obrigatório.',
            'alt.min' => 'O texto alternativo deve ter no mínimo 5 caracteres.',
            'alt.max' => 'O texto alternativo deve ter no máximo 255 caracteres.',
            'imagem.required' => 'A imagem é obrigatória.',
            'imagem.image' => 'O arquivo deve ser uma imagem.',
            'imagem.mimes' => 'A imagem deve ser um dos seguintes formatos: jpeg, png, jpg, gif.',
            'imagem.max' => 'A imagem não pode ter mais que 2MB.',
        ]);
        
        $entrada = $request->all();
        
        
        if ($imagem = $request->file('imagem')) {
            $destinationPath = 'imagens/';
            $profileImage = date('YmdHis') . "." . $imagem->getClientOriginalExtension();
            $imagem->move($destinationPath, $profileImage);
            $entrada['imagem'] = "$profileImage";
        }

        Membro::create($entrada);

        return redirect()->route("membros.index")
            ->with("success", "Membro criado com sucesso.");
    }

    public function show(Membro $membro): View
    {
        return view("membros.show", compact("membro"));
    }

    public function edit(Membro $membro): View
    {
        return view("membros.edit", compact("membro"));
    }

    public function update(Request $request, Membro $membro): RedirectResponse
{
    Log::info('Método update chamado.');

    try {
        Log::info('Dados recebidos: ', $request->all()); // Verifica os dados recebidos

        $request->validate([
            'nome' => 'required',
            'cargo' => 'required',
            'biografia' => 'required',
            'alt' => 'nullable',
            'imagem' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ],[
            'nome.required' => 'O nome é obrigatório.',
            'nome.min' => 'O nome deve ter no mínimo 3 caracteres.',
            'nome.max' => 'O nome deve ter no máximo 255 caracteres.',
            'cargo.required' => 'O cargo é obrigatório.',
            'cargo.min' => 'O cargo deve ter no mínimo 5 caracteres.',
            'cargo.max' => 'O cargo deve ter no máximo 100 caracteres.',
            'biografia.required' => 'A biografia é obrigatória.',
            'biografia.min' => 'A biografia deve ter no mínimo 10 caracteres.',
            'alt.min' => 'O texto alternativo deve ter no mínimo 5 caracteres.',
            'alt.max' => 'O texto alternativo deve ter no máximo 255 caracteres.',
            'imagem.image' => 'O arquivo deve ser uma imagem.',
            'imagem.mimes' => 'A imagem deve ser um dos seguintes formatos: jpeg, png, jpg, gif.',
            'imagem.max' => 'A imagem não pode ter mais que 2MB.',
        ]);

        Log::info('Validação concluída.');

        $entrada = $request->all();
        if ($imagem = $request->file('imagem')) {
            Log::info('Imagem recebida.');
            $destinationPath = 'imagens/';
            $profileImage = date('YmdHis') . "." . $imagem->getClientOriginalExtension();
            $imagem->move($destinationPath, $profileImage);
            $entrada['imagem'] = "$profileImage";
        } else {
            unset($entrada['imagem']);
        }

        Log::info('Dados para atualização: ', $entrada);

        try {
            $membro->update($entrada);
            Log::info('Atualização concluída.');
        } catch (\Exception $e) {
            Log::error('Erro ao atualizar membro: ' . $e->getMessage());

            return redirect()->route('membros.index')
                             ->with('error', 'Erro ao atualizar membro.');
        }

        return redirect()->route('membros.index')
                         ->with('success', 'Membro atualizado.');

    } catch (\Illuminate\Validation\ValidationException $e) {
        Log::error('Erro na validação: ' . $e->getMessage());
        Log::error('Erros de validação: ', $e->errors());

        return redirect()->route('membros.index')
                         ->withErrors($e->errors())
                         ->withInput();
    } catch (\Exception $e) {
        Log::error('Erro inesperado: ' . $e->getMessage());

        return redirect()->route('membros.index')
                         ->with('error', 'Erro inesperado ao atualizar membro.');
        }
}

    

    public function destroy(Membro $membro): RedirectResponse
    {
        $membro->delete();

        return redirect()->route('membros.index')
                         ->with('success', 'Membro deletado.');
    }
}
