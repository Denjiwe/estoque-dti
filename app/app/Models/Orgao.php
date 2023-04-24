<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rules\Enum;

class Orgao extends Model
{
    use HasFactory;

    // use SoftDelete;
    protected $fillable= ['nome', 'status'];

    public function rules(){
        return [
            'nome' => 'required|unique:orgaos',
            'status' => ['required', new Enum(['ATIVO', 'INATIVO'])]
        ];
    }

    public function feedback() {
        return [
            'required' => 'O campo :attribute deve ser preenchido',
            'nome.unique' => 'O nome passado já foi utilizado',
            'nome.max' => 'O nome deve ter no máximo 45 caracteres',
            'status.enum' => 'O status deve ser "ATIVO" ou "INATIVO"',
        ];
    }

    public function diretorias() {
        return $this->hasMany('App\Models\Diretoria');
    }
}