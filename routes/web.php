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

// le agregue el home
Route::get('/home', function () {
    return view('welcome');
});

// Route::get('/promociones', function () {
//     return view('home'); // Esto asume que 'home.blade.php' está en la carpeta 'resources/views'
// });

Route::get('/productos', function () {
    return view('home'); 
});


Auth::routes();

Route::get('/admin',[HomeController::class,'dash']); //->name('admin.dash')->middleware('auth.admin');
Route::resource('sabores', SaborController::class); //->middleware('auth.admin');

 //Route::resource('productos', ProductoController::class); //->middleware('auth.admin');

Route::resource('rellenos', RellenoController::class); //->middleware('auth.admin');
Route::resource('pedidos', PedidoController::class)->middleware('auth.admin');
Route::resource('catalogos', CatalogoController::class); //->middleware('auth.admin');
Route::resource('coberturas', CoberturaController::class)->middleware('auth.admin');
Route::resource('bancos', BancoController::class)->middleware('auth.admin');


//Route::put('pedidos/change',[PedidoController::class,'changeState']);
//Route::resource('rellenos', RellenoController::class);
Route::get('/productos-reservas', [ProductoController::class, 'index']);
Route::get('/productos-cart', [ProductoController::class, 'index']);
//Route::get('/', [CartController::class, 'shop'])->name('shop');
//Route::get('/cart', [CartController::class, 'cart'])->name('cart.index');

