<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    use HasFactory;

    protected $fillable = ['modelo_produto', 'descricao', 'qntde_estoque', 'status'];

    public function rules() {
        return [
            'modelo_produto' => 'required|max:45|unique:produtos',
            'status' => 'required|in:ATIVO,INATIVO',
            'descricao' => 'sometimes|max:150',
            'qntde_estoque' => 'required|integer'
        ];
    }

    public function feedback() {
        return [
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

    public function suprimento() {
        return $this->hasMany('App\Models\ItensProduto')->withPivot('suprimento_id');
    }
}
