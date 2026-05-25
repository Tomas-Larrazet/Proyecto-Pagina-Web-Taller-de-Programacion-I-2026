<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Categoria;

class CategoriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categorias = [
            ['nombre' => 'Abridores', 
             'descripcion' => 'Abridores laminados en Plata'
            ],
            ['nombre' => 'Escarapelas', 
             'descripcion' => 'Escarapelas de acero'
            ],
            ['nombre' => 'Argollas', 
             'descripcion' => 'Argollas de Plata 925'
            ],
            ['nombre' => 'Aros', 
             'descripcion' => 'Aros de Plata 925'
            ],
            ['nombre' => 'Anillos', 
             'descripcion' => 'Anillos de Acero blanco'
            ],
            ['nombre' => 'Pulseras', 
             'descripcion' => 'Pulseras de Acero Quirurgico'
            ],
            ['nombre' => 'Conjuntos',
             'descripcion' => 'Set de collar + dije'
            ],
            ['nombre' => 'Broches',
             'descripcion' => 'Broches de pelo'
            ]

        ];

        // Usamos un bucle para guardar cada categoria en la BD
        foreach ($categorias as $categoria) {
            Categoria::create($categoria);
        }
    }
}
