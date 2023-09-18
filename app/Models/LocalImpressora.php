<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class LocalImpressora extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = ['produto_id', 'diretoria_id', 'divisao_id'];

    public function rules()
    {
        return [
        'diretoria_id' => 'exists:diretorias,id',
        'divisao_id' => 'exists:divisoes,id'
        ];
    }

    public function feedback()
    {
        return [
            'diretoria_id.exists' => 'Uma ou mais das diretorias inseridas não foram encontradas!',
            'divisao_id.exists' => 'Uma ou mais das divisões inseridas não foi encontrada',
        ];
    }

    public function produto() {
        return $this->belongsTo('App\Models\Produto');
    }

    public function diretoria() {
        return $this->belongsTo('App\Models\Diretoria');
    }

    public function divisao() {
        return $this->belongsTo('App\Models\Divisao');
    }
}
