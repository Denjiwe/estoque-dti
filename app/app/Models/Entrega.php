<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Entrega extends Model
{
    use HasFactory;

    protected $fillable = ['qntde', 'observacao', 'usuario_id', 'itens_solicitacao_id'];

    public function rules() {
        return [
            'qntde' => 'required|integer',
            'observacao' => 'sometimes|max:100',
            'usuario_id' => 'required|exists:usuarios,id',
            'itens_solicitacao_id' => 'required|exists:itens_solictacoes,id'
        ];
    }

    public function feedback() {
        return [
            'qntde.required' => 'A quantidade deve ser informada',
            'qntde.integer' => 'A quantidade deve ser um número inteiro',
            'observacao.max' => 'A observação deve conter no máximo 100 caracteres',
            'usuario_id.required' => 'O usuário deve ser informado',
            'usuario_id.exists' => 'O usuário deve não foi encontrado',
            'itens_solicitacao_id.required' => 'O produto da entrega deve ser preenchido',
            'itens_solicitacao_id.exists' => 'O produto da entrega não foi encontrado'
        ];
    }

    public function usuario() {
        return $this->belongsTo('App\Models\Usuario');
    }

    public function itens_solicitacao() {
        return $this->belongsTo('App\Models\ItensSolicitacao');
    }

    public function produto() {
        return $this->hasOneThrough('App\Models\Produto', 'App\Models\ItensSolicitacao', 'id', 'id', 'itens_solicitacao_id', 'produto_id');
    }

    public function solicitacao() {
        return $this->hasOneThrough('App\Models\Solicitacao', 'App\Models\ItensSolicitacao', 'id', 'id', 'itens_solicitacao_id', 'solicitacao_id');
    }
}
