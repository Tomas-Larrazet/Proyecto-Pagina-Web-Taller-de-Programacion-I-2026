<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Producto;
use App\Models\Categoria;

class ProductoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Las categorias estan ordenadas de la siguiente manera: ID 1: Abridores, ID 2: Escarapelas, ID 3: Argollas, ID 4: Aros, 
        //                                                        ID 5: Anillos, ID 6: Pulseras, ID 7: Conjuntos, ID 8: Broches
        $productos = [
            [
                'nombre' => 'Escarapela bandera mini',
                'descripcion' => 'De acero. Cierre pin.',
                'precio' => 2700,
                'stock' => 10,
                'url_imagen' => 'images/products/escarapela-bandera-mini.jpeg', //Ruta a la carpeta public o URL externo
                'activo' => true,
                'categoria_id' => 2,
            ],
            [
                'nombre' => 'Escarapela circular mini',
                'descripcion' => 'De acero. Cierre pin.',
                'precio' => 2700,
                'stock' => 10,
                'url_imagen' => 'images/products/escarapela-circular-mini.jpeg', //Ruta a la carpeta public o URL externo
                'activo' => true,
                'categoria_id' => 2,
            ],
            [
                'nombre' => 'Abridor heart black',
                'descripcion' => 'Laminados en plata.',
                'precio' => 4000,
                'stock' => 8,
                'url_imagen' => 'images/products/abridor-heart-black.jpeg', //Ruta a la carpeta public o URL externo
                'activo' => true,
                'categoria_id' => 1,
            ],
            [
                'nombre' => 'Abridor heart celeste',
                'descripcion' => 'Laminados en plata.',
                'precio' => 4000,
                'stock' => 8,
                'url_imagen' => 'images/products/abridor-heart-celeste.jpeg', //Ruta a la carpeta public o URL externo
                'activo' => true,
                'categoria_id' => 1,
            ],
            [
                'nombre' => 'Abridor heart fucsia',
                'descripcion' => 'Laminados en plata.',
                'precio' => 4000,
                'stock' => 8,
                'url_imagen' => 'images/products/abridor-heart-fucsia.jpeg', //Ruta a la carpeta public o URL externo
                'activo' => true,
                'categoria_id' => 1,
            ],
            [
                'nombre' => 'Argolla clasica',
                'descripcion' => 'De plata 925. Tamaño: 10mm.',
                'precio' => 7000,
                'stock' => 5,
                'url_imagen' => 'images/products/argolla-clasica.jpeg', //Ruta a la carpeta public o URL externo
                'activo' => true,
                'categoria_id' => 3,
            ],
            [
                'nombre' => 'Argolla vibe',
                'descripcion' => 'De plata 925 con forma de ondas',
                'precio' => 12000,
                'stock' => 8,
                'url_imagen' => 'images/products/argolla-vibe.jpeg', //Ruta a la carpeta public o URL externo
                'activo' => true,
                'categoria_id' => 3,
            ],
            [
                'nombre' => 'Pulsera Pandora heart black',
                'descripcion' => 'De Acero Quirurgico',
                'precio' => 6500,
                'stock' => 12,
                'url_imagen' => 'images/products/pulsera-pandora-heart-black.jpeg', //Ruta a la carpeta public o URL externo
                'activo' => true,
                'categoria_id' => 6,
            ],
            [
                'nombre' => 'Pulsera Pandora heart',
                'descripcion' => 'De Acero Quirurgico',
                'precio' => 6500,
                'stock' => 12,
                'url_imagen' => 'images/products/pulsera-pandora-heart.jpeg', //Ruta a la carpeta public o URL externo
                'activo' => true,
                'categoria_id' => 6,
            ],
            [
                'nombre' => 'Pulsera Colour Azul',
                'descripcion' => 'De Acero Quirurgico',
                'precio' => 6000,
                'stock' => 12,
                'url_imagen' => 'images/products/pulsera-colour-azul.jpeg', //Ruta a la carpeta public o URL externo
                'activo' => true,
                'categoria_id' => 6,
            ],
            [
                'nombre' => 'Anillo hojas',
                'descripcion' => 'De Acero Blanco',
                'precio' => 4000,
                'stock' => 4,
                'url_imagen' => 'images/products/anillo-hojas.jpeg', //Ruta a la carpeta public o URL externo
                'activo' => true,
                'categoria_id' => 5,
            ],
            [
                'nombre' => 'Anillo Julia',
                'descripcion' => 'De Acero Blanco',
                'precio' => 9100,
                'stock' => 6,
                'url_imagen' => 'images/products/anillo-julia.jpeg', //Ruta a la carpeta public o URL externo
                'activo' => true,
                'categoria_id' => 5,
            ],
            [
                'nombre' => 'Anillo Corazones',
                'descripcion' => 'De Acero Blanco',
                'precio' => 3250,
                'stock' => 12,
                'url_imagen' => 'images/products/anillo-corazones.jpeg', //Ruta a la carpeta public o URL externo
                'activo' => true,
                'categoria_id' => 5,
            ],
            [
                'nombre' => 'Aros Flor',
                'descripcion' => 'De Plata 925',
                'precio' => 7800,
                'stock' => 9,
                'url_imagen' => 'images/products/aros-flor.jpeg', //Ruta a la carpeta public o URL externo
                'activo' => true,
                'categoria_id' => 4,
            ],
            [
                'nombre' => 'Aros Reina',
                'descripcion' => 'De Plata 925',
                'precio' => 7800,
                'stock' => 12,
                'url_imagen' => 'images/products/aros-reina.jpeg', //Ruta a la carpeta public o URL externo
                'activo' => true,
                'categoria_id' => 4,
            ],
            [
                'nombre' => 'Aros Gota Grande',
                'descripcion' => 'De Plata 925',
                'precio' => 13000,
                'stock' => 3,
                'url_imagen' => 'images/products/aros-gota-grande.jpeg', //Ruta a la carpeta public o URL externo
                'activo' => true,
                'categoria_id' => 4,
            ],
            [
                'nombre' => 'Broche Hawaii Grande amarillo-celeste',
                'descripcion' => 'Broche para el pelo',
                'precio' => 5200,
                'stock' => 4,
                'url_imagen' => 'images/products/broche-hawaii-grande-amarillo-celeste.jpeg', //Ruta a la carpeta public o URL externo
                'activo' => true,
                'categoria_id' => 8,
            ],
            [
                'nombre' => 'Broche Hawaii Grande rosa-fucsia',
                'descripcion' => 'Broche para el pelo',
                'precio' => 5200,
                'stock' => 4,
                'url_imagen' => 'images/products/broche-hawaii-grande-rosa-fucsia.jpeg', //Ruta a la carpeta public o URL externo
                'activo' => true,
                'categoria_id' => 8,
            ],
             [
                'nombre' => 'Conjunto Corazón Violeta',
                'descripcion' => 'Set de Collar con dije Corazon Violeta y bolitas',
                'precio' => 7800,
                'stock' => 3,
                'url_imagen' => 'images/products/conjunto-corazon-violeta.jpeg', //Ruta a la carpeta public o URL externo
                'activo' => true,
                'categoria_id' => 7,
            ],
            [
                'nombre' => 'Conjunto Copo de Nieve',
                'descripcion' => 'Set de collar con dije Copo de Nieve',
                'precio' => 4550,
                'stock' => 4,
                'url_imagen' => 'images/products/conjunto-copo-nieve.jpeg', //Ruta a la carpeta public o URL externo
                'activo' => true,
                'categoria_id' => 7,
            ],

        ]
    }
}
