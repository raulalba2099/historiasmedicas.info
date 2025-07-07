<?php

use App\Http\Controllers\MenuController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PacienteController;
use App\Http\Controllers\CitasCrearController;
use App\Http\Controllers\NotaController;
use App\Http\Controllers\CitaController;
use App\Http\Controllers\ConsultaController;
use App\Http\Controllers\RecomendacionesMenuController;
use App\Http\Controllers\ExamenFisicoController;
use App\Http\Controllers\RecetaController;
use App\Http\Controllers\HistoriaClinicaController;
use App\Http\Controllers\HistoriaClinicaSeccionController;
use App\Http\Controllers\HistoriaClinicaSubSeccionesController;
use App\Http\Controllers\HistoriaClinicaPreguntasController;
use App\Http\Controllers\MenbreteController;
use App\Http\Controllers\EstudiosController;
use App\Http\Controllers\ExpedienteController;
use Illuminate\Support\Facades\Route;

use App\Mail\RecetaMail;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('plantilla');
});



Route::view('/', 'paginas.citas');
Route::view('/pacientes', 'paginas.pacientes');
Route::view('/citas', 'paginas.citas');
Route::view('/citas-crear', 'paginas.citas-crear');
Route::view('/registrar','paginas.registrar');

Route::get('/pacientes', [PacienteController::class, 'indexAction']);
Route::get('/pacientes-buscar/{pacienbte}', [PacienteController::class, 'buscaPacientes']);
Route::post('/pacientes', [PacienteController::class, 'saveAction']);
Route::post('/pacientes/{id}', [PacienteController::class, 'show']);
Route::put('/pacientes/{id}', [PacienteController::class, 'updateAction']);
Route::delete('/pacientes/{id}', [PacienteController::class, 'deleteAction']);

Route::get('/citas-crear', [CitasCrearController::class, 'indexAction']);
Route::put('/citas-crear/{id}', [CitasCrearController::class, 'updateAction']);
Route::post('/citas-crear', [CitasCrearController::class, 'saveAction']);
Route::delete('/citas-crear/{id}', [CitasCrearController::class, 'deleteAction']);
Route::get('/citas-crear/{id}', [CitasCrearController::class, 'show']);

Route::get('/consulta/{id}', [ConsultaController::class, 'indexAction']);

Route::post('/recomendaciones-menu', [RecomendacionesMenuController::class, 'saveAction']);

Route::post('/examen-fisico', [ExamenFisicoController::class, 'saveAction']);

Route::post('/notas', [NotaController::class, 'saveAction']);
Route::put('/notas/{id}', [NotaController::class, 'updateAction']);
Route::delete('/notas/{id}', [NotaController::class, 'deleteAction']);

Route::post('/menu', [MenuController::class, 'saveAction']);
Route::put('/menu/{id}', [MenuController::class, 'updateAction']);
Route::delete('/menu/{id}', [MenuController::class, 'deleteAction']);
Route::get('/menu/{id}',[MenuController::class, 'indexAction'])->name('menus');

Route::post('/recomendaciones-menu', [RecomendacionesMenuController::class, 'saveAction']);
Route::put('/menu/{id}', [MenuController::class, 'updateAction']);

//Route::get('/receta/{id}', [RecetaController::class, 'indexAction']);
Route::post('/receta', [RecetaController::class, 'saveAction']);
Route::delete('/receta-elimina/{id}', [RecetaController::class, 'deleteAction']);
Route::get('/receta_pdf/{id}', [RecetaController::class, 'exportarPdf'])->name('receta.pdf');
Route::post('/send_pdf', [RecetaController::class, 'sendPdf'])->name('send.pdf');


Route::get('/menu_pdf/{id}', [MenuController::class, 'exportarPdf'])->name('menu.pdf');
Route::post('/send_pdf', [MenuController::class, 'sendPdf'])->name('send.pdf');

