<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\DemandSubmission;
use Illuminate\Support\Facades\Mail;

class SubmissionController extends Controller
{
    public function submit(Request $request)
    {
        $data = $request->all();

        // Verificar e processar arquivos anexados
        if ($request->hasFile('supporting_files')) {
            $files = $request->file('supporting_files');
            $data['files'] = $files;
        }

        // Enviar e-mail
        Mail::send(new DemandSubmission($data));

        return redirect()->back()->with('success', 'Demanda enviada com sucesso!');
    }
}