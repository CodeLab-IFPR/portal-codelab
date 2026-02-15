<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FraseInicio;
use Illuminate\Support\Facades\File;

class FraseInicioController extends Controller
{
    public function editar()
    {
        $fraseInicio = FraseInicio::find(PARAM_FRASE_TELA_INICIAL);
        $fraseSobre = FraseInicio::find(PARAM_FRASE_SOBRE_NOS);
        $titulo_1 = FraseInicio::find(PARAM_TITULO_1);
        $titulo_2 = FraseInicio::find(PARAM_TITULO_2);
        $titulo_3 = FraseInicio::find(PARAM_TITULO_3);
        $nomeOrganizacao = FraseInicio::find(PARAM_NOME_ORGANIZACAO);
        $endereco = FraseInicio::find(PARAM_ENDERECO);
        $seoTitle = FraseInicio::find(PARAM_SEO_TITLE);
        $seoDescricao = FraseInicio::find(PARAM_SEO_DESCRICAO);
        $seoAuthor = FraseInicio::find(PARAM_SEO_AUTHOR);
        $seoKeywords = FraseInicio::find(PARAM_SEO_KEYWORDS);
        $nosEncontreOnline = FraseInicio::find(PARAM_NOS_ENCONTRE_ONLINE);
        $iconLogo = FraseInicio::find(PARAM_ICON_LOGO);
        $fullLogo = FraseInicio::find(PARAM_FULL_LOGO);
        return view('admin.frase_inicio.editar', compact('fraseInicio', 'fraseSobre', 'titulo_1', 'titulo_2', 'titulo_3', 'nomeOrganizacao', 'endereco', 'seoTitle', 'seoDescricao', 'seoAuthor', 'seoKeywords', 'nosEncontreOnline', 'iconLogo', 'fullLogo'));
    }

