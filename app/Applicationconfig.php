<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Applicationconfig extends Model
{
    //
    protected $table = 'applicationconfigs';
    protected $fillable = [
        'parametername','parametervalue','createdby','parameterslug'          
    ];
}
