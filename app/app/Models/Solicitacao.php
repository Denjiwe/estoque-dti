<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Solicitacao extends Model
{
    use HasFactory;

    protected $table = 'solicitacoes';

    protected $fillable = [
        'status',
        'observacao',
        'usuario_id',
        'divisao_id',
        'diretoria_id'
    ];

    public function rules() {
        return [
            'observacao' => 'nullable|max:100',
            'usuario_id' => 'required|exists:usuarios,id',
            'divisao_id' => 'exists:divisoes,id|nullable',
            'diretoria_id' => 'required|exists:diretorias,id'
        ];
    }

    public function feedback() {
        return [
            'required' => 'O campo :attribute deve ser preenchido',
            'observacao.max' => 'A observação deve conter no máximo 100 caracteres',
            'usuario_id.exists' => 'O usuário não foi encontrado',
            'divisao_id.exists' => 'A divisão não foi encontrada',
            'diretoria_id.exists' => 'A diretoria não foi encontrada',
        ];
    }

    public function produtos() {
        return $this->belongsToMany('App\Models\Produto', 'itens_solicitacoes')->withPivot('id', 'qntde');
    }

    public function divisao() {
        return $this->belongsTo('App\Models\Divisao');
    }

    public function diretoria() {
        return $this->belongsTo('App\Models\Diretoria');
    }

    public function usuario() {
        return $this->belongsTo('App\Models\Usuario');
    }

    public function itens_solicitacoes() {
        return $this->hasMany('App\Models\ItensSolicitacao');
    }

    public function entregas() {
        return $this->hasManyThrough('App\Models\Entrega', 'App\Models\ItensSolicitacao', 'solicitacao_id', 'itens_solicitacao_id', 'id', 'id');
    }
}
