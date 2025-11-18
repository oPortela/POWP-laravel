<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PwclienteFisicoJuridico extends Model
{
    use HasFactory;

    protected $table = 'pwclientejuridico';
    protected $primaryKey = 'codcli';
    public $timestamps = false;
    protected $fillable = [
        'cnpj',
        'inscricaoestadual',
    ];
}
