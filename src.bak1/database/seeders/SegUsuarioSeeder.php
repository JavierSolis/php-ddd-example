<?php

namespace Database\Seeders;

use App\Models\Seguridad\Usuario;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SegUsuarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 0; $i < 10; $i++) {
            Usuario::create([
                'usuarioAlias' => 'usuario' . $i,
                'usuarioPassword' => md5('clave'.$i),
                'usuarioNombre' => 'Nombre ' . $i,
                'usuarioEmail' => 'usuario' . $i . '@example.com',
                'usuarioEstado' => 'Activo',
                'usuarioConectado' => '0', // o '1' si quieres que estén conectados
                'usuarioUltimaConexion' => null,
            ]);
        }
    }
}
