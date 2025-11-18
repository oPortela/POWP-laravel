<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pwtelefone extends Model
{
    use HasFactory;

    protected $table = 'pwtelefone';
    protected $primaryKey = 'codtelefone';
    public $timestamps = false;

    protected $fillable = [
        'telefone',
        'celular',
        'fax'
    ];
}
