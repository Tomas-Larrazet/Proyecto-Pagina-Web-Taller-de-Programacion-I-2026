<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UsuarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $usuarios = [
            [
                'name' => 'Admi Nistrador',
                'email' => 'administrador@gmail.com',
                'password' => Hash::make('admin123'), // Encriptar la contraseña
                'rol' => 'admin',
                'telefono' => '1234567890',
                'direccion' => 'Calle Principal 123',
            ],

            [
                'name' => 'Cliente Ejemplo',
                'email' => 'cliente@gmail.com',
                'password' => Hash::make('cliente123'),
                'rol' => 'cliente',
                'telefono' => '0987654321',
                'direccion' => 'Avenida Secundaria 456',
            ]
        ];

        foreach ($usuarios as $usuario) {
            User::create($usuario);
        }
    }
}
