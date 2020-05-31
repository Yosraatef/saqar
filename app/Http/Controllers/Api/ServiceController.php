<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services;
use App\Image;
use App\User;
use DB;
class ServiceController extends Controller
{
    public function getServices(Request $request)
    {
        //dd($request);
      $arr = array();
        $services = Services::where(['category_id'=>$request->category_id ,'subCategory_id'=>$request->subCategory_id])->get();
        //dd($services);
        foreach($services as $service){
        	$imgs = DB::table('images')->where('service_id',$service->id)->get();
        	$userName = DB::table('users')->where('id',$service->user_id)->first();
        	$catName = DB::table('categories')->where('id',$service->category_id)->value('name');
        	$subCatName = DB::table('sub_categories')->where('id',$service->subCategory_id)->value('name');
            array_push($arr, array(
                  "id"=> $service->id,
                  "address" => $service->address,
                  "long" => $service->long,
                  "lat" => $service->lat,
                  "imageId" => $service->imageId,
                  "Imagelicense" => $service->Imagelicense,
                  "ImageFrontCar" => $service->ImageFrontCar,
                  "ImageBackCar" => $service->ImageBackCar,
                  "PlateNumber" => $service->PlateNumber,
                  "is_available" => $service->is_available,
                  "user_id" => $service->user_id,
                  "userName" => $userName->name,
                  "phone" => $userName->phone,
                  "imageProfile" => $userName->imageProfile,
                  "onAvailable" => $userName->onAvailable,
                  "category_id" => $service->category_id,
                  "catName" =>$catName,
                  "subCatName" => $subCatName,
                  "subCategory_id" => $service->subCategory_id,
                  "imgs" => $imgs,
                  
            ));
     }
            
           return response()->json(['msg'=>'success','data' => $arr]);
         
    }
    public function getNoty(Request $request)
    {
        //dd($request);
      $arr = array();
        $services = Services::where(['category_id'=>$request->category_id ,'subCategory_id'=>$request->subCategory_id])->get();
        //dd($services);
        foreach($services as $service){
        	$imgs = DB::table('images')->where('service_id',$service->id)->get();
        	$userName = DB::table('users')->where('id',$service->user_id)->first();
        	$catName = DB::table('categories')->where('id',$service->category_id)->value('name');
        	$subCatName = DB::table('sub_categories')->where('id',$service->subCategory_id)->value('name');
            array_push($arr, array(
                  "id"=> $service->id,
                  "address" => $service->address,
                  "long" => $service->long,
                  "lat" => $service->lat,
                  "imageId" => $service->imageId,
                  "Imagelicense" => $service->Imagelicense,
                  "ImageFrontCar" => $service->ImageFrontCar,
                  "ImageBackCar" => $service->ImageBackCar,
                  "PlateNumber" => $service->PlateNumber,
                  "is_available" => $service->is_available,
                  "user_id" => $service->user_id,
                  "userName" => $userName->name,
                  "phone" => $userName->phone,
                  "imageProfile" => $userName->imageProfile,
                  "onAvailable" => $userName->onAvailable,
                  "category_id" => $service->category_id,
                  "catName" =>$catName,
                  "subCatName" => $subCatName,
                  "subCategory_id" => $service->subCategory_id,
                  "imgs" => $imgs,
                  
            ));
     }
            
           return response()->json(['msg'=>'success','data' => $arr]);
         
    }
    public function getDetailsServices(Request $request)
    {
        //dd($request);
      //$arr = array();
        $service = Services::where(['id'=>$request->services_id ])->first();
        //dd($services);
        //foreach($services as $service){
        	$imgs = DB::table('images')->where('service_id',$service->id)->get();
        	$userName = DB::table('users')->where('id',$service->user_id)->first();
            array_push($arr, array(
                  "id"=> $service->id,
                  "address" => $service->address,
                  "long" => $service->long,
                  "lat" => $service->lat,
                  "imageId" => $service->imageId,
                  "Imagelicense" => $service->Imagelicense,
                  "ImageFrontCar" => $service->ImageFrontCar,
                  "ImageBackCar" => $service->ImageBackCar,
                  "PlateNumber" => $service->PlateNumber,
                  "is_available" => $service->is_available,
                  "user_id" => $service->user_id,
                  "userName" => $userName->name,
                  "phone" => $userName->phone,
                  "imageProfile" => $userName->imageProfile,
                  "onAvailable" => $userName->onAvailable,
                  "category_id" => $service->category_id,
                  "subCategory_id" => $service->subCategory_id,
                  "imgs" => $imgs,
                  
            ));
     //}
            
           return response()->json(['msg'=>'success','data' => $arr]);
         
    }
    public function search(Request $request)
    {
         $arr = array();
        
         $services = Services::where(['category_id'=>$request->category_id ,'subCategory_id'=>$request->subCategory_id])->where('address','like','%'.$request['address'].'%')
         ->orWhere('long','like','%'.$request['long'].'%')->orWhere('lat','like','%'.$request['lat'].'%')->get();
        
        foreach($services as $service){
        	$imgs = DB::table('images')->where('service_id',$service->id)->get();
        	$userName = DB::table('users')->where('id',$service->user_id)->first();
        	$catName = DB::table('categories')->where('id',$service->category_id)->value('name');
        	$subCatName = DB::table('sub_categories')->where('id',$service->subCategory_id)->value('name');
        array_push($arr, array(
                  "id"=> $service->id,
                  "address" => $service->address,
                  "long" => $service->long,
                  "lat" => $service->lat,
                  "imageId" => $service->imageId,
                  "Imagelicense" => $service->Imagelicense,
                  "ImageFrontCar" => $service->ImageFrontCar,
                  "ImageBackCar" => $service->ImageBackCar,
                  "PlateNumber" => $service->PlateNumber,
                  "is_available" => $service->is_available,
                  "user_id" => $service->user_id,
                  "userName" => $userName->name,
                  "phone" => $userName->phone,
                  "imageProfile" => $userName->imageProfile,
                  "onAvailable" => $userName->onAvailable,
                  "category_id" => $service->category_id,
                  "catName" =>$catName,
                  "subCatName" => $subCatName,
                  "subCategory_id" => $service->subCategory_id,
                  "imgs" => $imgs,
             
        ));
    }
        //echo dd($questions);
        return response()->json(['msg'=>'success','data' => $arr]);
      
    }
    public function addServices(Request $request)
    {   
        $user = auth()->guard('api')->user();
         $validator= validator()->make($request->all(),[
                'address'     => 'required',
            'images'           => 'required',
            'category_id'     => 'required',
            ]);
            
           if($validator->fails()){
            //422 not validation
            return response()->json(['msg' =>'false','data'=>$validator->errors()]);
                                }
        $data = $request->except('Imagelicense','imageId','ImageFrontCar','ImageBackCar','user_id');
          $data['user_id'] = $user->id;
         if ($request->hasFile('Imagelicense')) {
            $filename = time() . '-' . $request->Imagelicense->getClientOriginalName();
            $request->Imagelicense->move(public_path('pictures/services'), $filename);
            $data['Imagelicense'] = $filename;
        }
         if ($request->hasFile('imageId')) {
            $filename = time() . '-' . $request->imageId->getClientOriginalName();
            $request->imageId->move(public_path('pictures/services'), $filename);
             $data['imageId']  = $filename;
        }
         if ($request->hasFile('ImageFrontCar')) {
            $filename = time() . '-' . $request->ImageFrontCar->getClientOriginalName();
            $request->ImageFrontCar->move(public_path('pictures/services'), $filename);
             $data['ImageFrontCar']  = $filename;
        }
        if ($request->hasFile('ImageBackCar')) {
            $filename = time() . '-' . $request->ImageBackCar->getClientOriginalName();
            $request->ImageBackCar->move(public_path('pictures/services'), $filename);
             $data['ImageBackCar']  = $filename;
        }
        $service = Services::create($data);
        //dd(request('images'));
        if ( $request->hasFile('images')) {
            foreach (request('images') as $image) {
            $images = new Image;
            $filename = time() . '-' . $image->getClientOriginalName();
            $image->move(public_path('pictures/images'), $filename);
            $images->image = $filename;

            $images->service_id = $service->id;
             $images->save();
            }
        }
        if($service){
            $saveIsProvider = User::where('id', $service->user_id)->update(['is_provider' => 1]);
              }
        $imgServices = Image::where('service_id',$service->id )->get();
       
        //redirect
       return response()->json(['msg'=>'success','data' => [

        'service' => $service,
        'imgServices' => $imgServices,
        ]]);
    }
}