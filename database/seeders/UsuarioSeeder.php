<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Usuario;

class UsuarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Usuario::create([
            'nome' => 'Santhiago',
            'status' => 'ATIVO',
            'cpf' => 10735389900,
            'email' => 'santhiago@hotmail.com',
            'senha' => bcrypt('12345678'),
            'divisao_id' => 15,
            'diretoria_id' => 9 
        ]);

        Usuario::factory()->count(99)->create();
    }
}
