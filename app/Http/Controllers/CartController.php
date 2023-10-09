<?php
 
 namespace App\Http\Controllers;
 
use Illuminate\Http\Request;
use App\Models\Producto; 
 
class CartController extends Controller
{
    public function index()
    {
        $productos = Producto::all();
       // return view('home', compact('productos'));
    }
 
    public function cart()
    {
        return view('cart');
    }
    public function addToCart($id)
    {
        $product = Producto::findOrFail($id);
 
        $cart = session()->get('cart', []);
 
        if(isset($cart[$id])) {
            $cart[$id]['quantity']++;
        }  else {
            $cart[$id] = [
                "product_name" => $product->nombre,
                "photo" => $product->imagen,
                "price" => $product->precio,
                "quantity" => 1
            ];
        }
 
        session()->put('cart', $cart);
        return redirect()->back()->with('success', 'Product add to cart successfully!');
    }
 
    public function update(Request $request)
    {
        if($request->id && $request->cantidad){
            $cart = session()->get('cart');
            $cart[$request->id]["quantity"] = $request->cantidad;
            session()->put('cart', $cart);
            session()->flash('success', 'Cart successfully updated!');
        }
    }
 
    public function remove(Request $request)
    {
        if($request->id) {
            $cart = session()->get('cart');
            if(isset($cart[$request->id])) {
                unset($cart[$request->id]);
                session()->put('cart', $cart);
            }
            session()->flash('success', 'Product successfully removed!');
        }
    }
}