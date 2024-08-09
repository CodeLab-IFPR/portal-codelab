<?php

namespace App\Http\Controllers;

use App\Models\Membro;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
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
            'nome' => 'required',
            'cargo' => 'required',
            'biografia' => 'required',
            'alt' => 'required',
            'imagem' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
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
            'imagem' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
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
