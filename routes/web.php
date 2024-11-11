<?php

use App\Http\Controllers\AtividadeController;
use App\Http\Controllers\LancamentoServicoController;
use App\Http\Controllers\NoticiasController;
use App\Http\Controllers\ParceiroController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CertificadoController;
use App\Http\Controllers\ProjetoController;
use App\Http\Controllers\ServicoController;
use App\Http\Controllers\TarefaController;
use App\Http\Controllers\Admin\FraseInicioController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SubmissionController;
use App\Http\Controllers\ContactController;

Route::get('/certificados/emitir', [CertificadoController::class, 'emitir'])->name('certificados.emitir');
Route::post('certificados/buscar', [CertificadoController::class, 'buscarCertificados'])->name('certificados.buscar');
Route::get('/certificados/{certificado}/view', [CertificadoController::class, 'viewCertificate'])->name('certificados.view');
Route::get('/certificados/{certificado}/download', [CertificadoController::class, 'downloadCertificate'])->name('certificados.download');
Route::get('/certificados/validar', [CertificadoController::class, 'showValidationForm'])->name('certificados.validar');
Route::post('/certificados/validar', [CertificadoController::class, 'validarCertificado'])->name('certificados.validar.post');
Route::post('/certificados/generate', [CertificadoController::class, 'generateFromTasks'])->name('certificados.generate');

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/pricing', function () {
    return view('pricing');
})->name('pricing');

Route::get('/contact', function () {
    return view('contact');
})->name('contact');

Route::get('/submission', function () {
    return view('submission');
})->name('submission');

Route::get('/admin', function () {
    return view('admin/index');
})->name('admin');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/about', [RegisteredUserController::class, 'about'])->name('about');

Route::get('/mensagens', [ContactController::class, 'index'])->name('mensagens.index');
Route::get('/mensagens/{id}', [ContactController::class, 'show'])->name('mensagens.show');
Route::delete('/mensagens/deleteSelected', [ContactController::class, 'deleteSelected'])->name('mensagens.deleteSelected');
Route::post('/mensagens/{id}/mark-read', [ContactController::class, 'markRead'])->name('mensagens.markRead');
Route::delete('/mensagens/{id}', [ContactController::class, 'destroy'])->name('mensagens.destroy');
Route::post('/mensagens/{id}/mark-read', [ContactController::class, 'markRead'])->name('mensagens.markRead');
Route::post('/mensagens/{id}/mark-unread', [ContactController::class, 'markUnread'])->name('mensagens.markUnread');
Route::post('/mensagens/{id}/toggleRead', [ContactController::class, 'toggleRead'])->name('mensagens.toggleRead');
Route::post('/mensagens/markReadSelected', [ContactController::class, 'markReadSelected'])->name('mensagens.markReadSelected');
Route::post('/mensagens/markUnreadSelected', [ContactController::class, 'markUnreadSelected'])->name('mensagens.markUnreadSelected');

Route::post('/submit-demand', [SubmissionController::class, 'submit'])->name('submit-demand');
Route::post('/submit', [SubmissionController::class, 'submit'])->name('submission.submit');
Route::post('/send-message', [ContactController::class, 'sendMessage'])->name('send-message');

Route::resource('certificados', CertificadoController::class);
Route::get('certificados/{id}/download', [CertificadoController::class, 'download'])->name('certificados.download');
Route::get('/certificados/{certificado}/view', [CertificadoController::class, 'viewCertificate'])->name('certificados.view');
Route::delete('certificados/{certificado}', [CertificadoController::class, 'destroy'])->name('certificados.destroy');
Route::post('/certificados/generate', [CertificadoController::class, 'generateFromTasks'])->name('certificados.generate');
Route::get('/certificados/create', [CertificadoController::class, 'create'])->name('certificados.create');
Route::post('/certificados', [CertificadoController::class, 'store'])->name('certificados.store');

Route::get('/google/redirect', [App\Http\Controllers\Auth\GoogleLoginController::class, 'redirectToGoogle'])->name('google.redirect');
Route::get('/google/callback', [App\Http\Controllers\Auth\GoogleLoginController::class, 'handleGoogleCallback'])->name('google.callback');

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('frase-inicio/editar', [App\Http\Controllers\Admin\FraseInicioController::class, 'editar'])->name('frase_inicio.editar');
    Route::put('frase-inicio/atualizar', [App\Http\Controllers\Admin\FraseInicioController::class, 'atualizar'])->name('frase_inicio.atualizar');
});

Route::get('/', [NoticiasController::class, 'home'])->name('home');
Route::resource('noticias', NoticiasController::class);
Route::get('noticias/create', [NoticiasController::class, 'create'])->name('noticias.create');
Route::get('noticias/{noticia}/edit', [NoticiasController::class, 'edit'])->name('noticias.edit');
Route::post('noticias', [NoticiasController::class, 'store'])->name('noticias.store');
Route::get('noticias/{noticia}', [NoticiasController::class, 'show'])->name('noticias.show');
Route::get('cards/noticias', [NoticiasController::class, 'cards'])->name('noticias.cards');
Route::get('noticias', [NoticiasController::class, 'index'])->name('noticias.index');
Route::put('noticias/{noticia}', [NoticiasController::class, 'update'])->name('noticias.update');
Route::delete('noticias/{user}', [NoticiasController::class, 'destroy'])->name('noticias.destroy');
Route::delete('noticias/{membro}', [NoticiasController::class, 'destroy'])->name('noticias.destroy');

Route::get('/submissions', [SubmissionController::class, 'index'])->name('submissions.index');
Route::get('/submissions/{id}', [SubmissionController::class, 'show'])->name('submissions.show');
Route::post('/submissions/{id}/mark-read', [SubmissionController::class, 'markRead'])->name('submissions.markRead');
Route::post('/submissions/{id}/mark-unread', [SubmissionController::class, 'markUnread'])->name('submissions.markUnread');
Route::post('/submissions/{id}/toggleRead', [SubmissionController::class, 'toggleRead'])->name('submissions.toggleRead');
Route::post('/submissions/markReadSelected', [SubmissionController::class, 'markReadSelected'])->name('submissions.markReadSelected');
Route::post('/submissions/markUnreadSelected', [SubmissionController::class, 'markUnreadSelected'])->name('submissions.markUnreadSelected');
Route::delete('/submissions/deleteSelected', [SubmissionController::class, 'deleteSelected'])->name('submissions.deleteSelected');
Route::delete('/submissions/{id}', [SubmissionController::class, 'destroy'])->name('submissions.destroy');


Route::resource('users', RegisteredUserController::class);
Route::get('users', [RegisteredUserController::class, 'index'])->name('users.index');
Route::delete('users/{user}', [RegisteredUserController::class, 'destroy'])->name('users.destroy');
Route::get('users/{user}', [RegisteredUserController::class, 'show'])->name('users.show');

Route::resource('parceiros', ParceiroController::class);
Route::get('parceiros', [ParceiroController::class, 'index'])->name('parceiros.index');
Route::delete('parceiros/{parceiro}', [ParceiroController::class, 'destroy'])->name('parceiros.destroy');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

});    

Route::resource('projetos', ProjetoController::class);
Route::resource('servicos', ServicoController::class);
Route::resource('lancamentos', LancamentoServicoController::class);

require __DIR__.'/auth.php';