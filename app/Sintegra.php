<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sintegra extends Model
{
    protected $fillable = [
        'user_id', 'cnpj', 'resultado_json'
    ];

    public function User(){
	      return $this->belongsTo('App\User');
	}
}
