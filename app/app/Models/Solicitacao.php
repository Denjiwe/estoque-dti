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
            'usuario_id' => 'nullable|exists:usuarios,id',
            'divisao_id' => 'nullable|exists:divisoes,id',
            'diretoria_id' => 'nullable|exists:diretorias,id'
        ];
    }

    public function feedback() {
        return [
            'required' => 'O campo :attribute deve ser preenchido',
            'observacao.max' => 'A observação deve conter no máximo 100 caracteres',
            'usuario_id.exists' => 'O usuário não foi encontrado',
            'divisao_id.exists' => 'A divisão não foi encontrado',
            'diretoria_id.exists' => 'A diretoria não foi encontrado',
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
}
