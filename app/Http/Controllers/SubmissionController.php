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

        // Enviar e-mail
        Mail::send(new DemandSubmission($data));

        return redirect()->back()->with('success', 'Demanda enviada com sucesso!');
    }
}