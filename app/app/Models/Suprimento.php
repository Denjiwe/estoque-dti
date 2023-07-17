<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use App\Models\Produto;

class Suprimento extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    protected $table = 'suprimentos';

    protected $fillable = [
        'produto_id',
        'suprimento_id',
        'em_uso',
        'tipo_suprimento'
    ];

    public function rules($suprimentoId, $emUso) {
        return [
            'suprimento' => 'required|exists:produtos,id',
            'em_uso' => 'required|in:SIM,NAO'
        ];
    }

    public function feedback() {
        return [
            'suprimento_id.required' => 'O id do suprimento deve ser informado',
            'suprimento_id.exists' => 'O suprimento não foi encontrado',
            'em_uso.required' => 'O campo em uso deve ser informado',
            'em_uso.in' => 'O campo em uso deve ser SIM ou NAO',
        ];
    }

    public function impressoras() {
        return $this->belongsToMany(Produto::class)->orderBy('id');
    }
}