    public function atualizar(Request $request)
    {
        $request->validate([
            'frase_inicio' => 'required|string',
            'frase_sobre' => 'required|string',
            'titulo_1' => 'nullable|string',
            'titulo_2' => 'nullable|string',
            'titulo_3' => 'nullable|string',
            'nome_organizacao' => 'required|string',
            'endereco' => 'required|string',
            'seo_title' => 'nullable|string',
            'seo_descricao' => 'nullable|string',
            'seo_author' => 'nullable|string',
            'seo_keywords' => 'nullable|string',
            'nos_encontre_online' => 'nullable|string',
            'icon_logo' => 'required|image|mimes:jpeg,png,jpg',
        ]);

        if ($request->hasFile('icon_logo')) {
            $iconLogoRecord = FraseInicio::find(PARAM_ICON_LOGO);
            
            if ($iconLogoRecord && $iconLogoRecord->frase) {
                $oldPath = public_path($iconLogoRecord->frase);
                if (File::exists($oldPath)) {
                    File::delete($oldPath);
                }
            }
            
            $iconFile = $request->file('icon_logo');
            $iconFileName = 'icon-logo.' . $iconFile->getClientOriginalExtension();
            $iconFile->move(public_path('imagens/logos'), $iconFileName);
            $iconPath = 'imagens/logos/' . $iconFileName;
            
            if ($iconLogoRecord) {
                $iconLogoRecord->update(['frase' => $iconPath]);
            } else {
                FraseInicio::create([
                    'id' => PARAM_ICON_LOGO,
                    'frase' => $iconPath
                ]);
            }
        }

        $fraseInicio = FraseInicio::find(PARAM_FRASE_TELA_INICIAL);
        if ($fraseInicio) {
            $fraseInicio->update(['frase' => $request->input('frase_inicio')]);
        } else {
            FraseInicio::create([
                'id' => PARAM_FRASE_TELA_INICIAL,
                'frase' => $request->input('frase_inicio')
            ]);
        }

        $fraseSobre = FraseInicio::find(PARAM_FRASE_SOBRE_NOS);
        if ($fraseSobre) {
            $fraseSobre->update(['frase' => $request->input('frase_sobre')]);
        } else {
            FraseInicio::create([
                'id' => PARAM_FRASE_SOBRE_NOS,
                'frase' => $request->input('frase_sobre')
            ]);
        }

        $titulo_1 = FraseInicio::find(PARAM_TITULO_1);
        if ($titulo_1) {
            $titulo_1->update(['frase' => $request->input('titulo_1') ?? '']);
        } else {
            FraseInicio::create([
                'id' => PARAM_TITULO_1,
                'frase' => $request->input('titulo_1') ?? ''
            ]);
        }

        $titulo_2 = FraseInicio::find(PARAM_TITULO_2);
        if ($titulo_2) {
            $titulo_2->update(['frase' => $request->input('titulo_2') ?? '']);
        } else {
            FraseInicio::create([
                'id' => PARAM_TITULO_2,
                'frase' => $request->input('titulo_2') ?? ''
            ]);
        }

        $titulo_3 = FraseInicio::find(PARAM_TITULO_3);
        if ($titulo_3) {
            $titulo_3->update(['frase' => $request->input('titulo_3') ?? '']);
        } else {
            FraseInicio::create([
                'id' => PARAM_TITULO_3,
                'frase' => $request->input('titulo_3') ?? ''
            ]);
        }

        $nomeOrganizacao = FraseInicio::find(PARAM_NOME_ORGANIZACAO);
        if ($nomeOrganizacao) {
            $nomeOrganizacao->update(['frase' => $request->input('nome_organizacao')]);
        } else {
            FraseInicio::create([
                'id' => PARAM_NOME_ORGANIZACAO,
                'frase' => $request->input('nome_organizacao')
            ]);
        }


        $endereco = FraseInicio::find(PARAM_ENDERECO);
        if ($endereco) {
            $endereco->update(['frase' => $request->input('endereco')]);
        } else {
            FraseInicio::create([
                'id' => PARAM_ENDERECO,
                'frase' => $request->input('endereco')
            ]);
        }

        $seoDescricao = FraseInicio::find(PARAM_SEO_DESCRICAO);
        if ($seoDescricao) {
            $seoDescricao->update(['frase' => $request->input('seo_descricao') ?? '']);
        } else {
            FraseInicio::create([
                'id' => PARAM_SEO_DESCRICAO,
                'frase' => $request->input('seo_descricao') ?? ''
            ]);
        }

        
        $seoTitle = FraseInicio::find(PARAM_SEO_TITLE);
        if ($seoTitle) {
            $seoTitle->update(['frase' => $request->input('seo_title') ?? ''] );
        } else {
            FraseInicio::create([
                'id' => PARAM_SEO_TITLE,
                'frase' => $request->input('seo_title')?? ''
            ]);
        }

        $seoAuthor = FraseInicio::find(PARAM_SEO_AUTHOR);
        if ($seoAuthor) {
            $seoAuthor->update(['frase' => $request->input('seo_author') ?? '']);
        } else {
            FraseInicio::create([
                'id' => PARAM_SEO_AUTHOR,
                'frase' => $request->input('seo_author') ?? ''
            ]);
        }

        $seoKeywords = FraseInicio::find(PARAM_SEO_KEYWORDS);
        if ($seoKeywords) {
            $seoKeywords->update(['frase' => $request->input('seo_keywords') ?? '']);
        } else {
            FraseInicio::create([
                'id' => PARAM_SEO_KEYWORDS,
                'frase' => $request->input('seo_keywords') ?? ''
            ]);
        }

        $nosEncontreOnline = FraseInicio::find(PARAM_NOS_ENCONTRE_ONLINE);
        if ($nosEncontreOnline) {
            $nosEncontreOnline->update(['frase' => $request->input('nos_encontre_online') ?? '']);
        } else {
            FraseInicio::create([
                'id' => PARAM_NOS_ENCONTRE_ONLINE,
                'frase' => $request->input('nos_encontre_online') ?? ''
            ]);
        }

        return redirect()->route('admin.frase_inicio.editar')->with('success', 'Frases atualizadas com sucesso!');
    }
}