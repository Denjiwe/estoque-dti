<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Auditoria extends Model
{
    use HasFactory;

    protected $table= 'audits';

    public function usuario() {
        return $this->belongsTo('App\Models\Usuario', 'usuario_id');
    }
}
