<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pwfornecedor extends Model
{
    use HasFactory;
    
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
