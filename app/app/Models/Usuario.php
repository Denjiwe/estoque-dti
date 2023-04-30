<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rules\Enum;

class Usuario extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'status',
        'cpf',
        'email',
        'senha',
        'divisao_id',
        'diretoria_id'
    ];

    protected $hidden = ['senha'];

    public function rules() {
        return [
            'nome' => 'required|max:45',
            'status' => 'required|in:ATIVO,INATIVO',
            'cpf' => 'required|unique:usuarios,cpf|min:11|max:20',
            'email' => 'required|email',
            'diretoria_id' => 'exists:diretorias,id',
            'senha' => 'required|min:4|max:16',
            'user_interno' => 'required|in:SIM,NAO'
        ];
    }

    public function feedback() {
        return [
            'required' => 'O campo :attribute deve ser preenchido',
            'min' => 'O campo :attribute deve ter no mínimo :min caracteres',
            'max' => 'O campo :attribute deve ter no máximo :max caracteres', 
            'status.in' => 'A status deve ser "ATIVO" ou "INATIVO"',
            'cpf.unique' => 'O CPF inserido já foi utilizado',
            'email.email' => 'O email deve ser válido',
            'diretoria_id.exists' => 'A diretoria não pode ser encontrada',
            'divisao_id.exists' => 'A divisão não pode ser encontrada',
            'user_interno.required' => 'A especificação do usuário deve ser preenchida', 
            'user_interno.in' => 'A especificação do usuário deve ser Sim ou Não', 
        ];
    }

    public function diretoria() {
        return $this->belongsTo('App\Models\Diretoria');
    }

    public function divisao() {
        return $this->belongsTo('App\Models\Divisao');
    }

    public function solicitacoes() {
        return $this->hasMany('App\Models\Solicitacao');
    }

    public function entregas() {
        return $this->hasMany('App\Models\Entrega');
    }
}
