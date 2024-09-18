<?php

namespace App\Http\Controllers;

use App\Models\Membro;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\File;

class MembroController extends Controller
{
    public function index(Request $request): View
    {
        $membros = Membro::latest()->paginate(5);

        if ($request->ajax()) {
            return view('membros.table', compact('membros'));
        }
        
        return view('membros.index',compact('membros'));
    }

    public function about(): View
    {
        $membros = Membro::where('ativo', true)->get();
        
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
            'cpf' => 'required|unique:membros,cpf',
            'biografia' => 'required|min:10',
            'linkedin' => 'nullable|url',
            'github' => 'nullable|url',
            'alt' => 'required|min:5|max:255',
            'imagem' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
    
        $entrada = $request->all();
        $entrada['ativo'] = $request->has('ativo') ? $request->ativo : false;
    
        if ($request->has('cropped_image')) {
            $folderPath = public_path('imagens/');
            $image_parts = explode(";base64,", $request->cropped_image);
            $image_type_aux = explode("image/", $image_parts[0]);
            $image_type = $image_type_aux[1];
            $image_base64 = base64_decode($image_parts[1]);
            $imageName = uniqid() . '.png';
            $imageFullPath = $folderPath . $imageName;
            file_put_contents($imageFullPath, $image_base64);
            $entrada['imagem'] = $imageName;
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
            'cpf' => 'required|unique:membros,cpf,' . $membro->id,
            'biografia' => 'required|min:10',
            'linkedin' => 'nullable|url',
            'github' => 'nullable|url',
            'alt' => 'required|min:5|max:255',
            'imagem' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ], [
            'cpf.unique' => 'CPF já cadastrado.',
            'cpf.required' => 'O campo CPF é obrigatório.',
            'nome.required' => 'O campo nome é obrigatório.',
            'nome.min' => 'O campo nome deve ter no mínimo 3 caracteres.',
            'nome.max' => 'O campo nome deve ter no máximo 255 caracteres.',
            'cargo.required' => 'O campo cargo é obrigatório.',
            'cargo.max' => 'O campo cargo deve ter no máximo 100 caracteres.',
            'biografia.required' => 'O campo biografia é obrigatório.',
            'biografia.min' => 'O campo biografia deve ter no mínimo 10 caracteres.',
            'linkedin.url' => 'O campo linkedin deve ser uma URL válida.',
            'github.url' => 'O campo github deve ser uma URL válida.',
            'alt.required' => 'O campo alt é obrigatório.',
            'alt.min' => 'O campo alt deve ter no mínimo 5 caracteres.',
            'alt.max' => 'O campo alt deve ter no máximo 255 caracteres.',
            'imagem.image' => 'O arquivo deve ser uma imagem.',
            'imagem.mimes' => 'O arquivo deve ser uma imagem do tipo: jpeg, png, jpg, gif, svg.',
            'imagem.max' => 'O arquivo deve ter no máximo 2048 KB.',
        ]);
    
        $entrada = $request->all();
        $entrada['ativo'] = $request->has('ativo') ? $request->ativo : false;
    
        if ($request->has('cropped_image') && $request->cropped_image) {
            // Remove a imagem antiga se existir
            if ($membro->imagem) {
                $oldImagePath = public_path('imagens/' . $membro->imagem);
                if (File::exists($oldImagePath)) {
                    File::delete($oldImagePath);
                }
            }
    
            // Salva a nova imagem
            $folderPath = public_path('imagens/');
            $image_parts = explode(";base64,", $request->cropped_image);
            $image_type_aux = explode("image/", $image_parts[0]);
            $image_type = $image_type_aux[1];
            $image_base64 = base64_decode($image_parts[1]);
            $imageName = uniqid() . '.png';
            $imageFullPath = $folderPath . $imageName;
            file_put_contents($imageFullPath, $image_base64);
            $entrada['imagem'] = $imageName;
        } else {
            // Mantém a imagem existente
            $entrada['imagem'] = $membro->imagem;
        }
    
        $membro->update($entrada);
    
        return redirect()->route("membros.index")
            ->with("success", "Membro atualizado com sucesso.");
    }
    

    public function destroy($id)
    {
        try {
            $membro = Membro::findOrFail($id);

            if ($membro->imagem) {
                $imagePath = public_path('imagens/' . $membro->imagem);
                if (File::exists($imagePath)) {
                    File::delete($imagePath);
                }
            }

            $membro->delete();

            $membros = Membro::paginate(5);

            if (request()->ajax()) {
                return response()->json([
                    'table' => view('membros.table', compact('membros'))->render()
                ]);
            }

            return redirect()->route('membros.index')->with('success', 'Membro excluído com sucesso.');
        } catch (\Exception $e) {
            \Log::error('Erro ao excluir membro: ' . $e->getMessage());
            return response()->json(['error' => 'Erro ao excluir o membro.'], 500);
        }
    }
}
