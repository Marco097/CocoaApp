<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductoPromocion extends Model
{
    use HasFactory;

    protected $table = "productos_promociones";

         //relaciones inversas
         public function producto()
         {
             return $this->belongsTo(Producto::class);
         }

          //relaciones inversas
             public function promocion()
                {
                    return $this->belongsTo(Producto::class);
                }
}
