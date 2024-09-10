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
            'nome' => 'required|min:3|max:255',
            'email' => 'required|email',
            'link' => 'required|url',
            'alt' => 'required|min:5|max:250',
            'imagem' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ],[
            'nome.required' => 'O nome é obrigatório.',
            'nome.min' => 'O nome deve ter no mínimo 3 caracteres.',
            'nome.max' => 'O nome deve ter no máximo 255 caracteres.',
            'email.required' => 'O email é obrigatório.',
            'email.email' => 'O email deve ser um endereço de email válido.',
            'email.min' => 'O email deve ter no mínimo 5 caracteres.',
            'email.max' => 'O email deve ter no máximo 250 caracteres.',
            'link.required' => 'O link é obrigatório.',
            'link.url' => 'O link deve ser uma URL válida.',
            'alt.required' => 'O alt é obrigatório.',
            'alt.min' => 'O alt deve ter no mínimo 5 caracteres.',
            'alt.max' => 'O alt deve ter no máximo 250 caracteres.',
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
            'nome' => 'required|min:3|max:255',
            'email' => 'required|email',
            'link' => 'nullable|url',
            'alt' => 'nullable|min:5|max:250',
            'imagem' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ],[
            'nome.required' => 'O nome é obrigatório.',
            'nome.min' => 'O nome deve ter no mínimo 3 caracteres.',
            'nome.max' => 'O nome deve ter no máximo 255 caracteres.',
            'email.required' => 'O email é obrigatório.',
            'email.email' => 'O email deve ser um endereço de email válido.',
            'link.url' => 'O link deve ser uma URL válida.',
            'alt.min' => 'O alt deve ter no mínimo 5 caracteres.',
            'alt.max' => 'O alt deve ter no máximo 250 caracteres.',
            'imagem.image' => 'O arquivo deve ser uma imagem.',
            'imagem.mimes' => 'A imagem deve ser um dos seguintes formatos: jpeg, png, jpg, gif, svg.',
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
