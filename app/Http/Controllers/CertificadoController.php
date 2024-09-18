<?php

namespace App\Http\Controllers;

use App\Models\Certificado;
use App\Models\Membro;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use setasign\Fpdi\Fpdi;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Log;

class CertificadoController extends Controller
{
    public function emitir(): View
    {
        return view('certificados.emitir');
    }

    public function buscarCertificados(Request $request)
    {
        try {
            Log::info('Início da busca de certificados.', ['request' => $request->all()]);
    
            $request->validate([
                'cpf' => 'required|string|max:14'
            ]);
    
            $cpf = $request->input('cpf');
            Log::info('CPF recebido para busca:', ['cpf' => $cpf]);
    
            $membro = Membro::where('cpf', $cpf)->first();
            
            if ($membro) {
                $certificados = Certificado::where('membros_id', $membro->id)->get();
                Log::info('Certificados encontrados:', ['certificados' => $certificados]);
    
                return response()->json([
                    'certificados' => $certificados
                ]);
            } else {
                Log::info('Nenhum membro encontrado com o CPF:', ['cpf' => $cpf]);
    
                return response()->json([
                    'certificados' => []
                ]);
            }
        } catch (\Exception $e) {
            Log::error('Erro ao buscar certificados:', ['exception' => $e->getMessage()]);
            return response()->json(['error' => 'Erro ao buscar certificados.'], 500);
        }
    }

    public function showValidationForm(): View
    {
        return view('certificados.validar');
    }

    public function validarCertificado(Request $request): JsonResponse
    {
        Log::info('Início da validação do certificado.');

        try {
            $request->validate([
                'token' => 'required|string|max:10'
            ]);

            Log::info('Validação do token foi bem-sucedida.');

            $token = $request->input('token');
            Log::info('Token recebido: ' . $token);

            $certificado = Certificado::where('token', $token)->with('membro')->first();
            
            if ($certificado) {
                Log::info('Certificado encontrado: ' . $certificado->id);
                return response()->json(['certificado' => $certificado]);
            } else {
                Log::warning('Certificado não encontrado para o token: ' . $token);
                return response()->json(['error' => 'Certificado não encontrado.'], 404);
            }
        } catch (\Exception $e) {
            Log::error('Erro ao validar certificado: ' . $e->getMessage());
            return response()->json(['error' => 'Ocorreu um erro ao validar o certificado.'], 500);
        }
    }

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
        return view('certificados.edit', [
            'certificado' => $certificado,
            'membros' => $membros,
            'selectedMembroId' => $selectedMembro
        ]);
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
    $membro = $certificado->membro;
    if (!$membro) {
        Log::error('Membro associado ao certificado não encontrado.', ['certificado_id' => $certificado->id]);
        throw new \Exception("Membro associado ao certificado não encontrado.");
    }

    $name = $membro->nome;
    $cpf = $membro->cpf;
    $credential = $certificado->token;
    $description = $certificado->descricao;
    $hours = $certificado->horas;
    $date = (new \DateTime($certificado->data))->format('d/m/Y');
    $url = route('certificados.validar', ['token' => $credential]);
    $qrCode = QrCode::format('png')->size(500)->generate($url);
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
    $pathToTemplate = public_path('certificate/Certificate2.pdf');
    if (!file_exists($pathToTemplate)) {
        throw new \Exception("Template file not found: " . $pathToTemplate);
    }
    $pdf->setSourceFile($pathToTemplate);
    $template = $pdf->importPage(1);

    $size = $pdf->getTemplateSize($template);

    $pdf->AddPage($size['orientation'], [$size['width'], $size['height']]);
    $pdf->useTemplate($template, 0, 0, $size['width'], $size['height']);

    $pdf->AddFont('DejaVuSerifCondensed', '', 'AMAZI___.ttf', true);
    $pdf->AddFont('DejaVuSans', '', 'DejaVuSans.ttf', true);

    $pdf->SetFont('DejaVuSerifCondensed', '', 12);
    $pdf->SetFontSize(30);
    $pdf->SetXY(35, 110);
    $pdf->Write(0, $name);

    $pdf->SetFont('DejaVuSans');
    $pdf->SetFontSize(12);
    $pdf->SetXY(35, 120);
    $text = "O CDT certifica que $name, inscrito(a) no CPF $cpf $description, perfazendo um total de $hours horas de atividades.";
    $pdf->MultiCell(170, 8, $text);

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
            Log::error('Erro ao excluir certificado: ' . $e->getMessage());
            return response()->json(['error' => 'Erro ao excluir o certificado.'], 500);
        }
    }

    protected function deleteFileIfExists(string $filePath): void
    {
        if (file_exists($filePath)) {
            unlink($filePath);
        }
    }
}
