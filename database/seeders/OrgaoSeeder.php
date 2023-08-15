<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Orgao;

class OrgaoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Orgao::create([
            'nome' => 'Saúde',
            'status' => 'ATIVO'
        ]);

        Orgao::create([
            'nome' => 'Agricultura',
            'status' => 'ATIVO'
        ]);

        Orgao::create([
            'nome' => 'Atos Oficiais',
            'status' => 'ATIVO'
        ]);

        Orgao::create([
            'nome' => 'Habitação',
            'status' => 'ATIVO'
        ]);

        Orgao::create([
            'nome' => 'Fazenda',
            'status' => 'ATIVO'
        ]);

        Orgao::create([
            'nome' => 'Administração',
            'status' => 'ATIVO'
        ]);

        Orgao::create([
            'nome' => 'Obras',
            'status' => 'ATIVO'
        ]);

        Orgao::create([
            'nome' => 'Gabinete',
            'status' => 'ATIVO'
        ]);

        Orgao::create([
            'nome' => 'Esportes',
            'status' => 'ATIVO'
        ]);

        Orgao::create([
            'nome' => 'Meio Ambiente',
            'status' => 'ATIVO'
        ]);

        Orgao::create([
            'nome' => 'Procuradoria-Geral',
            'status' => 'ATIVO'
        ]);

        Orgao::create([
            'nome' => 'Indústria e Comércio',
            'status' => 'ATIVO'
        ]);

        Orgao::create([
            'nome' => 'Assistêcia Social',
            'status' => 'ATIVO'
        ]);

        Orgao::create([
            'nome' => 'Controladoria Interna',
            'status' => 'ATIVO'
        ]);

        Orgao::create([
            'nome' => 'Edução',
            'status' => 'ATIVO'
        ]);
    }
}