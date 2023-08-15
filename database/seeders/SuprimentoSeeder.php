<?php

namespace Database\Seeders;

use App\Models\Suprimento;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SuprimentoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Suprimento::create([
            'produto_id' => 1,
            'suprimento_id' => 3,
            'em_uso' => 'SIM',
            'tipo_suprimento' => 'TONER'
        ]);

        Suprimento::create([
            'produto_id' => 1,
            'suprimento_id' => 4,
            'em_uso' => 'NAO',
            'tipo_suprimento' => 'TONER'
        ]);

        Suprimento::create([
            'produto_id' => 1,
            'suprimento_id' => 7,
            'em_uso' => 'NAO',
            'tipo_suprimento' => 'CILINDRO'
        ]);

        Suprimento::create([
            'produto_id' => 1,
            'suprimento_id' => 8,
            'em_uso' => 'SIM',
            'tipo_suprimento' => 'CILINDRO'
        ]);

        Suprimento::create([
            'produto_id' => 2,
            'suprimento_id' => 4,
            'em_uso' => 'NAO',
            'tipo_suprimento' => 'TONER'
        ]);

        Suprimento::create([
            'produto_id' => 2,
            'suprimento_id' => 5,
            'em_uso' => 'SIM',
            'tipo_suprimento' => 'TONER'
        ]);
    }
}
