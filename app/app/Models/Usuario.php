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
            'status' => ['required', new Enum(['ATIVO', 'INATIVO'])],
            'cpf' => 'required|unique:usuarios,cpf|min:11|max:20',
            'email' => 'required|email',
            'senha' => 'required|min:4|max:16'
        ];
    }

    public function feedback() {
        return [
            'required' => 'O campo :attribute deve ser preenchido',
            'status.enum' => 'A status deve ser "ATIVO" ou "INATIVO"',
            'cpf.unique' => 'O CPF inserido já foi utilizado',
            'cpf.min' => 'O CPF deve ser possuir no mínimo 11 caracteres',
            'cpf.max' => 'O CPF deve ser possuir no máximo 20 caracteres',
            'email.email' => 'O email deve ser válido',
            'senha.min' => 'A senha deve possuir no mínimo 4 caracteres',
            'senha.max' => 'A senha deve possuir no máximo 20 caracteres'
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
