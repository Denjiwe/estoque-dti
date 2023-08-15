<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Divisao;

class DivisaoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Divisao::create([
            'nome' => 'COVISA',
            'status' =>  'Ativo',
            'diretoria_id' => 1,
        ]);

        Divisao::create([
            'nome' => 'RH Saúde',
            'status' =>  'Ativo',
            'diretoria_id' => 1,
        ]);

        Divisao::create([
            'nome' => 'Alta Complexidade',
            'status' =>  'Ativo',
            'diretoria_id' => 1,
        ]);

        Divisao::create([
            'nome' => 'Infectologia',
            'status' =>  'Ativo',
            'diretoria_id' => 1,
        ]);

        Divisao::create([
            'nome' => 'Remédios',
            'status' =>  'Ativo',
            'diretoria_id' => 2,
        ]);

        Divisao::create([
            'nome' => 'Frios',
            'status' =>  'Ativo',
            'diretoria_id' => 2,
        ]);

        Divisao::create([
            'nome' => 'Atendimento Habitação',
            'status' =>  'Ativo',
            'diretoria_id' => 5,
        ]);

        Divisao::create([
            'nome' => 'Terrenos',
            'status' =>  'Ativo',
            'diretoria_id' => 5,
        ]);

        Divisao::create([
            'nome' => 'Impostos',
            'status' =>  'Ativo',
            'diretoria_id' => 5,
        ]);

        Divisao::create([
            'nome' => 'ICMS',
            'status' =>  'Ativo',
            'diretoria_id' => 7,
        ]);

        Divisao::create([
            'nome' => 'Divida Ativa',
            'status' =>  'Ativo',
            'diretoria_id' => 7,
        ]);

        Divisao::create([
            'nome' => 'Fiscais',
            'status' =>  'Ativo',
            'diretoria_id' => 7,
        ]);

        Divisao::create([
            'nome' => 'Postura',
            'status' =>  'Ativo',
            'diretoria_id' => 7,
        ]);

        Divisao::create([
            'nome' => 'Alvará',
            'status' =>  'Ativo',
            'diretoria_id' => 7,
        ]);

        Divisao::create([
            'nome' => 'Divisão de Desenvolvimento',
            'status' =>  'Ativo',
            'diretoria_id' => 9,
        ]);

        Divisao::create([
            'nome' => 'Divisão de Infraestrutura',
            'status' =>  'Ativo',
            'diretoria_id' => 9,
        ]);

        Divisao::create([
            'nome' => 'Atendimento SMEL',
            'status' =>  'Ativo',
            'diretoria_id' => 15,
        ]);

        Divisao::create([
            'nome' => 'Conselho Tutelar',
            'status' =>  'Ativo',
            'diretoria_id' => 19,
        ]);

        Divisao::create([
            'nome' => 'Jurídico Assistência Social',
            'status' =>  'Ativo',
            'diretoria_id' => 19,
        ]);

        Divisao::create([
            'nome' => 'Atendimento CEJU',
            'status' =>  'Ativo',
            'diretoria_id' => 20,
        ]);

        Divisao::create([
            'nome' => 'Clínica 1',
            'status' =>  'Ativo',
            'diretoria_id' => 20,
        ]);

        Divisao::create([
            'nome' => 'Clínica 2',
            'status' =>  'Ativo',
            'diretoria_id' => 20,
        ]);

        Divisao::create([
            'nome' => 'Merenda Escolar',
            'status' =>  'Ativo',
            'diretoria_id' => 23,
        ]);

        Divisao::create([
            'nome' => 'Jurídico Procon',
            'status' =>  'Ativo',
            'diretoria_id' => 26,
        ]);

        Divisao::create([
            'nome' => 'Guichês Procon',
            'status' =>  'Ativo',
            'diretoria_id' => 26,
        ]);

        Divisao::create([
            'nome' => 'Secretário',
            'status' =>  'Ativo',
            'diretoria_id' => 26,
        ]);
    }   
}
