<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Divisao extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    protected $table = 'divisoes';

    protected $fillable = ['nome', 'status', 'diretoria_id', 'email'];

    public function rules($id) {
        return [
            'nome' => 'required|max:45|unique:divisoes,nome,'.$id,
            'status' => 'required|in:ATIVO,INATIVO',
            'diretoria_id' => 'required|exists:diretorias,id',
            'email' => 'nullable|max:100|email|unique:divisoes,email,'.$id
        ];
    }

    public function feedback() {
        return [
            'required' => 'O campo :attribute deve ser preenchido',
            'max' => 'O campo :attribute deve ter no máximo :max caracteres',
            'nome.unique' => 'O nome inserido já foi utilizado',
            'status.in' => 'O status deve ser "ATIVO" ou "INATIVO"',
            'diretoria_id.required' => 'A diretoria deve ser preenchida',
            'diretoria_id.exists' => 'A diretoria não foi encontrada',
            'email.email' => 'O email inserido não é válido',
            'email.unique' => 'O email inserido já foi utilizado!'
        ];
    }

    public function diretoria() {
        return $this->belongsTo('App\Models\Diretoria');
    }

    public function usuarios() {
        return $this->hasMany('App\Models\Usuario');
    }

    public function orgao() {
        return $this->hasOneThrough('App\Models\Orgao', 'App\Models\Diretoria');
    }
}
