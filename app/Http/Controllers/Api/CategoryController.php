<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Category;
use App\SubCategory;
class CategoryController extends Controller
{
   public function getCategory()
    {
      $arr = array();
        $categories = Category::with('subCategories')->get();
        foreach($categories as $category){
        	$subCategories = SubCategory::where('category_id',$category->id)->get();
            array_push($arr, array(
                  "id"=> $category->id,
                  "name" => $category->name,
                  "image" => $category->image,
                  "commission" => $category->commission,
                  "price" => $category->price,
                  "is_select" => $category->is_select,
                  "subCategories" => $subCategories,
                  
            ));
     }
            
           return response()->json(['msg'=>'success','data' => $arr]);
         
    }
}