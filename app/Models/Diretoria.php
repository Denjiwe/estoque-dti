<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rules\Enum;
use OwenIt\Auditing\Contracts\Auditable;

class Diretoria extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    protected $fillable= ['nome', 'status', 'orgao_id', 'email'];

    public function rules($id) {
        return [
            'nome' => 'required|unique:diretorias,nome,'.$id,
            'status' => 'required|in:ATIVO,INATIVO',
            'orgao_id' => 'required|exists:orgaos,id',
            'email' => 'nullable|max:100|email|unique:diretorias,email,'.$id
        ];
    }

    public function feedback() {
        return [
            'required' => 'O campo :attribute deve ser preenchido',
            'max' => 'O campo :attribute deve ter no máximo :max caracteres',
            'status.in' => 'O status deve ser "ATIVO" ou "INATIVO"',
            'nome.unique' => 'O nome passado já foi utilizado',
            'orgao_id.required' => 'O órgão deve ser informado',
            'orgao_id.exists' => 'O órgão passado não pode ser encontrado',
            'email.email' => 'O email inserido não é válido',
            'email.unique' => 'O email inserido já foi utilizado!'
        ];
    }

    public function orgao(){
        return $this->belongsTo('App\Models\Orgao');
    }

    public function divisoes() {
        return $this->hasMany('App\Models\Divisao');
    }

    public function usuarios() {
        return $this->hasMany('App\Models\Usuario');
    }
}
