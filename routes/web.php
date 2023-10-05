<?php
use App\Http\Controllers\BancoController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SaborController;
use App\Http\Controllers\RellenoController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\CatalogoController;
use App\Http\Controllers\CoberturaController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\CartController;
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
Route::get('/admin',[HomeController::class,'dash'])->name('admin.dash')->middleware('auth.admin');
Route::resource('sabores', SaborController::class)->middleware('auth.admin');
Route::resource('productos', ProductoController::class)->middleware('auth.admin');
Route::resource('rellenos', RellenoController::class)->middleware('auth.admin');
Route::resource('pedidos', PedidoController::class)->middleware('auth.admin');
Route::resource('catalogos', CatalogoController::class)->middleware('auth.admin');
Route::resource('coberturas', CoberturaController::class)->middleware('auth.admin');
Route::resource('bancos', BancoController::class)->middleware('auth.admin');

//Route::put('pedidos/change',[PedidoController::class,'changeState']);
//Route::resource('rellenos', RellenoController::class);
Route::get('/productos-reservas', [ProductoController::class, 'index']);
<<<<<<< HEAD
Route::get('/productos-cart', [ProductoController::class, 'index']);
=======


>>>>>>> f0aa187b5f234c60d091b5f31174033650fb9431
//Route::get('/', [CartController::class, 'shop'])->name('shop');
//Route::get('/cart', [CartController::class, 'cart'])->name('cart.index');
//Route::post('/add', [CartController::class, 'add'])->name('cart.store');
//Route::post('/update', [CartController::class, 'update'])->name('cart.update');
//Route::post('/remove', [CartController::class, 'remove'])->name('cart.remove');
//Route::post('/clear', [CartController::class, 'clear'])->name('cart.clear');
//Route::get('/cart-checkout','CartController@cart')->name('cart.checkout');
//Route::post('/cart-clear', 'CartController@clear')->name('cart.clear');
//Route::post('/cart-removeitem', 'CartController@removeitem')->name('cart.removeitem');