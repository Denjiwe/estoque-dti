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
        'usuario_id'
    ];

    public function rules() {
        return [
            'status' => 'required|in:AGUARDANDO,ABERTO,ENCERRADO,LIBERADO',
            'observacao' => 'sometimes|max:100',
            'usuario_id' => 'required|exists:usuarios,id'
        ];
    }

    public function feedback() {
        return [
            'required' => 'O campo :attribute deve ser preenchido',
            'status.in' => 'O status da solicitação passado é inválido',
            'observacao.max' => 'A observação deve conter no máximo 100 caracteres',
            'usuario_id.required' => 'O usuário deve ser preenchido',
            'usuario_id.exists' => 'O usuário não foi encontrado'
        ];
    }

    public function produtos() {
        return $this->belongsToMany('App\Models\Produto', 'itens_solicitacoes');
    }

    public function usuario() {
        return $this->belongsTo('App\Models\Usuario');
    }
}
