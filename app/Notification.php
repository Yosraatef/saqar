<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $table = 'notifications';
    protected $fillable = [
        'user_id', 'content','type'
    ];
     public function user()
    {
        return $this->belongsTo('App\User');
    }
}