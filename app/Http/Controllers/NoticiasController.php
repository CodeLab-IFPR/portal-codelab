<?php

namespace App\Http\Controllers;

use App\Models\Noticias;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

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
            'titulo' => 'required|max:255',
            'autor' => 'required',
            'conteudo' => 'required',
            'categoria' => 'required',
            'alt' => 'required',
            'imagem' => 'required|image|mimes:jpeg,png,jpg|max:2048',
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
            'titulo' => 'nullable|max:255',
            'autor' => 'nullable',
            'conteudo' => 'nullable',
            'categoria' => 'nullable|string|max:255',
            'alt' => 'nullable|string|max:255',
            'imagem' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        Log::info('Validação concluída.');

        $entrada = $request->all();
        $entrada['slug'] = Str::slug($request->input('titulo'));

        if ($imagem = $request->file('imagem')) {
            Log::info('Imagem recebida.');
            $destinationPath = 'imagens/';
            $profileImage = date('YmdHis') . "." . $imagem->getClientOriginalExtension();
            $imagem->move($destinationPath, $profileImage);
            $entrada['imagem'] = $profileImage;
        } else {
            unset($entrada['imagem']);
        }

        Log::info('Dados para atualização: ', $entrada);

        try {
            $noticia = Noticias::where('slug', $slug)->firstOrFail();
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
        $noticia->delete();

        return redirect()->route("noticias.index")
            ->with("success", "Notícia deletada com sucesso.");
    }
}
