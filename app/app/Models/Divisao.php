<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rules\Enum;

class Divisao extends Model
{
    use HasFactory;

    protected $table = 'divisoes';

    protected $fillable = ['nome', 'status', 'diretoria_id'];

    public function rules($id) {
        return [
            'nome' => 'required|max:45|unique:diretorias,nome,'.$id,
            'status' => 'required|in:ATIVO,INATIVO',
            'diretoria_id' => 'required|exists:diretorias,id'
        ];
    }

    public function feedback() {
        return [
            'required' => 'O campo :attribute deve ser preenchido',
            'nome.max' => 'O nome deve ter no máximo 45 caracteres',
            'nome.unique' => 'O nome inserido já foi utilizado',
            'status.in' => 'O status deve ser "ATIVO" ou "INATIVO"',
            'diretoria_id.required' => 'A diretoria deve ser preenchida',
            'diretoria_id.exists' => 'A diretoria não foi encontrada'
        ];
    }

    public function diretoria() {
        return $this->belongsTo('App\Models\Diretoria');
    }

    public function usuarios() {
        return $this->hasMany('App\Models\Usuario');
    }
}
