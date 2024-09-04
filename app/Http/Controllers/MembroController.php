<?php

namespace App\Http\Controllers;

use App\Models\Membro;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;

class MembroController extends Controller
{
    public function index(): View
    {
        $membros = Membro::latest()->paginate(5);
        
        return view('membros.index',compact('membros'));
    }

    public function about(): View
    {
        $membros = Membro::all();
        
        return view('about', compact('membros'));
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
            'linkedin' => 'nullable|url',
            'github' => 'nullable|url',
            'alt' => 'required|min:5|max:255',
            'imagem' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ],[
            'nome.required' => 'O campo nome é obrigatório.',
            'nome.min' => 'O campo nome deve ter no mínimo 3 caracteres.',
            'nome.max' => 'O campo nome deve ter no máximo 255 caracteres.',
            'cargo.required' => 'O campo cargo é obrigatório.',
            'cargo.min' => 'O campo cargo deve ter no mínimo 5 caracteres.',
            'cargo.max' => 'O campo cargo deve ter no máximo 100 caracteres.',
            'biografia.required' => 'O campo biografia é obrigatório.',
            'biografia.min' => 'O campo biografia deve ter no mínimo 10 caracteres.',
            'linkedin.url' => 'O campo linkedin deve ser uma URL válida.',
            'github.url' => 'O campo github deve ser uma URL válida.',
            'alt.required' => 'O campo alt é obrigatório.',
            'alt.min' => 'O campo alt deve ter no mínimo 5 caracteres.',
            'alt.max' => 'O campo alt deve ter no máximo 255 caracteres.',
            'imagem.required' => 'O campo imagem é obrigatório.',
            'imagem.image' => 'O arquivo deve ser uma imagem.',
            'imagem.mimes' => 'O arquivo deve ser uma imagem do tipo: jpeg, png, jpg, gif.',
            'imagem.max' => 'O arquivo deve ter no máximo 2048 KB.',
        ]);
    
        $entrada = $request->all();
    
        if ($imagem = $request->file('imagem')) {
            $destinationPath = 'imagens/';
            $profileImage = date('YmdHis') . "." . $imagem->getClientOriginalExtension();
            $imagem->move($destinationPath, $profileImage);
            $entrada['imagem'] = $profileImage;
        }

        $membro = Membro::create($entrada);

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
        $request->validate([
            'nome' => 'required|min:3|max:255',
            'cargo' => 'required|min:5|max:100',
            'biografia' => 'required|min:10',
            'linkedin' => 'nullable|url',
            'github' => 'nullable|url',
            'alt' => 'required|min:5|max:255',
            'imagem' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ],[
            'nome.required' => 'O campo nome é obrigatório.',
            'nome.min' => 'O campo nome deve ter no mínimo 3 caracteres.',
            'nome.max' => 'O campo nome deve ter no máximo 255 caracteres.',
            'cargo.required' => 'O campo cargo é obrigatório.',
            'cargo.min' => 'O campo cargo deve ter no mínimo 5 caracteres.',
            'cargo.max' => 'O campo cargo deve ter no máximo 100 caracteres.',
            'biografia.required' => 'O campo biografia é obrigatório.',
            'biografia.min' => 'O campo biografia deve ter no mínimo 10 caracteres.',
            'linkedin.url' => 'O campo linkedin deve ser uma URL válida.',
            'github.url' => 'O campo github deve ser uma URL válida.',
            'alt.required' => 'O campo alt é obrigatório.',
            'alt.min' => 'O campo alt deve ter no mínimo 5 caracteres.',
            'alt.max' => 'O campo alt deve ter no máximo 255 caracteres.',
            'imagem.image' => 'O arquivo deve ser uma imagem.',
            'imagem.mimes' => 'O arquivo deve ser uma imagem do tipo: jpeg, png, jpg, gif.',
            'imagem.max' => 'O arquivo deve ter no máximo 2048 KB.',
        ]);

        $entrada = $request->all();

        if ($imagem = $request->file('imagem')) {
            if ($membro->imagem) {
                $oldImagePath = public_path('imagens/' . $membro->imagem);
                if (File::exists($oldImagePath)) {
                    File::delete($oldImagePath);
                }
            }

            $destinationPath = 'imagens/';
            $profileImage = date('YmdHis') . "_" . $membro->id . "." . $imagem->getClientOriginalExtension();
            $imagem->move($destinationPath, $profileImage);
            $entrada['imagem'] = $profileImage;
        }

        $membro->update($entrada);

        return redirect()->route("membros.index")
            ->with("success", "Membro atualizado com sucesso.");
    }

    public function destroy(Membro $membro): RedirectResponse
    {
        if ($membro->imagem) {
            $imagePath = public_path('imagens/' . $membro->imagem);
            if (File::exists($imagePath)) {
                File::delete($imagePath);
            }
        }

        $membro->delete();

        return redirect()->route('membros.index')
                         ->with('success', 'Membro deletado.');
    }
}
