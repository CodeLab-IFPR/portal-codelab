<?php

namespace App\Http\Controllers;

use App\Models\Certificado;
use App\Models\Membro;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use setasign\Fpdi\Fpdi;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Contracts\View\View;

class CertificadoController extends Controller
{
    public function index(Request $request): View
{
    $certificadosQuery = Certificado::latest();

    if ($request->search) {
        $certificadosQuery->where(function (Builder $builder) use ($request) {
            $builder->where('descricao', 'like', "%{$request->search}%")
                ->orWhere('horas', 'like', "%{$request->search}%")
                ->orWhere('data', 'like', "%{$request->search}%")
                ->orWhereHas('membro', function (Builder $query) use ($request) {
                    $query->where('nome', 'like', "%{$request->search}%");
                })
                ->orWhere('token', 'like', "%{$request->search}%");
        });
    }

    $certificados = $certificadosQuery->paginate(5);

    if ($request->ajax()) {
        return view('certificados.table', compact('certificados'));
    }

    return view('certificados.index', compact('certificados')); 
}
    public function create(): View
    {
        $membros = Membro::all();
        return view('certificados.create', compact('membros'));
    }

    public function edit(Certificado $certificado): View
    {
        $membros = Membro::all();
        $selectedMembro = $certificado->membros_id;
        return view('certificados.edit', ['certificado' => $certificado, 'membros' => $membros,'selectedMembroId' => $selectedMembro, compact('certificado', 'membros')]);
    }

    public function update(Request $request, Certificado $certificado): RedirectResponse
    {
        $request->validate([
            'membros_id' => 'required',
            'descricao' => 'required|max:520',
            'horas' => 'required|integer',
            'data' => 'required|date',
        ],[
            'membros_id.required' => 'O campo membro é obrigatório',
            'descricao.required' => 'O campo descrição é obrigatório',
            'descricao.max' => 'O campo descrição deve ter no máximo 520 caracteres',
            'horas.required' => 'O campo horas é obrigatório',
            'horas.integer' => 'O campo horas deve ser um número inteiro',
            'data.required' => 'O campo data é obrigatório',
            'data.date' => 'O campo data deve ser uma data válida',
        ]);

        $certificado->update([
            'membros_id' => $request->membros_id,
            'descricao' => $request->descricao,
            'horas' => $request->horas,
            'data' => $request->data,
        ]);

        return redirect()->route("certificados.index")
            ->with("success", "Certificado atualizado com sucesso.");
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'membros_id' => 'required',
            'descricao' => 'required|max:520',
            'horas' => 'required|integer',
            'data' => 'required|date',
        ],[
            'membros_id.required' => 'O campo membro é obrigatório',
            'descricao.required' => 'O campo descrição é obrigatório',
            'descricao.max' => 'O campo descrição deve ter no máximo 520 caracteres',
            'horas.required' => 'O campo horas é obrigatório',
            'horas.integer' => 'O campo horas deve ser um número inteiro',
            'data.required' => 'O campo data é obrigatório',
            'data.date' => 'O campo data deve ser uma data válida',
        ]);

        $certificado = Certificado::create([
            'membros_id' => $request->membros_id,
            'token' => Str::random(10),
            'descricao' => $request->descricao,
            'horas' => $request->horas,
            'data' => $request->data,
        ]);

        return redirect()->route("certificados.index")
            ->with("success", "Certificado criado com sucesso.");
    }

    public function show(Certificado $certificado): View
    {
        return view('certificados.show', compact('certificado'));
    }

    public function generateCertificate(Certificado $certificado, $download = false)
    {
        $name = $certificado->membro->nome;
        $credential = $certificado->token;
        $description = $certificado->descricao;
        $hours = $certificado->horas;
        $date = (new \DateTime($certificado->data))->format('d/m/Y');
    
        $qrCode = QrCode::format('png')->size(500)->generate($credential);
        $qrCodeDir = public_path('qr');
        $qrCodePath = $qrCodeDir . '/' . $credential . '.png';
    
        if (!file_exists($qrCodeDir)) {
            mkdir($qrCodeDir, 0777, true);
        }
    
        file_put_contents($qrCodePath, $qrCode);
    
        $certificateDir = public_path('certificate');
        if (!file_exists($certificateDir)) {
            mkdir($certificateDir, 0777, true);
        }
    
        $pdf = new Fpdi();
        $pathToTemplate = $certificateDir . '/Certificate2.pdf';
        if (!file_exists($pathToTemplate)) {
            throw new \Exception("Template file not found: " . $pathToTemplate);
        }
        $pathToTemplate = public_path('certificate/Certificate2.pdf');
        $pdf->setSourceFile($pathToTemplate);
        $template = $pdf->importPage(1);
    
        $size = $pdf->getTemplateSize($template);
    
        $pdf->AddPage($size['orientation'], [$size['width'], $size['height']]);
        $pdf->useTemplate($template, 0, 0, $size['width'], $size['height']);


        $pdf->AddFont('DejaVuSerifCondensed', '', 'AMAZI___.ttf',true);
        $pdf->SetFont('DejaVuSerifCondensed', '', 12);
        $pdf->SetFontSize(30);
        $pdf->SetXY(35, 110);
        $pdf->Write(0, $name);

        $pdf->SetFont('Helvetica');
        $pdf->SetFontSize(12);
        $pdf->SetXY(35, 120);
        $pdf->MultiCell(170, 8, $description);
        
        $pdf->SetFont('Helvetica');
        $pdf->SetFontSize(12);
        $pdf->SetXY(145, 176.8);
        $pdf->Write(0, 'Horas: ' . $hours);
        
        $pdf->SetFont('Helvetica');
        $pdf->SetFontSize(12);
        $pdf->SetXY(241, 176.8);
        $pdf->Write(0, $credential);
    
        $pdf->Image($qrCodePath, 217, 133, 40, 40);


        $fileName = 'Certificate2_' . $credential . '.pdf';
        $filePath = $certificateDir . '/' . $fileName;
    
        $pdf->Output($filePath, 'F');
    
        if ($download) {
            return response()->download($filePath, $fileName, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'attachment; filename="' . $fileName . '"'
            ]);
        } else {
            return response()->file($filePath, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename="' . $fileName . '"'
            ]);
        }
    }

    public function viewCertificate(Certificado $certificado)
    {
        return $this->generateCertificate($certificado, false);
    }

    public function downloadCertificate(Certificado $certificado)
    {
        return $this->generateCertificate($certificado, true);
    }

    public function destroy($id)
    {
        try {
            $certificado = Certificado::findOrFail($id);
            $certificado->delete();

            $certificados = Certificado::paginate(5);

            if (request()->ajax()) {
                return response()->json([
                    'table' => view('certificados.table', compact('certificados'))->render()
                ]);
            }

            return redirect()->route('certificados.index')->with('success', 'Certificado excluído com sucesso.');
        } catch (\Exception $e) {
            \Log::error('Erro ao excluir certificado: ' . $e->getMessage());
            return response()->json(['error' => 'Erro ao excluir o certificado.'], 500);
        }
    }

/**
 *
 * @param string $filePath
 * @return void
 */
protected function deleteFileIfExists(string $filePath): void
{
    if (file_exists($filePath)) {
        unlink($filePath);
    }
}

}