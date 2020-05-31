<?php

namespace App\Http\Controllers\dash;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use App\Category;
use App\SubCategory;
class SubCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         $subCategories = SubCategory::paginate(15);
        
         return view('dashboard.subCategories.show',compact('subCategories'));
    }
    public function create()
    {
        $categories = Category::all();
       return view('dashboard.subCategories.create',compact('categories'));
    }

    public function store(Request $request)
    {
        //dd($request);
        // $rules = 
        //    [
        //     'name'     => 'required|string|max:120',
        //     ];

        // $this->validate($request , $rules);
        $data = $request->except('image');
         if ($request->hasFile('image')) {
            $filename = time() . '-' . $request->image->getClientOriginalName();
            $request->image->move(public_path('pictures/subCategories'), $filename);
            $data['image'] = $filename;
        }
        $subCategories = SubCategory::create($data);
        Session::flash('message' , 'تم  اضافة  الخدمة بنجاح ');
        //redirect
        return redirect()->route('subCategories.index');
    }

    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
         $subCategory = SubCategory::where('id',$id)->first();
         $categories = Category::all();
        return view('dashboard.subCategories.edit',compact('subCategory','categories'));
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
        $subCategory = SubCategory::findOrFail($id);
        // $rules = [
        //    'name'     => 'required|string|max:120',
        // ];
        // $this->validate($request ,$rules );
        $data = $request->except('image');
         if ($request->hasFile('image')) {
            $filename = time() . '-' . $request->image->getClientOriginalName();
            $request->image->move(public_path('pictures/subCategories'), $filename);
            $data['image'] = $filename;
        }
        $subCategory->update($data);
        Session::put('message','تم التعديل بشكل ناجح ');
        //redirect
        return redirect()->route('subCategories.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $subCategory = SubCategory::findOrFail($id);

        $subCategory->delete();

        Session::flash('message','تم  المسح بنجاح');

        return redirect()->back();
    }
}
