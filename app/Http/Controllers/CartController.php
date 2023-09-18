<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;


class CartController extends Controller
{
    // public function shop()
    // {
    //     $productos = Producto::all();
    //    ($productos);
    //     return view('shop')->withTitle('E-COMMERCE STORE | SHOP')->with(['products' => $productos]);
    // }

    public function cart()  {
        $cartCollection = Producto::all();
        ($cartCollection);
        return view('checkout');
    }
    public function remove(Request $request){
        Producto::remove($request->id);
        return redirect()->route('cart.index')->with('success_msg', 'Item is removed!');
    }

    public function add(Request $request){
        Producto::add(array(
            'id' => $request->id,
            'nombre' => $request->nombre,
            //'sabor' => $request->sabor,
            'precio' => $request->precio,
            'attributes' => array(
                'imagen' => $request->imagen,
            )
        ));
        return redirect()->route('cart.index')->with('success_msg', 'Item Agregado a sú Carrito!');
    }

    public function update(Request $request){
        Producto ::findOrFail($request->id,
            array(
                'quantity' => array(
                    'relative' => false,
                    'value' => $request->precio
                ),
        ));
        return redirect()->route('cart.index')->with('success_msg', 'Cart is Updated!');
    }

    public function clear(){
        Producto::clear();
        return redirect()->route('cart.index')->with('success_msg', 'Car is cleared!');
    }

}
