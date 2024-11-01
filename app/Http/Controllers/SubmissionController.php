<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\DemandSubmission;
use Illuminate\Support\Facades\Mail;
use App\Models\Submission;

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

        // Salvar a submissão no banco de dados
        $submission = Submission::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'demand_description' => $data['demand_description'],
            'expected_utility' => $data['expected_utility'],
        ]);

        // Enviar e-mail
        Mail::send(new DemandSubmission($data));

        return redirect()->back()->with('success', 'Submissão enviada com sucesso!');
    }
}