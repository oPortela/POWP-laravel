<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pwendereco extends Model
{
    protected $table = 'pwendereco';
    protected $primaryKey = 'codendereco';
    public $timestamps = false;
    protected $fillable = [
        'logradouro',
        'numero',
        'cep',
        'bairro',
        'cidade',
        'pais',
    ];
}
