<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Diretoria;

class DiretoriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Diretoria::create([
            'nome' => 'Secretaria de Saúde',
            'status' =>  'Ativo',
            'orgao_id' => 1,
        ]);
        

        Diretoria::create([
            'nome' => 'Farmácia Central',
            'status' =>  'Ativo',
            'orgao_id' => 1,
        ]);
        
        Diretoria::create([
            'nome' => 'Secretaria de Agricultura',
            'status' =>  'Ativo',
            'orgao_id' => 2,
        ]);
        
        Diretoria::create([
            'nome' => 'Atos Oficiais',
            'status' =>  'Ativo',
            'orgao_id' => 3,
        ]);
        
        Diretoria::create([
            'nome' => 'Secretaria de Habitação',
            'status' =>  'Ativo',
            'orgao_id' => 4,
        ]);
        
        Diretoria::create([
            'nome' => 'Secretaria de Fazenda',
            'status' =>  'Ativo',
            'orgao_id' => 5,
        ]);
        
        Diretoria::create([
            'nome' => 'IPTU',
            'status' =>  'Ativo',
            'orgao_id' => 5,
        ]);
        
        Diretoria::create([
            'nome' => 'Secretaria de Administração',
            'status' =>  'Ativo',
            'orgao_id' => 6,
        ]);
        
        Diretoria::create([
            'nome' => 'Diretoria de TI',
            'status' =>  'Ativo',
            'orgao_id' => 6,
        ]);
        
        Diretoria::create([
            'nome' => 'Secretaria de Obras',
            'status' =>  'Ativo',
            'orgao_id' => 7,
        ]);
        
        Diretoria::create([
            'nome' => 'Planejamento Urbano',
            'status' =>  'Ativo',
            'orgao_id' => 7,
        ]);
        
        Diretoria::create([
            'nome' => 'Projetos Técnicos',
            'status' =>  'Ativo',
            'orgao_id' => 7,
        ]);
        
        Diretoria::create([
            'nome' => 'Secretaria de Gabinete',
            'status' =>  'Ativo',
            'orgao_id' => 8,
        ]);
        
        Diretoria::create([
            'nome' => 'Gabinete do Prefeito',
            'status' =>  'Ativo',
            'orgao_id' => 8,
        ]);
        
        Diretoria::create([
            'nome' => 'Secretaria de Esportes',
            'status' =>  'Ativo',
            'orgao_id' => 9,
        ]);
        
        Diretoria::create([
            'nome' => 'Secretaria de Meio Ambiente',
            'status' =>  'Ativo',
            'orgao_id' => 10,
        ]);
        
        Diretoria::create([
            'nome' => 'Jurídico',
            'status' =>  'Ativo',
            'orgao_id' => 11,
        ]);
        
        Diretoria::create([
            'nome' => 'Secretaria de Indústria e Comércio',
            'status' =>  'Ativo',
            'orgao_id' => 12,
        ]);
        
        Diretoria::create([
            'nome' => 'Secretaria de Assistência Social',
            'status' =>  'Ativo',
            'orgao_id' => 13,
        ]);
        
        Diretoria::create([
            'nome' => 'Centro da Juventude',
            'status' =>  'Ativo',
            'orgao_id' => 13,
        ]);
        
        Diretoria::create([
            'nome' => 'Controle Interno',
            'status' =>  'Ativo',
            'orgao_id' => 14,
        ]);
        
        Diretoria::create([
            'nome' => 'Patrimônios',
            'status' =>  'Ativo',
            'orgao_id' => 14,
        ]);
        
        Diretoria::create([
            'nome' => 'Secretaria de Educação',
            'status' =>  'Ativo',
            'orgao_id' => 15,
        ]);
        
        Diretoria::create([
            'nome' => 'Escola X',
            'status' =>  'Ativo',
            'orgao_id' => 15,
        ]);

        Diretoria::create([
            'nome' => 'Escola Y',
            'status' =>  'Ativo',
            'orgao_id' => 15,
        ]);

        Diretoria::create([
            'nome' => 'Procon',
            'status' =>  'Ativo',
            'orgao_id' => 13,
        ]);
    }
}