Route::get('/estudios/{id}',[EstudiosController::class, 'indexAction'])->name('estudios');
Route::post('/estudios',[EstudiosController::class, 'saveAction'])->name('estudios');
Route::put('/estudios/{id}', [EstudiosController::class, 'updateAction']);
Route::delete('/estudios/{id}', [EstudiosController::class, 'deleteAction']);
Route::get('/estudios_descargar/{id}', [EstudiosController::class, 'dowloadAction'])->name('descargar');

Route::get('/expediente', [ExpedienteController::class, 'indexExpedienteAction'])->name('expediente');
Route::get('/expediente-notas/{id}', [ExpedienteController::class, 'indexNotasAction'])->name('expediente');
Route::get('/expediente-fisico/{id}', [ExpedienteController::class, 'indexFisicoAction'])->name('expediente');
Route::get('/expediente-fisico-mostrar/{id}/{fecha}', [ExpedienteController::class, 'mostrarFisicoAction'])->name('expediente');
Route::get('/expediente-estudios/{id}', [ExpedienteController::class, 'indexEstudiosAction'])->name('expediente');
Route::get('/expediente-historia/{id}', [ExpedienteController::class, 'indexHistoriaAction'])->name('expediente');

Route::get('/historia-clinica-secciones', [HistoriaClinicaSeccionController::class, 'indexAction'])->name('historia-configuracion');
Route::put('/secciones/{id}', [HistoriaClinicaSeccionController::class, 'updateAction']);
Route::put('/secciones-deshabilitar/{id}', [HistoriaClinicaSeccionController::class, 'disableAction']);
Route::put('/secciones-habilitar/{id}', [HistoriaClinicaSeccionController::class, 'enableAction']);
Route::post('/secciones', [HistoriaClinicaSeccionController::class, 'saveAction'])->name('secciones');
Route::delete('/secciones/{id}', [HistoriaClinicaSeccionController::class, 'deleteAction']);


Route::get('/historia-clinica-subsecciones', [HistoriaClinicaSubSeccionesController::class, 'indexAction']);
Route::put('/subsecciones/{id}', [HistoriaClinicaSubSeccionesController::class, 'updateAction']);
Route::put('/subsecciones-deshabilitar/{id}', [HistoriaClinicaSubSeccionesController::class, 'disableAction']);
Route::put('/subsecciones-habilitar/{id}', [HistoriaClinicaSubSeccionesController::class, 'enableAction']);
Route::post('/subsecciones', [HistoriaClinicaSubseccionesController::class, 'saveAction'])->name('secciones');
Route::delete('/subsecciones/{id}', [HistoriaClinicaSubseccionesController::class, 'deleteAction']);

Route::get('/historia-clinica-preguntas', [HistoriaClinicaPreguntasController::class, 'indexAction']);
Route::put('/preguntas-deshabilitar/{id}', [HistoriaClinicaPreguntasController::class, 'disableAction']);
Route::put('/preguntas-habilitar/{id}', [HistoriaClinicaPreguntasController::class, 'enableAction']);
Route::put('/preguntas/{id}', [HistoriaClinicaPreguntasController::class, 'saveAction']);
Route::post('/preguntas', [HistoriaClinicaPreguntasController::class, 'saveAction'])->name('secciones');
Route::delete('/preguntas/{id}', [HistoriaClinicaPreguntasController::class, 'deleteAction']);

Route::get('/historia/{id}',[HistoriaClinicaController::class, 'indexAction'])->name('historia');
Route::post('/historia/',[HistoriaClinicaController::class, 'saveAction'])->name('historia-save');

Route::get('membrete/', [MenbreteController::class, 'indexAction'])->name('hoja-membretada');
Route::post('membrete', [MenbreteController::class, 'membreteAction'])->name('hoja-membretada');

//
//Route::get('/citas', [CitaController::class, 'indexAction']);


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

//Route::get('/', function (Codedge\Fpdf\Fpdf\Fpdf $fpdf) {
//
//    $fpdf->AddPage();
//    $fpdf->SetFont('Courier', 'B', 18);
//    $fpdf->Cell(50, 25, 'Hello World!');
//    $fpdf->Output();
//    exit;
//
//});


require __DIR__.'/auth.php';
