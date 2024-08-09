<?php

namespace App\Http\Controllers;

use App\Models\Parceiro;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;
use Illuminate\Support\Facades\Log; // Importar a classe Log

class ParceiroController extends Controller
{
    public function index(): View
    {
        $parceiros = Parceiro::latest()->paginate(5);
        
        return view('parceiros.index',compact('parceiros'));
    }

    public function create(): View
    {
        return view('parceiros.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'nome' => 'required',
            'email' => 'required',
            'link' => 'required',
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

        Parceiro::create($entrada);

        return redirect()->route("parceiros.index")
            ->with("success", "Parceiro criado com sucesso.");
    }

    public function show(Parceiro $parceiro): View
    {
        return view("parceiros.show", compact("parceiro"));
    }

    public function edit(Parceiro $parceiro): View
    {
        return view("parceiros.edit", compact("parceiro"));
    }

    public function update(Request $request, Parceiro $parceiro): RedirectResponse
{
    Log::info('Método update chamado.');

    try {
        Log::info('Dados recebidos: ', $request->all()); // Verifica os dados recebidos

        $request->validate([
            'nome' => 'required',
            'email' => 'required',
            'link' => 'nullable',
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
            $parceiro->update($entrada);
            Log::info('Atualização concluída.');
        } catch (\Exception $e) {
            Log::error('Erro ao atualizar parceiro: ' . $e->getMessage());

            return redirect()->route('parceiros.index')
                             ->with('error', 'Erro ao atualizar parceiro.');
        }

        return redirect()->route('parceiros.index')
                         ->with('success', 'Parceiro atualizado.');

    } catch (\Illuminate\Validation\ValidationException $e) {
        Log::error('Erro na validação: ' . $e->getMessage());
        Log::error('Erros de validação: ', $e->errors());

        return redirect()->route('parceiros.index')
                         ->withErrors($e->errors())
                         ->withInput();
    } catch (\Exception $e) {
        Log::error('Erro inesperado: ' . $e->getMessage());

        return redirect()->route('parceiros.index')
                         ->with('error', 'Erro inesperado ao atualizar o parceiro.');
        }
}

    

    public function destroy(Parceiro $parceiro): RedirectResponse
    {
        $parceiro->delete();

        return redirect()->route('parceiros.index')
                         ->with('success', 'Parceiro deletado.');
    }
}
