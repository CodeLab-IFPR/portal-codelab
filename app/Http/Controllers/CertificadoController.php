<?php

namespace App\Http\Controllers;

use App\Models\Certificado;
use App\Models\Membro;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use setasign\Fpdi\Fpdi;
use setasign\Fpdf\Fpdf;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class CertificadoController extends Controller
{
    public function create()
    {
        $membros = Membro::all();
        return view('certificados.create', compact('membros'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'membros_id' => 'required',
            'descricao' => 'required|string',
            'horas' => 'required|integer',
            'data' => 'required|date',
        ]);

        $certificado = Certificado::create([
            'membros_id' => $request->membros_id,
            'token' => Str::random(10),
            'descricao' => $request->descricao,
            'horas' => $request->horas,
            'data' => $request->data,
        ]);

        return redirect()->route('certificados.show', $certificado);
    }

    public function show(Certificado $certificado)
    {
        return view('certificados.show', compact('certificado'));
    }

    public function generateCertificate(Certificado $certificado, $download = false)
    {
        $name = $certificado->membro->nome;
        $cpf = $certificado->membro->cpf;
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
        $pdf->AddFont('DejaVuSans', '', 'DejaVuSans.ttf',true);

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
}