<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Suprimento extends Model
{
    use HasFactory;

    protected $table = 'suprimentos';

    protected $fillable = [
        'produto_id',
        'suprimento_id'
    ];

    public function rules() {
        return [
            'produto_id' => 'sometimes|exists:produtos,id',
            'suprimento_id' => 'sometimes|exists:produtos,id'
        ];
    }

    public function feedback() {
        return [
            'produto_id.exists' => 'O produto não foi encontrado',
            'suprimento_id.exists' => 'O suprimento não foi encontrado',
        ];
    }
}
