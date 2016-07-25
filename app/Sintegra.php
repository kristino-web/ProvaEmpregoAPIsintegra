<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sintegra extends Model
{
    protected $fillable = [
        'idusuario', 'cnpj', 'resultado_json'
    ];
}
