<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rule;
use App\Models\LocalImpressora;
use App\Models\Suprimento;

class Produto extends Model
{
    use HasFactory;

    protected $fillable = ['tipo_produto','modelo_produto', 'descricao', 'qntde_estoque', 'qntde_solicitada', 'status'];

    public function rules($request, $id) {
        return [
            'tipo_produto' => 'required|in:IMPRESSORA,CILINDRO,TONER,OUTROS',
            'modelo_produto' => 'required|max:45|unique:produtos,modelo_produto,'.$id,
            'status' => 'required|in:ATIVO,INATIVO',
            'descricao' => 'sometimes|max:150',
            'qntde_estoque' => ['integer', Rule::requiredIf($request->tipo_produto != 'IMPRESSORA')]
        ];
    }

    public function feedback() {
        return [
            'tipo_produto.required' => 'O tipo do produto deve ser preenchido',
            'tipo_produto.in' => 'O tipo do produto deve ser "Impressora", "Cilíndro", "Toner" ou "Outros"',
            'modelo_produto.required' => 'O modelo do produto deve ser preenchido',
            'modelo_produto.max' => 'O modelo do produto deve conter no máximo 45 caracteres',
            'modelo_produto.unique' => 'O nome do modelo já existe',
            'status.in' => 'O status deve ser "ATIVO" ou "INATIVO"',
            'descricao.max' => 'A descrição deve ter no máximo 150 caracteres',
            'qntde_estoque.required' => 'A quantidade de estoque deve ser definida',
            'qntde_estoque.integer' => 'A quantidade de estoque deve um número inteiro',
        ];
    }

    public function solicitacoes() {
        return $this->belongsToMany('App\Models\Solicitacao', 'itens_solicitacoes');
    }

    public function locais() {
        return $this->hasMany(LocalImpressora::class);
    }

    public function suprimentos() {
        return $this->hasMany(Suprimento::class)->orderBy('id');
    } 
}
