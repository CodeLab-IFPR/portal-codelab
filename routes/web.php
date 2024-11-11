<?php

use App\Http\Controllers\AtividadeController;
use App\Http\Controllers\LancamentoServicoController;
use App\Http\Controllers\MembroController;
use App\Http\Controllers\NoticiasController;
use App\Http\Controllers\ParceiroController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CertificadoController;
use App\Http\Controllers\ProjetoController;
use App\Http\Controllers\ServicoController;
use App\Http\Controllers\TarefaController;
use Illuminate\Support\Facades\Route;

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

Route::resource('certificados', CertificadoController::class);
Route::get('certificados/{id}/download', [CertificadoController::class, 'download'])->name('certificados.download');
Route::get('/certificados/{certificado}/view', [CertificadoController::class, 'viewCertificate'])->name('certificados.view');
Route::delete('certificados/{certificado}', [CertificadoController::class, 'destroy'])->name('certificados.destroy');
Route::post('/certificados/generate', [CertificadoController::class, 'generateFromTasks'])->name('certificados.generate');
Route::get('/certificados/create', [CertificadoController::class, 'create'])->name('certificados.create');
Route::post('/certificados', [CertificadoController::class, 'store'])->name('certificados.store');

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