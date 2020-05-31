<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'service_id', 'user_id', 'price','status','acceptPrice'
    ];
}