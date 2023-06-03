<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Usuario;
use App\Models\Divisao;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Usuario>
 */
class UsuarioFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Usuario::class;

    public function definition()
    {
        $dados = [
            'nome' => fake()->firstName(),
            'email' => fake()->email(),
            'status' => 'ATIVO',
            'user_interno' => fake()->randomElement(['SIM', 'NAO']),
            'cpf' => fake()->numberBetween(11111111111,99999999999),
            'senha' => bcrypt('12345678'),
            'diretoria_id' => fake()->randomElement([1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26])
        ];
        if(in_array($dados['diretoria_id'], [1,2,5,7,9,15,19,20,23,26])) {
            $divisaoId = Divisao::select('id')->where('diretoria_id', $dados['diretoria_id'])->inRandomOrder()->first()->id;
            $dados['divisao_id'] = $divisaoId;
        }
        return $dados;
    }
}