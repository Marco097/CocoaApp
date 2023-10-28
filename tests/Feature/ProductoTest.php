<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Database\Factories\ProductoFactory;
use App\Models\Producto;
use App\Http\Controllers\ProductoController;


use Tests\TestCase;

class ProductoTest extends TestCase
{
    public function testObtenerProductos()
    {
        // Crea una instancia del controlador
        $productoController = new ProductoController();

        // Llama directamente a la función que deseas probar
        $productos = $productoController->obtenerProductos();

        // Verifica si $productos contiene los datos esperados
        $this->assertNotEmpty($productos);
        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Collection::class, $productos);

        $response = $this->get('/api/productos');
        $response->assertStatus(200);
        $responseContent = $response->getContent();
        $this->assertStringContainsString('Los Productos se obtuvieron correctamente', $responseContent);
       
    }
}
