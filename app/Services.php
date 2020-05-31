<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Services extends Model
{
   protected $fillable = [
        'address', 'long', 'lat','imageId','price','is_available','user_id','subCategory_id','category_id','Imagelicense','ImageFrontCar','ImageBackCar','PlateNumber','imageId'
    ];
     protected $casts = [
        'long' => 'double',
        'lat' => 'double',
    ];
    public function user()
    {
        return $this->belongsTo('App\User');
    }
     public function images()
    {
        return $this->hasMany('App\Image');
    }
}