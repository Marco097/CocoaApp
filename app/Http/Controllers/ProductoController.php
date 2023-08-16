<?php

namespace App\Http\Controllers;
use App\Models\Producto;
use App\Models\ProductoCobertura;
use App\Models\ProductoPromocion;
use App\Models\ProductoSabor;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        try{
            $productos = Producto::all();
            //convirtienod en array
            $response = $productos->toArray();
            $i=0;
            foreach($productos as $producto)
            {
                if ($producto->relleno) {
                    $response[$i]["relleno"] = $producto->relleno->toArray();
                }
                $response[$i]["catalogo"] = $producto->catalogo->toArray(); 
                $response[$i]["sabor"] = $producto->sabor->toArray();
                $response[$i]["promocion"] = $producto->promocion->toArray();  
                $response[$i]["cobertura"] = $producto->cobertura->toArray(); 
                
                $i++;
            }
            
        //return view('shop')->withTitle('COCOASWEET | SHOP')->with(['productos' => $productos]);

            //dd ($response)

            return $response;

        }catch(\Exception $e)
        {
            return $e->getMessage();
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('admin.productos');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        try{
            $errores = 0;
            $producto = new Producto();
            $producto->nombre = $request->nombre;
            $producto->descripcion = $request->descripcion;
            $producto->precio = $request->precio;
            $producto->existencias = $request->existencias;
            $producto->hecho = $request->hecho;
            $producto->vencimiento = $request->vencimiento;
            //$producto->imagen = $request->imagen;
            $producto->relleno_id = $request->input('relleno.id');;
            $producto->catalogo_id = $request->input('catalogo.id');
            
            //comprovando si viene una imagen
            if($request->hasFile('imagen')){
                //obteniendo el archivo de una imagen
                $imagen = $request->file('imagen');
                //generando un nombre unico para la imagen
                $nombreImagen = time() . '_' . $imagen->getClientOriginalName();
                //subiendo la imagen a una carpeta del servidor
                $imagen->move(public_path('images/productos/'),$nombreImagen);
                $producto->imagen = $nombreImagen;
            }else{
                $producto->imagen = "none.jpg";
            }

            if($producto->save()<=0)
            {
                $errores++;
            }
            // Guardar las relaciones con sabores
            $sabore = $request->sabores;
            if (!is_null($sabore) && is_array($sabore)) 
            {
                foreach ($sabore as $key => $sb) {
                    $productoSabor = new ProductoSabor();
                    $productoSabor->sabor_id = $sb['id'];
                    $productoSabor->producto_id = $producto->id;
    
                    if ($productoSabor->save() <= 0) {
                        $errores++;
                    }
                }
            }
            //guardando la relcion de promociones 
            $promocio = $request->promociones;
            if (!is_null($promocio) && is_array($promocio)) 
            {
                foreach ($promocio as $key => $promo) {
                    $productoPromocion = new ProductoPromocion();
                    $productoPromocion->promocion_id = $promo['id'];
                    $productoPromocion->producto_id = $producto->id;
    
                    if ($productoPromocion->save() <= 0) {
                        $errores++;
                    }
                }
            }
            //GUARDANDO LA COBERTURA
            
            $cobertu = $request->coberturas;
            if (!is_null($cobertu) && is_array($cobertu))
            {
                foreach ($cobertu as $key => $cob) {
                    $productoCobertura = new ProductoCobertura();
                    $productoCobertura->cobertura_id = $cob['id'];
                    $productoCobertura->producto_id = $producto->id;
    
                    if ($productoCobertura->save() <= 0) {
                        $errores++;
                    }
                }
            }

        

            if($producto->save()>= 1)
            {
                return response()->json(['status'=>'ok','data'=>$producto],201);
            }else{
                return response()->json(['status'=>'fail','data'=>$producto],409);
            }
        }catch(\Exception $e)
            {
                return $e->getMessage();
            }        
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        try{
            $producto = Producto::findOrFail($id);
            //convirtienod en array
            $response = $producto->toArray();   
            $response["relleno"]= $producto->relleno->toArray();
            $response["catalogo"]= $producto->catalogo->toArray();
            $response["sabor"] = $producto->sabor->toArray();
            $response["promocion"] = $producto->promocion->toArray();  
            $response["cobertura"] = $producto->cobertura->toArray(); 
            return $response;
        }catch(\Exception $e){
            return $e->getMessage();
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        try{
            $producto = Producto::findOrFail($id);
            $producto->nombre = $request->nombre;
            $producto->descripcion = $request->descripcion;
            $producto->precio = $request->precio;
            $producto->existencias = $request->existencias;
            $producto->hecho = $request->hecho;
            $producto->vencimiento = $request->vencimiento;            
            $producto->imagen = $request->imagen;
            $producto->relleno_id = $request->relleno_id;
            $producto->catalogo_id = $request->catalogo_id;
            
            $imagenAnterior = $producto->imagen;
            //COMPROBANDO SI VIENE UNA IMAGEN
            if($request->hasFile('imagen'))
            {
                //eliminando archivo anterior
                $imagePath = public_path() . '/images/productos/' .$imagenAnterior;
                if($imagenAnterior != 'none.jpg')
                {
                    unlink($imagePath);
                }
            
            //obteniend el archivo de imagen
            $imagen = $request->file('imagen');
            //GENERANDO UN NOMBRE UNICO PARA LA IMAGEN 
            $nombreImagen = time() . '_' . $imagen->getClientOriginalName();
            //subiendo la imagen a una carpeta del servidor
            $imagen->move(public_path('images/productos/'),$nombreImagen);
            $producto->imagen = $nombreImagen;
        }else{
           
                $producto->imagen = 'none.jpg';
            
        }
            
            if($producto->update()>= 1)
            {
                return response()->json(['status'=>'ok','data'=>$producto],202);
            }else
            {
                return response()->json(['status'=>'fail','data'=>null],409); 
            }
        }catch(\Exception $e)
            {
                return $e->getMessage();
            }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        try{
            $producto = Producto::findOrFail($id);
            $imagenAnterior = $producto->imagen;
            $imagePath = public_path() . '/images/productos/' .$imagenAnterior;
            if($imagenAnterior != 'none.jpg')
            {
                unlink($imagePath);
            }
            if ($producto->delete()>=1)
            {
               return response()->json(['status'=>'ok','data'=>null],205);
            }
         } catch(\Exception $e)
                {
                    return $e->getMessage();
                }
    }
}
