<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class ItensSolicitacao extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    protected $table = 'itens_solicitacoes';

    protected $fillable = [
        'qntde',
        'produto_id',
        'solicitacao_id'
    ];

    public function rules() {
        return [
            'qntde' => 'required|integer|max:2',
            'produto_id' => 'required|exists:produtos,id',
            'solicitacao_id' => 'required|exists:solicitacoes,id'
        ];
    }

    public function feedback() {
        return [
            'qntde.required' => 'A quantidade deve ser preenchida',
            'qntde.integer' => 'A quantidade deve um número inteiro',
            'qntde.max' => 'A quantidade máxima é de :max produtos',
            'produto_id.required' => 'O produto deve ser preenchido',
            'produto_id.exists' => 'O produto não foi encontrado',
            'solicitacao_id.required' => 'A solicitação deve ser passada',
            'solicitacao_id.exists' => 'A solicitação não foi encontrada',
        ];
    }

    public function entregas() {
        return $this->hasMany('App\Models\Entrega');
    }

    public function produto() {
        return $this->belongsTo('App\Models\Produto');
    }

    public function solicitacao() {
        return $this->belongsTo('App\Models\Solicitacao');
    }
}
