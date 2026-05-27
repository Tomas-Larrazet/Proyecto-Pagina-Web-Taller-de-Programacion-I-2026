<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
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
                'password' => bcrypt('admin123'), // Encriptar la contraseña
                'telefono' => '1234567890',
                'direccion' => 'Calle Principal 123',
            ]
        ];

        foreach ($usuarios as $usuario) {
            User::create($usuario);
        }
    }
}
