<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rule;

class LocalImpressora extends Model
{
    use HasFactory;

    protected $fillable = ['produto_id', 'diretoria_id', 'divisao_id'];

    public function rules($divisaoId, $diretoriaId) 
    {
        return [ 
        'diretoria_id' => 'exists:diretorias,id',
        'divisao_id' => 'exists:divisoes,id'
        ];
    }

    public function feedback($i)
    {
        return [
            'diretoria_id.exists' => 'Uma ou mais das diretorias inseridas não foram encontradas!',
            'divisao_id.exists' => 'Uma ou mais das divisões inseridas não foi encontrada',
        ];
    }
}