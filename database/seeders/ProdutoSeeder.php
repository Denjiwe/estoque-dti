<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Produto;
use App\Models\Suprimento;

class ProdutoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Produto::create([
            'tipo_produto' => 'IMPRESSORA',
            'modelo_produto' => 'Brother 5652',
            'qntde_estoque' => 20,
            'status' => 'ATIVO'
        ]);

        Produto::create([
            'tipo_produto' => 'IMPRESSORA',
            'modelo_produto' => 'HP P1102w',
            'qntde_estoque' => 20,
            'status' => 'ATIVO'
        ]);

        Produto::create([
            'tipo_produto' => 'TONER',
            'modelo_produto' => 'T3442 Tonali',
            'qntde_estoque' => 70,
            'status' => 'ATIVO'
        ]);

        Produto::create([
            'tipo_produto' => 'TONER',
            'modelo_produto' => 'T3442 Milenium',
            'qntde_estoque' => 30,
            'status' => 'ATIVO'
        ]);

        Produto::create([
            'tipo_produto' => 'TONER',
            'modelo_produto' => '285A Tonali',
            'qntde_estoque' => 43,
            'status' => 'ATIVO'
        ]);

        Produto::create([
            'tipo_produto' => 'TONER',
            'modelo_produto' => '285a Milenium',
            'qntde_estoque' => 65,
            'status' => 'ATIVO'
        ]);

        Produto::create([
            'tipo_produto' => 'CILINDRO',
            'modelo_produto' => 'C3442 Tonali',
            'qntde_estoque' => 32,
            'status' => 'ATIVO'
        ]);

        Produto::create([
            'tipo_produto' => 'CILINDRO',
            'modelo_produto' => 'C3442 Milenium',
            'qntde_estoque' => 16,
            'status' => 'ATIVO'
        ]);
    }
}