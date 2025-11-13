<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pwcliente extends Model
{
    use HasFactory;

    protected $table = 'pwcliente';
    protected $primaryKey = 'codcliente';
    public $timestamps = false;
    protected $fillable = [
        'codcliente',
        'cliente',
        'fantasia',
        'dtcadastro',
        'tipopessoa',
        'email',
        'codtelefone',
        'codendereco',
        'obs',
        'bloqueio',
        'motivo_bloq'
    ];
}
