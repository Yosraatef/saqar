<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $fillable = [
        'image', 'service_id'
    ];
     public function service()
    {
        return $this->belongsTo('App\Services');
    }
}
