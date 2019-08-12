<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    
    protected $fillable = [
        'title', 'name','middle_name', 'last_name','company', 'source','phone','email','address','city','suburb','city',
        'province','position'
    ];
}
