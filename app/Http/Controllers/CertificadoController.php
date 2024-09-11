<?php

namespace App\Http\Controllers;

use App\Models\Certificado;
use App\Models\Membro;
use Illuminate\Http\Request;
use PDF;
use Illuminate\Support\Str;

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

    public function download(Certificado $certificado)
    {
        $pdf = PDF::loadView('certificados.pdf', compact('certificado'));
        return $pdf->download('certificado.pdf');
    }
}