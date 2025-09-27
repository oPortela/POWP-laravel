<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pwfornecedor extends Model
{
    protected $table = 'pwfornecedor';
    protected $primaryKey = 'codfornecedor';
    public $timestamps = false;
    protected $fillable = [
        'nome',
        'fantasia',
        'cnpj',
        'dtcadastro',
        'email',
        'codendereco',
        'codtelefone',
        'representante',
    ];
}
