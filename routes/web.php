<?php
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SaborController;
use App\Http\Controllers\RellenoController;
use App\Http\Controllers\PedidoController;

use App\Http\Controllers\CatalogoController;
use App\Http\Controllers\ProductoController;


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

Route::get('/', function () {
    return view('welcome');
});


Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/admin',[HomeController::class,'dash'])->name('dash');
Route::resource('sabores', SaborController::class);
Route::resource('productos', ProductoController::class);
Route::resource('rellenos', RellenoController::class);
Route::resource('pedidos', PedidoController::class);
Route::resource('catalogos', CatalogoController::class);
Route::put('pedidos/change',[PedidoController::class,'changeState']);
Route::resource('rellenos', RellenoController::class);
Route::get('/productos-reservas', [ProductoController::class, 'index']);