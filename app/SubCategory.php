<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    protected $fillable = [
        'name', 'image', 'size_bus','size_clean','size_surfaces','category_id'
    ];
    public function category()
    {
        return $this->belongsTo('App\Category');
    }
}
