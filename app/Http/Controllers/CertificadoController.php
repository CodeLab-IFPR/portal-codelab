<?php

namespace App\Http\Controllers;

use App\Models\Certificado;
use App\Models\Membro;
use App\Models\Tarefa;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use setasign\Fpdi\Fpdi;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class CertificadoController extends Controller
{
    public function generateFromTasks(Request $request): JsonResponse
    {
        $tasks = $request->input('tasks', []);
        $membros = [];
        $projetoNome = '';
    
        foreach ($tasks as $taskId) {
            $tarefa = Tarefa::find($taskId);
            if ($tarefa && !$tarefa->certificado_gerado) {
                $membroId = $tarefa->membro_id;
                if (!isset($membros[$membroId])) {
                    $membros[$membroId] = 0;
                }
                $membros[$membroId] += $tarefa->atividades->sum('horas_trabalhadas');
                $projetoNome = $tarefa->projeto->nome;
            }
        }
    
        $certificadosData = [];
        foreach ($membros as $membroId => $horas) {
            $certificadosData[] = [
                'membro_id' => $membroId,
                'horas' => $horas,
                'descricao' => $projetoNome
            ];
        }
    
        $generatedTaskIds = [];
        foreach ($certificadosData as $data) {
            $certificado = new Certificado();
            $certificado->membro_id = $data['membro_id'];
            $certificado->horas = $data['horas'];
            $certificado->descricao = $data['descricao'];
            $certificado->token = Str::random(10);
            $certificado->data = now();
            $certificado->save();
    
            $generatedTaskIds[] = $data['membro_id'];
        }
    
        Tarefa::whereIn('id', $tasks)->update(['certificado_gerado' => true]);
    
        return response()->json([
            'success' => true,
            'redirect' => route('certificados.create', ['data' => json_encode($certificadosData)]),
            'generatedTaskIds' => $generatedTaskIds
        ]);
    }
    public function emitir()
    {
        return view('certificados.emitir');
    }

    public function buscarCertificados(Request $request): JsonResponse
    {
        try {

            $request->validate([
                'cpf' => 'required|string|max:14'
            ]);

            $cpf = $request->input('cpf');

            $membro = Membro::where('cpf', $cpf)->first();
            
            if ($membro) {
                $certificados = Certificado::where('membro_id', $membro->id)->get();

                return response()->json([
                    'certificados' => $certificados
                ]);
            } else {

                return response()->json([
                    'certificados' => []
                ]);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro ao buscar certificados.'], 500);
        }
    }

    public function showValidationForm()
    {
        return view('certificados.validar');
    }

    public function validarCertificado(Request $request): JsonResponse
    {

        try {
            $request->validate([
                'token' => 'required|string|max:10'
            ]);

            $token = $request->input('token');

            $certificado = Certificado::where('token', $token)->with('membro')->first();
            
            if ($certificado) {
                return response()->json(['certificado' => $certificado]);
            } else {
                return response()->json(['error' => 'Certificado não encontrado.'], 404);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ocorreu um erro ao validar o certificado.'], 500);
        }
    }

    public function index(Request $request)
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
            return response()->json([
                'table' => view('certificados.table', compact('certificados'))->render()
            ]);
        }

        return view('certificados.index', compact('certificados'));
    }

    public function create(Request $request)
    {
        $certificadosData = json_decode($request->input('data'), true);
        $membros = Membro::all();
        return view('certificados.create', compact('membros', 'certificadosData'));
    }

    public function edit(Certificado $certificado)
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
        $certificados = $request->input('certificados', []);
        $manualCertificado = $request->input('manual_certificado', []);
        $descricao = $request->input('descricao');

        foreach ($certificados as $certificadoData) {
            $existingCertificado = Certificado::where('membro_id', $certificadoData['membros_id'])
                ->where('descricao', $descricao)
                ->first();

            if (!$existingCertificado) {
                $certificado = new Certificado();
                $certificado->membro_id = $certificadoData['membros_id'];
                $certificado->horas = $certificadoData['horas'];
                $certificado->descricao = $descricao;
                $certificado->token = Str::random(10);
                $certificado->data = now();
                $certificado->save();
            }
        }

        if (!empty($manualCertificado)) {
            $existingCertificado = Certificado::where('membro_id', $manualCertificado['membros_id'])
                ->where('descricao', $manualCertificado['descricao'])
                ->first();

            if (!$existingCertificado) {
                $certificado = new Certificado();
                $certificado->membro_id = $manualCertificado['membros_id'];
                $certificado->horas = $manualCertificado['horas'];
                $certificado->descricao = $manualCertificado['descricao'];
                $certificado->token = Str::random(10);
                $certificado->data = now();
                $certificado->save();
            }
        }

    return redirect()->route('certificados.index')->with('success', 'Certificados criados com sucesso.');
}

    public function show(Certificado $certificado)
    {
        return view('certificados.show', compact('certificado'));
    }

    public function generateCertificate(Certificado $certificado, $download = false)
{
    $membro = $certificado->membro;
    if (!$membro) {
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
