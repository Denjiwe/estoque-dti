<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rules\Enum;

class Diretoria extends Model
{
    use HasFactory;

    protected $fillable= ['nome', 'status', 'orgao_id'];

    public function rules() {
        return [
            'nome' => 'required|unique:diretorias',
            'status' => ['required', new Enum(['ATIVO', 'INATIVO'])],
            'orgao_id' => 'required|exists:orgaos,id'
        ];
    }

    public function feedback() {
        return [
            'required' => 'O campo :attribute deve ser preenchido',
            'status.enum' => 'O status deve ser "ATIVO" ou "INATIVO"',
            'nome.max' => 'O nome deve ter no máximo 45 caracteres',
            'nome.unique' => 'O nome passado já foi utilizado',
            'orgao_id.required' => 'O órgão deve ser informado',
            'orgao_id.exists' => 'O órgão passado não pode ser encontrado'
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
