<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PwclienteFisico extends Model
{
    use HasFactory;

    protected $table = 'pwclientefisico';
    protected $primaryKey = 'codcli';
    public $timestamps = false;
    protected $fillable = [
        'cpf',
        'rg',
        'dt_nascimento',
    ];
}
