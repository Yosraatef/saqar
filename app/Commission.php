<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Commission extends Model
{
     protected $fillable = [
        'amountMony', 'imageRecepit','accountNumber','user_id','service_id'
    ];
}