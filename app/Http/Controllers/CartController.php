<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
//use Darryldecode\Cart\Cart;
use App\Models\Producto;
use Cart;
class CartController extends Controller
{
    public function shop()
    {
        $products = Producto::all();
       //dd($products);
        return view('shop')->with(['products' => $products]);
    }
    public function cart()  {
        $cartCollection = Cart::getContent();
        //dd($cartCollection);
        //return view('cart')->with(['cartCollection' => $cartCollection]);;
        return view('cart')->with(['cartCollection' => $cartCollection]);;
    }
    public function remove(Request $request){
        Cart::remove($request->id);

        // Obtén los datos actualizados del carrito y devuélvelos como JSON
        $cartCollection = Cart::getContent();
    
        return redirect()->route('cart.index')->with('success_msg', 'El producto fue eliminado');
        //return response()->json(['message' => 'Item is removed!', 'cart' => $cartCollection]);
    }

    public function add(Request $request){
        Cart::add(array(
            'id' => $request->id,
            'name' => $request->name,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'attributes' => array(
                'image' => $request->img,
                'slug' => $request->slug
               // 'associatedModel' => 'Sabor'
            )
        ));
        return redirect()->route('cart.index')->with('success_msg', 'Se agrego un producto a su carrito');
    }

    public function update(Request $request){
        Cart::update($request->id,
            array(
                'quantity' => array(
                    'relative' => false,
                    'value' => $request->cantidad
                ),
        ));
        return redirect()->route('cart.index')->with('success_msg', 'Cart is Updated!');
    }

    public function clear(){
        Cart::clear();
        return redirect()->route('cart.index')->with('success_msg', 'su Carrito a sido eliminado');
    }
}
