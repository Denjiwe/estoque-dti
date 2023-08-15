<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rules\Enum;
use OwenIt\Auditing\Contracts\Auditable;

class Orgao extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    protected $fillable= ['nome', 'status'];

    public function rules($id){
        return [
            'nome' => 'required|unique:orgaos,nome,'.$id,
            'status' => 'required|in:ATIVO,INATIVO'
        ];
    }

    public function feedback() {
        return [
            'required' => 'O campo :attribute deve ser preenchido',
            'nome.unique' => 'O nome passado já foi utilizado',
            'nome.max' => 'O nome deve ter no máximo 45 caracteres',
            'status.in' => 'O status deve ser "ATIVO" ou "INATIVO"',
        ];
    }

    public function diretorias() {
        return $this->hasMany('App\Models\Diretoria');
    }
}