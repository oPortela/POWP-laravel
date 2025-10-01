<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pwproduto extends Model
{
    protected $table = 'pwproduto';
    protected $primaryKey = 'codproduto';
    public $timestamps = false;
    protected $fillable = [
        'descricao',
        'codfornec',
        'embalagem',
        'ean',
        'dtcadastro',
    ];
}
