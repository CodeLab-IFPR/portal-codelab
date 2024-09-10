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
        ]);

        $entrada = $request->all();

        if ($imagem = $request->file('imagem')) {
            // Remove a imagem antiga se existir
            if ($membro->imagem) {
                $oldImagePath = public_path('imagens/' . $membro->imagem);
                if (File::exists($oldImagePath)) {
                    File::delete($oldImagePath);
                }
            }

            // Salva a nova imagem
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
        // Remove a imagem associada ao membro se existir
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
