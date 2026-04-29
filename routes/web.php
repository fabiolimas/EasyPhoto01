<?php

use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\FormasDeEntregasController;
use App\Http\Controllers\ImageUploadController;
use App\Http\Controllers\LaboratorioController;
use App\Http\Controllers\PagamentoController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\TamanhoController;
use App\Http\Controllers\UserController;
use Illuminate\Auth\Events\Authenticated;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', function(){

    return view('site.auth.login');
})->name('login_cliente');

Route::get('/registre-se', function(){

    return view('site.auth.registro_cliente');
})->name('registro_cliente');

// Route::get('/privacidade', function(){
//     return view('site.mod_privacidade');
// })->name('privacidade');

Route::post('/registro-cliente',[RegisterController::class, 'storeCliente'])->name('registro-cliente');


Auth::routes();
Route::middleware(['auth'])->group(function () {
    //Site Controllers
    Route::get('/lab',[ImageUploadController::class, 'lab'])->name('lab');

    Route::get('/enviar/{id}',[ImageUploadController::class, 'showUploadForm'])->name('enviar-fotos');
    Route::post('/upload', [ImageUploadController::class, 'uploadImage'])->name('upload.image');
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


    //PedidosClientes
Route::get('/pedidos-cliente', [SiteController::class, 'pedidoCliente'])->name('pedidos-cliente');
Route::get('/meus-dados/{id}', [SiteController::class, 'meusDados'])->name('meus-dados');
Route::put('/editar-cliente/{id}',[UserController::class, 'editarCliente'])->name('editar-cliente');
Route::get('/detalhe-pedido/{id}', [SiteController::class, 'detalhePedido'])->name('detalhe-pedido');
Route::get('/busca-pedido', [SiteController::class, 'buscaPedidos'])->name('busca-pedidos');

//Usuarios
Route::get('/usuarios', [App\Http\Controllers\UserController::class, 'usuarios'])->name('usuarios');
Route::get('/usuario',[UserController::class, 'usuario'])->name('usuario');
Route::post('/usuario',[UserController::class, 'store'])->name('store-user');
Route::get('/usuario/{id}',[UserController::class, 'destroy'])->name('destroy-user');
Route::get('/edit-usuario/{id}',[UserController::class, 'edit'])->name('edit-user');
Route::post('/edit-usuario/{id}',[UserController::class, 'update'])->name('update-user');

//Clientes
Route::get('/clientes', [App\Http\Controllers\UserController::class, 'clientes'])->name('clientes');
Route::get('/usuario',[UserController::class, 'usuario'])->name('usuario');
Route::post('/usuario',[UserController::class, 'store'])->name('store-user');
Route::get('/usuario/{id}',[UserController::class, 'destroy'])->name('destroy-user');
Route::get('/edit-cliente/{id}',[UserController::class, 'editCliente'])->name('edit-cliente');
Route::post('/edit-usuario/{id}',[UserController::class, 'update'])->name('update-user');


//Laboratórios
Route::get('/laboratorios', [LaboratorioController::class, 'index'])->name('laboratorios');
Route::get('/laboratorio',[LaboratorioController::class, 'create'])->name('laboratorio');
Route::post('/laboratorio',[LaboratorioController::class, 'store'])->name('store-lab');
Route::get('/laboratorio/{id}',[LaboratorioController::class, 'destroy'])->name('destroy-lab');
Route::get('/edit-lab/{id}',[LaboratorioController::class, 'edit'])->name('edit-lab');
Route::post('/edit-lab/{id}',[LaboratorioController::class, 'update'])->name('update-lab');


//Tamanhos
Route::get('/tamanhos', [TamanhoController::class, 'index'])->name('tamanhos');
Route::get('/tamanho',[TamanhoController::class, 'create'])->name('tamanho');
Route::post('/tamanho',[TamanhoController::class, 'store'])->name('store-tamanho');
Route::get('/tamanho/{id}',[TamanhoController::class, 'destroy'])->name('destroy-tamanho');
Route::get('/edit-tamanho/{id}',[TamanhoController::class, 'edit'])->name('edit-tamanho');
Route::post('/edit-tamanho/{id}',[TamanhoController::class, 'update'])->name('update-tamanho');

//Pedidos
Route::get('/pedidos', [PedidoController::class, 'index'])->name('pedidos');
Route::get('/detalhes-pedido-admin/{id}', [PedidoController::class, 'detalhePedido'])->name('detalhes-pedidos-admin');
Route::get('/altera-status/{id}', [PedidoController::class, 'alteraStatus'])->name('altera-status');
Route::get('/busca-pedido-admin', [PedidoController::class, 'buscaPedidos'])->name('busca-pedidos-admin');
Route::get('/busca-pedido-admin-lab', [PedidoController::class, 'buscaPedidosLab'])->name('busca-pedidos-admin-lab');
Route::get('/download/{id}', [ImageUploadController::class, 'downloadFiles'])->name('download-files');

//Formas de Entrega
Route::get('/formas-de-entrega', [FormasDeEntregasController::class, 'index'])->name('formas-de-entrega');


Route::get('/editar-forma-de-entrega/{id}', [FormasDeEntregasController::class, 'edit'])->name('edit-forma-de-entrega');
Route::put('/editar-forma-de-entrega/{id}', [FormasDeEntregasController::class, 'update'])->name('update-forma-de-entrega');
Route::get('/forma-de-entrega', [FormasDeEntregasController::class, 'create'])->name('forma-de-entrega');
Route::post('/forma-de-entrega', [FormasDeEntregasController::class, 'store'])->name('store-forma-entrega');
Route::get('/destroy/{id}', [FormasDeEntregasController::class, 'destroy'])->name('delete-forma-de-entrega');

//Pagamentos

Route::get('/pagamento/escolha/{pedido}',[PaymentController::class, 'escolhaPagamento'])->name('pagamento.escolha');
Route::get('/pagamento/pix/{pedido}',[PaymentController::class, 'cieloPix'])->name('pagamento.pix');
Route::get('/pagamento/card/{pedido}',[PaymentController::class, 'cardView'])->name('pagamento.cardView');
Route::post('/pagamento/cartao/{pedido}',[PaymentController::class, 'cieloCard'])->name('pagamento.cartao.processar');
Route::post('/pagamento/processar/{pedido}', [PaymentController::class, 'processarPagamento'])
    ->name('pagamento.processar');
});
Route::post('/webhook/cielo', [PaymentController::class, 'webhook']);
Route::get('/simular-pagamento/{paymentId}', [PaymentController::class, 'simularPagamento']);


