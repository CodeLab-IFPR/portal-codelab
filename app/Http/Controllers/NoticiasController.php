<?php

namespace App\Http\Controllers;

use App\Models\Noticias;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class NoticiasController extends Controller
{
    public function index(): View
    {
        $noticias = Noticias::latest()->paginate(5);
        return view('noticias.index', compact('noticias'));
    }

    public function home(): View
{
    $noticias = Noticias::latest()->take(3)->get();
    return view('home', compact('noticias'));
}

    public function create(): View
    {
        return view('noticias.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'titulo' => 'required|min:5|max:255',
            'autor' => 'required|min:3|max:255',
            'conteudo' => 'required|min:15',
            'categoria' => 'required',
            'alt' => 'required',
            'imagem' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ],[
            'titulo.required' => 'O campo título é obrigatório.',
            'titulo.min' => 'O campo título deve ter no mínimo 5 caracteres.',
            'titulo.max' => 'O campo título deve ter no máximo 255 caracteres.',
            'autor.required' => 'O campo autor é obrigatório.',
            'autor.min' => 'O campo autor deve ter no mínimo 3 caracteres.',
            'autor.max' => 'O campo autor deve ter no máximo 255 caracteres.',
            'conteudo.required' => 'O campo conteúdo é obrigatório.',
            'conteudo.min' => 'O campo conteúdo deve ter no mínimo 15 caracteres.',
            'categoria.required' => 'O campo categoria é obrigatório.',
            'alt.required' => 'O campo alt é obrigatório.',
            'imagem.required' => 'O campo imagem é obrigatório.',
            'imagem.image' => 'O arquivo deve ser uma imagem.',
            'imagem.mimes' => 'A imagem deve ser um dos seguintes formatos: jpeg, png, jpg.',
            'imagem.max' => 'A imagem não pode ter mais que 2MB.',
        ]);

        $entrada = $request->all();
        $entrada['slug'] = Str::slug($request->input('titulo'));

        if ($imagem = $request->file('imagem')) {
            $destinationPath = 'imagens/';
            $profileImage = date('YmdHis') . "." . $imagem->getClientOriginalExtension();
            $imagem->move($destinationPath, $profileImage);
            $entrada['imagem'] = $profileImage;
        }

        Noticias::create($entrada);

        return redirect()->route("noticias.index")
            ->with("success", "Notícia criada com sucesso.");
    }
    public function show(string $slug): View
    {
        $noticia = Noticias::where('slug', $slug)->firstOrFail();
        return view("noticias.show", compact("noticia"));
    }
    public function edit(string $slug): View
    {
        $noticia = Noticias::where('slug', $slug)->firstOrFail();
        return view('noticias.edit', compact('noticia'));
    }

    public function update(Request $request, string $slug): RedirectResponse
    {
        Log::info('Método update chamado.');
        Log::info('Dados recebidos: ', $request->all());

        $request->validate([
            'titulo' => 'nullable|min:5|max:255',
            'autor' => 'nullable|min:3|max:255',
            'conteudo' => 'nullable|min:15',
            'categoria' => 'nullable|string|max:255',
            'alt' => 'nullable|string|max:255',
            'imagem' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ],[
            'titulo.max' => 'O campo título deve ter no máximo 255 caracteres.',
            'autor.min' => 'O campo autor deve ter no mínimo 3 caracteres.',
            'autor.max' => 'O campo autor deve ter no máximo 255 caracteres.',
            'conteudo.min' => 'O campo conteúdo deve ter no mínimo 15 caracteres.',
            'categoria.max' => 'O campo categoria deve ter no máximo 255 caracteres.',
            'alt.max' => 'O campo alt deve ter no máximo 255 caracteres.',
            'imagem.image' => 'O arquivo deve ser uma imagem.',
            'imagem.mimes' => 'A imagem deve ser um dos seguintes formatos: jpeg, png, jpg.',
            'imagem.max' => 'A imagem não pode ter mais que 2MB.',
        ]);

        Log::info('Validação concluída.');

        $entrada = $request->all();
        $entrada['slug'] = Str::slug($request->input('titulo'));

        $noticia = Noticias::where('slug', $slug)->firstOrFail();

        if ($imagem = $request->file('imagem')) {
            if ($noticia->imagem) {
                $oldImagePath = public_path('imagens/' . $noticia->imagem);
                if (File::exists($oldImagePath)) {
                    File::delete($oldImagePath);
                }
            }

            $destinationPath = 'imagens/';
            $profileImage = date('YmdHis') . "_" . $noticia->id . "." . $imagem->getClientOriginalExtension();
            $imagem->move($destinationPath, $profileImage);
            $entrada['imagem'] = $profileImage;
        } else {
            unset($entrada['imagem']);
        }

        Log::info('Dados para atualização: ', $entrada);

        try {
            $noticia->update($entrada);
            Log::info('Atualização concluída.');

            return redirect()->route('noticias.index')
                             ->with('success', 'Notícia atualizada com sucesso.');
        } catch (\Exception $e) {
            Log::error('Erro ao atualizar a notícia: ' . $e->getMessage());

            return redirect()->route('noticias.index')
                             ->with('error', 'Erro ao atualizar a notícia.');
        }
    }

    public function destroy(string $slug): RedirectResponse
    {
        $noticia = Noticias::where('slug', $slug)->firstOrFail();
        
        if ($noticia->imagem) {
            $imagePath = public_path('imagens/' . $noticia->imagem);
            if (File::exists($imagePath)) {
                File::delete($imagePath);
            }
        }

        return redirect()->route("noticias.index")
            ->with("success", "Notícia deletada com sucesso.");
    }
}
