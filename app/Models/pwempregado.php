<?php
// app/Models/Pwempregado.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pwempregado extends Model
{
    protected $table = 'pwempregado_create';
    
    protected $fillable = [
        'nome',
        'cpf',
        'rg',
        'data_nascimento',
        'data_admissao',
        'data_demissao',
        'contato_id',
        'endereco_id',
        'cargo',
        'salario',
        'descricao'
    ];

    protected $casts = [
        'data_nascimento' => 'date',
        'data_admissao' => 'date',
        'data_demissao' => 'date',
    ];
}