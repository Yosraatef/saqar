<?php

namespace App\Http\Controllers\dash;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use App\Services;
use App\Category;
use App\SubCategory;
use App\User;
use App\Image;
use DB;
class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         $services = Services::paginate(15);

         return view('dashboard.services.show',compact('services'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {  
        $service = Services::all();
        $users = User::all();
        $categories = Category::all();
        $subCategories = SubCategory::all();
        return view('dashboard.services.create' ,compact('service','users','subCategories',
            'categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = 
           [
            'address'     => 'required',
            'user_id'     => 'required',
            'category_id'     => 'required',
            ];

        $this->validate($request , $rules);
        $data = $request->except('Imagelicense','imageId','ImageFrontCar','ImageBackCar');
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
        
        //Session
        Session::flash('message' , 'تم  اضافة  مزود خدمه    ');
        //redirect
        return redirect()->route('services.index');
    }

    public function available(Request $request, $id)
    {
        $service = Services::find($id);
       //dd($service);
              if($service->is_available == 0)
              {
                  
               $xx = DB::table('services')->where('id',$id)->update(['is_available' => 1]);

                return redirect()->route('services.index');
            }
            else 
              {

                 $xx = DB::table('services')->where('id',$id)->update(['is_available' => 0]);
                // dd($xx);
                return redirect()->route('services.index');
              }
}

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
          $service = Services::where('id',$id)->first();
         $users = User::all();
        $categories = Category::all();
        $subCategories = SubCategory::all();
        $images = Image::where('service_id', $service->id)->get();
       // dd($images);
        return view('dashboard.services.edit',compact('service','categories','users','subCategories','images'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $service = Services::findOrFail($id);
         $rules = 
           [
            'address'     => 'required',
            'user_id'     => 'required',
            'category_id'     => 'required',
            ];

        $this->validate($request , $rules);
        $data = $request->except('Imagelicense','imageId','ImageFrontCar','ImageBackCar');
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
        $service = Services::update($data);
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
        
        Session::put('message','تم التعديل  المنتج  ');
        //redirect
        return redirect()->route('products.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Services::findOrFail($id);

        $product->delete();

        Session::flash('message','تم  المسح بنجاح');

        return redirect()->back();
    }
    public function getSubCategories($id)
    {  
        $test=0;
        $category=Category::find($id)->name;
        // if($category=='النقل الجماعي')
        // $test=1;
        // if($category=='حاويات نظافة')
        // $test=2;
        // if($category=='السطحات')
        // $test=3;
        $subCategories = SubCategory::where('category_id', $id)->get();
       // dd('jmkij') ;
       //  return $subCategories;
       // return response()->json(null);

        return json_encode(['data1'=>$subCategories,'test'=>$test]);
    }
    public function getSubCat()
    {
        $data = '<option selected disabled>اختر القسم المناسب</option>';
        $categories = SubCategory::where('category_id', request('category_id'))->get();
        if (count($categories) > 0) {
            foreach ($categories as $category) {
                $data .= '<option value="'.$category->id.'">'.$category->name.'</option>';
            }

            return response()->json(['categories' => $data]);
        } else {
            return response()->json(['categories' => 1]);
        }
    }
}