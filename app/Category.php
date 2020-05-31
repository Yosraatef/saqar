<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
     protected $fillable = [
        'name', 'image','price' ,'commission','is_select'
    ];
    public function subCategories()
    {
        return $this->hasMany('App\SubCategory');
    }
}