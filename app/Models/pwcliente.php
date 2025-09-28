<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Pwcliente extends Model
{

    protected $primaryKey = 'id';

    protected $fillable = [
        'data_cadastro',
        'tipo_pessoa',
        'observacoes'
    ];

    protected $casts = [
        'data_cadastro' => 'date',
    ];

}