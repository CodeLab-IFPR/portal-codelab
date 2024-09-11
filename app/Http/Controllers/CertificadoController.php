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
        $credential = $certificado->token;
        $description = $certificado->descricao;
        $hours = $certificado->horas;
        $date = (new \DateTime($certificado->data))->format('d/m/Y'); // Convert string to DateTime
    
        // Generate QR Code 
        $qrCode = QrCode::format('png')->size(500)->generate($credential);
        $qrCodeDir = public_path('qr');
        $qrCodePath = $qrCodeDir . '/' . $credential . '.png';
    
        // Ensure the QR code directory exists
        if (!file_exists($qrCodeDir)) {
            mkdir($qrCodeDir, 0777, true);
        }
    
        file_put_contents($qrCodePath, $qrCode);
    
        // Ensure the certificate directory exists
        $certificateDir = public_path('certificate');
        if (!file_exists($certificateDir)) {
            mkdir($certificateDir, 0777, true);
        }
    
        // Create instance PDF
        $pdf = new Fpdi();
        $pathToTemplate = $certificateDir . '/Certificate.pdf';
        if (!file_exists($pathToTemplate)) {
            throw new \Exception("Template file not found: " . $pathToTemplate);
        }
        $pathToTemplate = public_path('certificate/Certificate.pdf');
        $pdf->setSourceFile($pathToTemplate);
        $template = $pdf->importPage(1);
    
        $size = $pdf->getTemplateSize($template);
    
        $pdf->AddPage($size['orientation'], [$size['width'], $size['height']]);
        $pdf->useTemplate($template, 0, 0, $size['width'], $size['height']);
    
        $pdf->SetFont('Helvetica');
        $pdf->SetFontSize(30);
        $pdf->SetXY(35, 120);
        $pdf->Write(0, $name);
    
        $pdf->SetFont('Helvetica');
        $pdf->SetFontSize(15);
        $pdf->SetXY(238, 177);
        $pdf->Write(0, $credential);
    
        $pdf->Image($qrCodePath, 217, 133, 40, 40);


        $fileName = 'Certificate_' . $credential . '.pdf';
        $filePath = $certificateDir . '/' . $fileName;
    
        // Save the PDF to the certificate directory
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